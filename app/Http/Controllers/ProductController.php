<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        return Product::all();
    }

    // GET /api/products/{id}
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // POST /api/products
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|in:enabled,disabled',
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    // PUT /api/products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'sometimes|string|max:255',
            'product_description' => 'sometimes|string',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'status' => 'sometimes|in:enabled,disabled',
        ]);

        $product->update($request->all());

        return response()->json($product);
    }

    // DELETE /api/products/{id}
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);
    }

    // PATCH /api/products/{id}/toggle-status
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        $product->status = $product->status === 'enabled' ? 'disabled' : 'enabled';
        $product->save();

        return response()->json([
            'message' => 'Product status updated successfully.',
            'product' => $product
        ]);
    }
}
