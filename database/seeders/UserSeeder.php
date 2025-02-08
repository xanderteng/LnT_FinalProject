<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin Acc
        User::create([
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '081234567890',
            'role' => 'admin',
        ]);

        // Create 5 Users
        User::factory(5)->create();
    }
}
