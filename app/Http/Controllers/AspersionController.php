<?php

namespace App\Http\Controllers;

use App\Models\Aspersion;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AspersionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Si es una finca logueada
        if (session('finca_logged')) {
            $fincaId = session('finca_id');
            $aspersions = Aspersion::where('finca_id', $fincaId)
                                 ->with(['products', 'codigo.mezcla'])
                                 ->latest()
                                 ->paginate(15);
        } elseif ($user && $user->isAdmin()) {
            $aspersions = Aspersion::with(['finca', 'user', 'products', 'codigo.mezcla'])->latest()->paginate(15);
        } else {
            $aspersions = Aspersion::where('finca_id', $user->finca_id)
                                 ->with(['products', 'codigo.mezcla'])
                                 ->latest()
                                 ->paginate(15);
        }
        
        return view('aspersions.index', compact('aspersions'));
    }

    public function create()
    {
        $categories = ProductCategory::with('products')->get();
        $codigos = \App\Models\Codigo::with('mezcla')->get();
        
        // Obtener hectáreas máximas de la finca
        $maxHectares = session('finca_logged') 
            ? session('finca_hectares') 
            : (Auth::user()->finca_id ? \App\Models\Finca::find(Auth::user()->finca_id)->hectares ?? 0 : 0);
            
        return view('aspersions.create', compact('categories', 'maxHectares', 'codigos'));
    }

    public function store(Request $request)
    {
        // Obtener hectáreas máximas de la finca
        $maxHectares = session('finca_logged') 
            ? session('finca_hectares') 
            : (Auth::user()->finca_id ? \App\Models\Finca::find(Auth::user()->finca_id)->hectares ?? 0 : 0);
            
        $request->validate([
            'application_date' => 'required|date',
            'volumen_ha' => "required|numeric|min:0.01|max:{$maxHectares}",
            'codigo_id' => 'nullable|exists:codigos,id',
            'aspersed_lots' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
            'mix_description' => 'nullable|string'
        ], [
            'volumen_ha.max' => "El volumen por hectárea no puede superar las {$maxHectares} hectáreas de la finca.",
            'volumen_ha.required' => 'El volumen por hectárea es obligatorio.',
            'volumen_ha.numeric' => 'El volumen por hectárea debe ser un número.',
            'volumen_ha.min' => 'El volumen por hectárea debe ser mayor a 0.'
        ]);

        $weekNumber = $this->calculateWeekNumber($request->application_date);
        
        // Determinar finca_id y user_id según el tipo de sesión
        $fincaId = session('finca_logged') ? session('finca_id') : Auth::user()->finca_id;
        $userId = session('finca_logged') ? null : Auth::id();
        
        $aspersion = Aspersion::create([
            'finca_id' => $fincaId,
            'user_id' => $userId,
            'application_date' => $request->application_date,
            'week_number' => $weekNumber,
            'hectares' => $request->volumen_ha,
            'mix_code_id' => $request->codigo_id,
            'aspersed_lots' => $request->aspersed_lots,
            'mix_description' => $request->mix_description
        ]);

        foreach ($request->products as $product) {
            $aspersion->products()->attach($product['id'], [
                'quantity' => $product['quantity']
            ]);
        }

        return redirect()->route('aspersions.index')
                        ->with('success', 'Aspersión registrada exitosamente');
    }

    private function calculateWeekNumber($date)
    {
        $carbon = Carbon::parse($date);
        return $carbon->weekOfYear;
    }

    public function show(Aspersion $aspersion)
    {
        $aspersion->load(['finca', 'user', 'products']);
        return view('aspersions.show', compact('aspersion'));
    }

    public function getMixCodes(Request $request)
    {
        $productIds = $request->input('product_ids', []);
        
        if (empty($productIds)) {
            return response()->json([]);
        }
        
        $mixCodes = \App\Models\MixCode::whereHas('products', function($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->get(['id', 'mix_type', 'mix_code']);
        
        return response()->json($mixCodes);
    }

    public function getCodigoProducts(Request $request)
    {
        $codigoId = $request->input('codigo_id');
        
        if (!$codigoId) {
            return response()->json([]);
        }
        
        $codigo = \App\Models\Codigo::with('productos')->find($codigoId);
        
        if (!$codigo) {
            return response()->json([]);
        }
        
        $products = $codigo->productos->map(function($product) {
            return [
                'id' => $product->id,
                'commercial_name' => $product->commercial_name,
                'active_ingredient' => $product->active_ingredient,
                'unit' => $product->unit,
                'quantity' => $product->pivot->cantidad,
                'category_name' => $product->category->name ?? 'N/A'
            ];
        });
        
        return response()->json($products);
    }
}