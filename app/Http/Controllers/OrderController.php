<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Fetch all orders with product info
    public function index()
    {
        $orders = Order::with('product')->get();
        return response()->json($orders);
    }

    // Store a new order (dummy, no actual transaction)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'price' => 'required|numeric',
        ]);

        $order = Order::create($validated);

        return response()->json($order, 201);
    }

    // Show a single order with product info
    public function show($id)
    {
        $order = Order::with('product')->findOrFail($id);
        return response()->json($order);
    }

    // Update an order (dummy)
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'price' => 'sometimes|required|numeric',
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted']);
    }
}