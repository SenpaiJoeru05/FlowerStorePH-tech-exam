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
                'product_name' => 'iPhone 16 Pro',
                'product_description' => 'Latest Apple flagship smartphone.',
                'quantity' => 8,
                'price' => 85000.00,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Samsung Galaxy S24',
                'product_description' => 'Newest Samsung Galaxy phone.',
                'quantity' => 10,
                'price' => 65000.00,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'MacBook Air M3',
                'product_description' => 'Apple laptop with M3 chip.',
                'quantity' => 5,
                'price' => 75000.00,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Dell XPS 13',
                'product_description' => 'Premium ultrabook from Dell.',
                'quantity' => 7,
                'price' => 68000.00,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Lenovo ThinkPad X1',
                'product_description' => 'Business laptop from Lenovo.',
                'quantity' => 6,
                'price' => 72000.00,
                'status' => 'enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
