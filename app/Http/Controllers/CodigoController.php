<?php

namespace App\Http\Controllers;

use App\Models\Codigo;
use App\Models\Mezcla;
use App\Models\Product;
use Illuminate\Http\Request;

class CodigoController extends Controller
{
    public function create(Mezcla $mezcla)
    {
        return view('codigos.create', compact('mezcla'));
    }

    public function createGeneral()
    {
        $mezclas = Mezcla::all();
        return view('codigos.create-general', compact('mezclas'));
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $codigos = Codigo::with('mezcla')
            ->when($search, function($query, $search) {
                return $query->where('codigo', 'like', "%{$search}%")
                           ->orWhereHas('mezcla', function($q) use ($search) {
                               $q->where('nombre', 'like', "%{$search}%");
                           });
            })
            ->get();
            
        return view('codigos.index', compact('codigos', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mezcla_id' => 'required|exists:mezclas,id',
            'codigo' => 'required|string|unique:codigos'
        ], [
            'codigo.unique' => 'El código ya ha sido tomado.',
            'codigo.required' => 'El campo código es obligatorio.',
            'mezcla_id.required' => 'El campo mezcla es obligatorio.',
            'mezcla_id.exists' => 'La mezcla seleccionada es inválida.'
        ]);

        Codigo::create($request->only('mezcla_id', 'codigo'));

        return redirect()->route('mezclas.show', $request->mezcla_id)->with('success', 'Código creado exitosamente');
    }

    public function productos(Codigo $codigo)
    {
        $productos = Product::where('active', true)->get();
        $productosAsociados = $codigo->productos()->get();
        return view('codigos.productos', compact('codigo', 'productos', 'productosAsociados'));
    }

    public function storeProducto(Request $request, Codigo $codigo)
    {
        $request->validate([
            'producto_id' => 'required|exists:products,id',
            'cantidad' => 'required|numeric|min:0.01'
        ], [
            'producto_id.required' => 'El campo producto es obligatorio.',
            'producto_id.exists' => 'El producto seleccionado es inválido.',
            'cantidad.required' => 'El campo cantidad es obligatorio.',
            'cantidad.numeric' => 'La cantidad debe ser un número.',
            'cantidad.min' => 'La cantidad debe ser al menos 0.01.'
        ]);

        $codigo->productos()->attach($request->producto_id, ['cantidad' => $request->cantidad]);

        return back()->with('success', 'Producto agregado exitosamente');
    }

    public function storeMultipleProductos(Request $request, Codigo $codigo)
    {
        $productos = $request->input('productos', []);
        $addedCount = 0;
        
        foreach ($productos as $productId) {
            // Verificar si ya existe
            if (!$codigo->productos()->where('producto_id', $productId)->exists()) {
                $producto = Product::find($productId);
                $cantidad = $producto->cantidad_producto ?? 1;
                $codigo->productos()->attach($productId, ['cantidad' => $cantidad]);
                $addedCount++;
            }
        }
        
        if ($addedCount > 0) {
            return back()->with('success', "$addedCount productos agregados exitosamente");
        }
        
        return back()->with('error', 'No se seleccionaron productos o ya están asociados');
    }

    public function destroyProducto(Codigo $codigo, Product $producto)
    {
        $codigo->productos()->detach($producto->id);
        return back()->with('success', 'Producto eliminado exitosamente');
    }

    public function edit(Codigo $codigo)
    {
        $mezclas = Mezcla::all();
        return view('codigos.edit', compact('codigo', 'mezclas'));
    }

    public function update(Request $request, Codigo $codigo)
    {
        $request->validate([
            'mezcla_id' => 'required|exists:mezclas,id',
            'codigo' => 'required|string|unique:codigos,codigo,' . $codigo->id
        ], [
            'codigo.unique' => 'El código ya ha sido tomado.',
            'codigo.required' => 'El campo código es obligatorio.',
            'mezcla_id.required' => 'El campo mezcla es obligatorio.',
            'mezcla_id.exists' => 'La mezcla seleccionada es inválida.'
        ]);

        $codigo->update($request->only('mezcla_id', 'codigo'));

        return redirect()->route('mezclas.show', $codigo->mezcla_id)->with('success', 'Código actualizado exitosamente');
    }
}