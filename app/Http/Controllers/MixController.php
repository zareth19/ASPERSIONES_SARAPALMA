<?php

namespace App\Http\Controllers;

use App\Models\Mix;
use App\Models\Product;
use Illuminate\Http\Request;

class MixController extends Controller
{
    public function index()
    {
        $mixes = Mix::with('product')
                    ->join('products', 'mixes.product_id', '=', 'products.id')
                    ->orderBy('products.commercial_name')
                    ->orderBy('mixes.code')
                    ->select('mixes.*')
                    ->paginate(10);
        return view('mixes.index', compact('mixes'));
    }

    public function create()
    {
        $products = Product::where('active', true)->get();
        return view('mixes.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:mixes',
            'product_id' => 'required|exists:products,id'
        ]);

        Mix::create($request->all());

        return redirect()->route('mixes.index')->with('success', 'Mezcla creada exitosamente');
    }

    public function edit(Mix $mix)
    {
        $products = Product::where('active', true)->get();
        return view('mixes.edit', compact('mix', 'products'));
    }

    public function update(Request $request, Mix $mix)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:mixes,code,' . $mix->id,
            'product_id' => 'required|exists:products,id'
        ]);

        $mix->update($request->all());

        return redirect()->route('mixes.index')->with('success', 'Mezcla actualizada exitosamente');
    }

    public function destroy(Mix $mix)
    {
        $mix->delete();
        return redirect()->route('mixes.index')->with('success', 'Mezcla eliminada exitosamente');
    }

    public function grouped()
    {
        $productGroups = Product::with('mixes')
                               ->whereHas('mixes')
                               ->orderBy('commercial_name')
                               ->get();
        return view('mixes.grouped', compact('productGroups'));
    }
}