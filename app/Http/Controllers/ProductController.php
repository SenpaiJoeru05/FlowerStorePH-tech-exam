<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Fetch all products
    public function index()
    {
        return response()->json(Product::all());
    }

    // Store a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|in:enabled,disabled',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    // Show a single product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'sometimes|required|string|max:255',
            'product_description' => 'nullable|string',
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|in:enabled,disabled',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
