<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'product_name' => 'Red Roses Bouquet',
                'product_description' => 'A beautiful bouquet of fresh red roses.',
                'quantity' => 10,
                'price' => 1200.00,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Sunflower Arrangement',
                'product_description' => 'Bright sunflowers arranged in a vase.',
                'quantity' => 5,
                'price' => 950.00,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
