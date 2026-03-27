<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Almart',
            'email' => 'admin@almart.com',
            'phone' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Petugas Almart',
            'email' => 'petugas@almart.com',
            'phone' => '081111111111',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@almart.com',
            'phone' => '082222222222',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'is_active' => true,
        ]);
    }
}
