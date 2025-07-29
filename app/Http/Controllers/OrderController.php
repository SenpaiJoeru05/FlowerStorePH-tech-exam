<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with(['product:id,product_name', 'user:id,first_name,last_name'])
            ->select('id', 'product_id', 'user_id', 'price')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'product_name' => $order->product->product_name,
                    'user_name' => $order->user->first_name . ' ' . $order->user->last_name,
                    'price' => $order->price,
                ];
            });
    }
}
