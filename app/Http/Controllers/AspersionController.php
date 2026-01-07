<?php

namespace App\Http\Controllers;

use App\Models\Aspersion;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AspersionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Verificar si la tabla pivot 'aspersion_codigo' existe (usando config cacheada)
        $hasCodesPivot = config('database_tables.aspersion_codigo_exists', false);
        
        // Construir eager-load dinámicamente según disponibilidad de tabla
        $relations = $hasCodesPivot ? ['products', 'codigo.mezcla', 'codigos.mezcla'] : ['products', 'codigo.mezcla'];
        
        // Si es una finca logueada
        if (session('finca_logged')) {
            $fincaId = session('finca_id');
            $aspersions = Aspersion::where('finca_id', $fincaId)
                                 ->with($relations)
                                 ->latest()
                                 ->paginate(15);
        } elseif ($this->userIsAdmin($user)) {
            $aspersions = Aspersion::with(array_merge(['finca', 'user'], $relations))->latest()->paginate(15);
        } else {
            $aspersions = Aspersion::where('finca_id', $user->finca_id)
                                 ->with($relations)
                                 ->latest()
                                 ->paginate(15);
        }
        
        return view('aspersions.index', compact('aspersions'));
    }

    public function create()
    {
        $showProducts = !session('finca_logged');
        $categories = ProductCategory::all(); // Obtener todas las categorías de productos
        $codigosExistentes = \App\Models\Codigo::with('mezcla:id,nombre')
            ->select('id', 'codigo', 'mezcla_id')
            ->get()
            ->transform(function ($codigo) {
                return [
                    'id' => $codigo->id,
                    'code' => $codigo->codigo,
                    'mezcla' => $codigo->mezcla?->nombre ?? 'Sin nombre',
                ];
            });
        
        // Obtener hectáreas máximas de la finca
        $maxHectares = session('finca_logged') 
            ? session('finca_hectares') 
            : (Auth::user()->finca_id ? \App\Models\Finca::find(Auth::user()->finca_id)->hectares ?? 0 : 0);
            
        return view('aspersions.create', compact('categories', 'maxHectares', 'codigosExistentes', 'showProducts'));
    }

    public function store(Request $request)
    {
        // Obtener hectáreas máximas de la finca
        $maxHectares = session('finca_logged') 
            ? session('finca_hectares') 
            : (Auth::user()->finca_id ? \App\Models\Finca::find(Auth::user()->finca_id)->hectares ?? 0 : 0);
            
        $fincaLogged = session('finca_logged');

        $rules = [
            'application_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:2020-01-01',
                'before_or_equal:' . date('Y-m-d', strtotime('+1 year'))
            ],
            'volumen_ha' => [
                'required',
                'numeric',
                'min:0.01',
                "max:{$maxHectares}",
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'codigo_id' => [
                'nullable',
                'integer',
                'exists:codigos,id',
                function ($attribute, $value, $fail) {
                    if ($value !== null && (!is_numeric($value) || $value <= 0)) {
                        $fail('Código inválido.');
                    }
                }
            ],
            'aspersed_lots' => [
                'nullable',
                'string',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if ($value && preg_match('/[<>"\'\/\\]/', $value)) {
                        $fail('Los lotes contienen caracteres no permitidos.');
                    }
                }
            ],
            'mix_description' => [
                'nullable',
                'string',
                'max:2000',
                function ($attribute, $value, $fail) {
                    if ($value && preg_match('/[<>"\'\/\\]/', $value)) {
                        $fail('La descripción contiene caracteres no permitidos.');
                    }
                }
            ],
            'categories' => 'nullable|array|max:10',
            'categories.*' => [
                'nullable',
                'integer',
                'exists:product_categories,id',
                function ($attribute, $value, $fail) {
                    if ($value !== null && (!is_numeric($value) || $value <= 0)) {
                        $fail('Categoría inválida.');
                    }
                }
            ]
        ];

        // Solo usuarios no finca deben seleccionar productos
        if (! $fincaLogged) {
            $rules['products'] = 'required|array|min:1';
            $rules['products.*.id'] = 'required|exists:products,id';
            $rules['products.*.quantity'] = 'required|numeric|min:0.01';
        }

        $request->validate($rules, [
            'volumen_ha.max' => "El volumen por hectárea no puede superar las {$maxHectares} hectáreas de la finca.",
            'volumen_ha.required' => 'El volumen por hectárea es obligatorio.',
            'volumen_ha.numeric' => 'El volumen por hectárea debe ser un número.',
            'volumen_ha.min' => 'El volumen por hectárea debe ser mayor a 0.'
        ]);

        $weekNumber = $this->calculateWeekNumber($request->application_date);
        
        // Determinar finca_id y user_id según el tipo de sesión
        $fincaId = session('finca_logged') ? session('finca_id') : Auth::user()->finca_id;
        $userId = session('finca_logged') ? null : Auth::id();
        
        // Determinar el código de mezcla seleccionado (aceptar codigo_id o el primer codigo_ids[])
        $codigoId = $request->input('codigo_id') ?? null;
        if (!$codigoId) {
            $codigoIds = $request->input('codigo_ids', []);
            if (is_array($codigoIds) && count($codigoIds) > 0) {
                $codigoId = $codigoIds[0] ?: null;
            }
        }

        // Obtener la primera categoría si se envían múltiples
        $categoryId = null;
        $categories = $request->input('categories', []);
        if (is_array($categories) && count($categories) > 0) {
            $categoryId = $categories[0] ?: null;
        }

        // Sanitizar datos de entrada
        $sanitizedData = [
            'finca_id' => $fincaId,
            'user_id' => $userId,
            'application_date' => $request->application_date,
            'week_number' => $weekNumber,
            'hectares' => round((float) $request->volumen_ha, 2),
            'mix_code_id' => $codigoId,
            'aspersed_lots' => $request->aspersed_lots ? strip_tags(trim($request->aspersed_lots)) : null,
            'mix_description' => $request->mix_description ? strip_tags(trim($request->mix_description)) : null,
            'category' => $categoryId
        ];
        
        // Validaciones adicionales de seguridad
        if ($sanitizedData['hectares'] <= 0 || $sanitizedData['hectares'] > $maxHectares) {
            return back()->withErrors(['volumen_ha' => 'Volumen inválido'])->withInput();
        }
        
        $aspersion = Aspersion::create($sanitizedData);

        // Adjuntar todos los códigos seleccionados en el pivot (si se enviaron)
        $codigoIdsToAttach = [];
        $codigoIdsFromInput = $request->input('codigo_ids', []);
        if (is_array($codigoIdsFromInput) && count($codigoIdsFromInput) > 0) {
            // filtrar vacíos y convertir a enteros
            $codigoIdsToAttach = array_values(array_filter(array_map('intval', $codigoIdsFromInput)));
        } elseif ($codigoId) {
            $codigoIdsToAttach = [$codigoId];
        }

        // Solo sincronizar si la tabla pivot existe (usando config cacheada)
        if (!empty($codigoIdsToAttach) && config('database_tables.aspersion_codigo_exists', false)) {
            try {
                $aspersion->codigos()->sync($codigoIdsToAttach);
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('Error syncing códigos: ' . $e->getMessage());
                // Tabla pivot no existe o error de DB específico
            } catch (\Exception $e) {
                Log::error('Unexpected error syncing códigos: ' . $e->getMessage());
                // Re-lanzar errores inesperados
                throw $e;
            }
        }

        // Si no es una sesión de finca, adjuntar productos
        if (! session('finca_logged')) {
            $products = $this->validateProductsArray($request);
            foreach ($products as $product) {
                $aspersion->products()->attach($product['id'], [
                    'quantity' => $product['quantity']
                ]);
            }
        }

        return redirect()->route('aspersions.index')
                        ->with('success', 'Aspersión registrada exitosamente');
    }

    private function calculateWeekNumber($date)
    {
        $carbon = Carbon::parse($date);
        return $carbon->weekOfYear;
    }

    /**
     * Check if the given user is an administrator using multiple fallbacks:
     * - is_admin attribute
     * - hasRole('admin') method (e.g. Spatie roles)
     * - role / role->name attribute
     */
    private function userIsAdmin($user)
    {
        if (!$user) {
            return false;
        }

        // Attribute flag
        if (isset($user->is_admin)) {
            return (bool) $user->is_admin;
        }

        // Common role-checking method (e.g. Spatie)
        if (method_exists($user, 'hasRole')) {
            return $user->hasRole('admin');
        }

        // If a role string or object exists
        if (isset($user->role)) {
            if (is_string($user->role)) {
                return strtolower($user->role) === 'admin';
            }
            if (is_object($user->role) && isset($user->role->name)) {
                return strtolower($user->role->name) === 'admin';
            }
        }

        // Fallback: check method if implemented
        if (method_exists($user, 'isAdmin')) {
            return $user->isAdmin();
        }

        return false;
    }

    public function show(Aspersion $aspersion)
    {
        $aspersion->load(['finca', 'user', 'products']);
        return view('aspersions.show', compact('aspersion'));
    }

    public function getMixCodes(Request $request)
    {
        $codigo = $request->input('codigo');
        
        if (empty($codigo)) {
            return response()->json([]);
        }
        
        // Buscar códigos que coincidan parcialmente
        $codigos = \App\Models\Codigo::with('mezcla')
            ->where('codigo', 'like', $codigo . '%')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'codigo' => $item->codigo,
                    'nombre_mezcla' => $item->mezcla?->nombre ?? 'Sin mezcla',
                    'categoria' => 'General' // Por ahora categoría fija hasta implementar relación
                ];
            });
        
        return response()->json($codigos);
    }

    public function getCodigoProducts(Request $request)
    {
        // Por política: si la sesión es de finca, no exponer productos
        if (session('finca_logged')) {
            return response()->json([]);
        }

        $codigoId = $request->input('codigo_id');
        
        if (!$codigoId) {
            return response()->json([]);
        }
        
        $codigo = \App\Models\Codigo::with('products.category')->find($codigoId);
        
        if (!$codigo) {
            return response()->json([]);
        }
        
        $products = $codigo->products->map(function($product) {
            if (!$product) {
                return null;
            }
            return [
                'id' => $product->id ?? 0,
                'commercial_name' => $product->name ?? 'Sin nombre',
                'active_ingredient' => $product->ingredient ?? 'Sin ingrediente',
                'category_name' => $product->category?->name ?? 'Sin categoría',
                'quantity' => $product->pivot?->quantity ?? 1
            ];
        })->filter();
        
        return response()->json($products);
    }
    
    /**
     * Validar que el array de productos existe antes de iteración
     */
    private function validateProductsArray(Request $request)
    {
        $products = $request->input('products', []);
        if (!is_array($products)) {
            return [];
        }
        
        return array_filter($products, function($product) {
            return is_array($product) && 
                   isset($product['id']) && 
                   isset($product['quantity']) && 
                   is_numeric($product['id']) && 
                   is_numeric($product['quantity']);
        });
    }

    public function createNew()
    {
        $categories = ProductCategory::all();
        return view('aspersions.create_new', compact('categories'));
    }

    public function storeNew(Request $request)
    {
        $request->validate([
            'mix_name' => 'required|string|max:255',
            'codigos' => 'required|array|min:1',
            'codigos.*' => 'required|string',
            'application_date' => 'required|date',
            'volumen_ha' => 'required|numeric|min:0.01',
            'aspersed_lots' => 'nullable|string',
            'mix_description' => 'nullable|string',
            'productos' => 'required|array'
        ]);

        $weekNumber = $this->calculateWeekNumber($request->application_date);
        $fincaId = session('finca_logged') ? session('finca_id') : Auth::user()->finca_id;
        $userId = session('finca_logged') ? null : Auth::id();

        // Crear la aspersión
        $aspersion = Aspersion::create([
            'finca_id' => $fincaId,
            'user_id' => $userId,
            'application_date' => $request->application_date,
            'week_number' => $weekNumber,
            'hectares' => $request->volumen_ha,
            'aspersed_lots' => $request->aspersed_lots,
            'mix_description' => $request->mix_description . ' - Mezcla: ' . $request->mix_name
        ]);

        // Crear códigos y asociar productos
        foreach ($request->codigos as $codigoIndex => $codigoValue) {
            // Crear o encontrar el código
            $codigo = \App\Models\Codigo::firstOrCreate([
                'codigo' => $codigoValue
            ], [
                'mezcla_id' => null // Se puede asociar a una mezcla después
            ]);

            // Asociar productos a este código si existen
            if (isset($request->productos[$codigoIndex])) {
                foreach ($request->productos[$codigoIndex] as $producto) {
                    if (isset($producto['name']) && isset($producto['quantity'])) {
                        // Buscar el producto por nombre
                        $productModel = Product::where('commercial_name', 'like', '%' . $producto['name'] . '%')
                                              ->where('active', true)
                                              ->first();
                        
                        if ($productModel) {
                            // Asociar producto al código si no existe la relación
                            if (!$codigo->products()->where('product_id', $productModel->id)->exists()) {
                                $codigo->products()->attach($productModel->id, [
                                    'quantity' => $producto['quantity']
                                ]);
                            }
                            
                            // Asociar producto a la aspersión
                            $aspersion->products()->attach($productModel->id, [
                                'quantity' => $producto['quantity']
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('aspersions.index')
                        ->with('success', 'Mezcla creada exitosamente');
    }
}