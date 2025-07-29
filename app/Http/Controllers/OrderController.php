<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // GET /api/orders
    public function index()
    {
        $orders = Order::with('product:id,id,product_name,price')->get();

        $formatted = $orders->map(function ($order) {
            return [
                'order_id' => $order->id,
                'product_name' => $order->product->product_name ?? 'N/A',
                'price' => $order->price,
            ];
        });

        return response()->json($formatted);
    }

    // POST /api/orders
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $order = Order::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'price' => $product->price,
        ]);

        return response()->json($order, 201);
    }

    // DELETE /api/orders/{id}
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }

    // GET /api/orders/summary
    public function summary()
    {
        $total = Order::sum('price');

        return response()->json([
            'total_price' => $total
        ]);
    }
}
