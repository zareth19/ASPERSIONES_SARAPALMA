<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $products = Product::with('category')
            ->when($search, function($query, $search) {
                return $query->where('commercial_name', 'like', "%{$search}%")
                           ->orWhere('active_ingredient', 'like', "%{$search}%")
                           ->orWhereHas('category', function($q) use ($search) {
                               $q->where('name', 'like', "%{$search}%");
                           });
            })
            ->paginate(15);
            
        return view('products.index', compact('products', 'search'));
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
            'category_id' => 'required|exists:product_categories,id',
            'cantidad_producto' => 'nullable|numeric|min:0'
        ], [
            'commercial_name.required' => 'El nombre comercial es obligatorio.',
            'active_ingredient.required' => 'El ingrediente activo es obligatorio.',
            'unit.required' => 'La unidad es obligatoria.',
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no es válida.'
        ]);

        Product::create([
            'commercial_name' => $request->commercial_name,
            'active_ingredient' => $request->active_ingredient,
            'unit' => $request->unit,
            'cantidad_producto' => $request->cantidad_producto,
            'category_id' => $request->category_id,
            'active' => true
        ]);

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

    public function checkExists(Request $request)
    {
        $exists = Product::where('commercial_name', 'like', '%' . $request->name . '%')
                        ->where('active', true)
                        ->exists();
        
        return response()->json(['exists' => $exists]);
    }

    public function storeAjax(Request $request)
    {
        try {
            $request->validate([
                'commercial_name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255'
                ],
                'active_ingredient' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255'
                ],
                'category_id' => [
                    'required',
                    'integer',
                    'exists:product_categories,id',
                    function ($attribute, $value, $fail) {
                        if (!is_numeric($value) || $value <= 0) {
                            $fail('Categoría inválida.');
                        }
                    }
                ],
                'presentation' => [
                    'nullable',
                    'string',
                    'max:100'
                ]
            ]);

            // Sanitizar datos de entrada
            $sanitizedData = [
                'commercial_name' => strip_tags(trim($request->commercial_name)),
                'active_ingredient' => strip_tags(trim($request->active_ingredient)),
                'category_id' => (int) $request->category_id,
                'unit' => 'ml', // Unidad por defecto
                'cantidad_producto' => 0,
                'presentation' => $request->presentation ? strip_tags(trim($request->presentation)) : null,
                'active' => true
            ];
            
            // Validaciones adicionales de seguridad
            if (strlen($sanitizedData['commercial_name']) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nombre comercial muy corto'
                ], 422);
            }
            
            if (strlen($sanitizedData['active_ingredient']) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingrediente activo muy corto'
                ], 422);
            }
            
            $product = Product::create($sanitizedData);

            return response()->json([
                'success' => true,
                'product' => $product,
                'message' => 'Producto creado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        $products = Product::where('active', true)
            ->where('commercial_name', 'like', '%' . $query . '%')
            ->select('id', 'commercial_name', 'active_ingredient')
            ->limit(10)
            ->get();
            
        return response()->json($products);
    }
}