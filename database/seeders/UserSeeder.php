<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email_address' => 'juan@example.com',
                'mobile_number' => '09171234567',
                'address' => 'Manila, Philippines',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email_address' => 'maria@example.com',
                'mobile_number' => '09181234567',
                'address' => 'Quezon City, Philippines',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
