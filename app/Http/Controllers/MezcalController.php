<?php

namespace App\Http\Controllers;

use App\Models\Mezcla;
use App\Models\Product;
use App\Models\Codigo;
use Illuminate\Http\Request;

class MezcalController extends Controller
{
    public function index()
    {
        $mezclas = Mezcla::with('codigos')->paginate(10);
        return view('mezclas.index', compact('mezclas'));
    }

    public function create()
    {
        $productos = Product::where('active', true)->with('category')->get();
        $codigos = Codigo::all();
        $categorias = \App\Models\ProductCategory::all();
        return view('mezclas.create', compact('productos', 'codigos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_mezcla' => 'required|string|max:255',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:products,id',
            'productos.*.cantidad_aplicacion' => 'required|numeric|min:0.01',
            'codigo_id' => 'required|exists:codigos,id'
        ]);

        foreach ($request->productos as $producto) {
            Mezcal::create([
                'nombre_mezcla' => $request->nombre_mezcla,
                'cantidad_aplicacion' => $producto['cantidad_aplicacion'],
                'producto_id' => $producto['id'],
                'codigo_id' => $request->codigo_id
            ]);
        }

        return redirect()->route('mezclas.index')->with('success', 'Mezcla creada exitosamente');
    }

    public function show(Mezcla $mezcla)
    {
        $mezcla->load('codigos');
        return view('mezclas.show', compact('mezcla'));
    }

    public function edit(Mezcal $mezcal)
    {
        $productos = Product::where('active', true)->get();
        $codigos = Codigo::all();
        return view('mezclas.edit', compact('mezcal', 'productos', 'codigos'));
    }

    public function update(Request $request, Mezcal $mezcal)
    {
        $request->validate([
            'nombre_mezcla' => 'required|string|max:255',
            'cantidad_aplicacion' => 'required|numeric|min:0.01',
            'producto_id' => 'required|exists:products,id',
            'codigo_id' => 'required|exists:codigos,id'
        ]);

        $mezcal->update($request->all());

        return redirect()->route('mezclas.index')->with('success', 'Mezcla actualizada exitosamente');
    }

    public function destroy(Mezcal $mezcal)
    {
        $mezcal->delete();
        return redirect()->route('mezclas.index')->with('success', 'Mezcla eliminada exitosamente');
    }
}