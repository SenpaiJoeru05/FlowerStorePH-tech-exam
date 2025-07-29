<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // ✅ this is needed
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        return Product::select('id', 'product_name', 'product_description', 'price', 'status')->get();
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return response()->json(['message' => 'Product updated successfully.']);
    }

    /**
     * Toggle the product's status (enabled/disabled).
     */
    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === 'enabled' ? 'disabled' : 'enabled';
        $product->save();

        return response()->json(['message' => 'Product status updated.', 'status' => $product->status]);
    }
}
