<?php

namespace App\Http\Controllers;

use App\Models\Codigo;
use App\Models\Product;
use App\Models\Mezcla;
use Illuminate\Http\Request;

class CodigoProductController extends Controller
{
    public function show(Codigo $codigo)
    {
        $productos = Product::where('active', true)->get();
        $productosAsociados = $codigo->productos()->withPivot('id')->get();
        
        return view('codigos.productos', compact('codigo', 'productos', 'productosAsociados'));
    }

    public function store(Request $request, Codigo $codigo)
    {
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*' => 'exists:products,id'
        ]);

        foreach ($request->productos as $productoId) {
            // Verificar si ya existe la relación
            if (!$codigo->productos()->where('producto_id', $productoId)->exists()) {
                Mezcla::create([
                    'nombre_mezcla' => $codigo->codigo,
                    'cantidad_aplicacion' => 0,
                    'producto_id' => $productoId,
                    'codigo_id' => $codigo->id
                ]);
            }
        }

        return redirect()->route('codigos.productos', $codigo)->with('success', 'Productos agregados exitosamente');
    }

    public function destroy(Codigo $codigo, $mezclaId)
    {
        Mezcla::where('id', $mezclaId)->where('codigo_id', $codigo->id)->delete();
        
        return redirect()->route('codigos.productos', $codigo)->with('success', 'Producto eliminado exitosamente');
    }
}