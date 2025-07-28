<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::insert([
            [
                'product_id' => 1,
                'user_id' => 1,
                'price' => 1200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'user_id' => 2,
                'price' => 950.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
