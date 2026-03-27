<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,      // User & role
            CategorySeeder::class,  // Sayur, Buah, dll
            ProductSeeder::class,   // Apel, Bayam, dll
        ]);
    }
}
