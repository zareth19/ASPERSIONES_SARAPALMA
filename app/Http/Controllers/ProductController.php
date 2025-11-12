<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(15);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'commercial_name' => 'required|string|max:255',
            'active_ingredient' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'category_id' => 'required|exists:product_categories,id'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'commercial_name' => 'required|string|max:255',
            'active_ingredient' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'category_id' => 'required|exists:product_categories,id',
            'active' => 'boolean'
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        $product->update(['active' => false]);
        return redirect()->route('products.index')->with('success', 'Producto desactivado exitosamente');
    }
}