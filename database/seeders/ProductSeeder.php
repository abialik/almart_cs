<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $buah    = Category::where('name', 'Buah')->first();
        $sayur   = Category::where('name', 'Sayur')->first();
        $minuman = Category::where('name', 'Minuman')->first();
        $snack   = Category::where('name', 'Snack')->first();
        $juice   = Category::where('name', 'Juice')->first();

        $products = [

            // ================= BUAH =================
            ['Apel Merah', 25000, $buah, 'apel.jpg'],
            ['Jeruk Manis', 20000, $buah, 'jeruk.jpg'],
            ['Pisang Cavendish', 18000, $buah, 'pisang.jpg'],
            ['Mangga Harum', 28000, $buah, 'mangga.jpg'],
            ['Semangka Fresh', 30000, $buah, 'semangka.jpg'],
            ['Anggur Merah', 35000, $buah, 'anggur.jpg'],          // NEW
            ['Nanas Madu', 22000, $buah, 'nanas.jpg'],            // NEW

            // ================= SAYUR =================
            ['Bayam Segar', 8000, $sayur, 'bayam.jpg'],
            ['Wortel Organik', 12000, $sayur, 'wortel.jpg'],
            ['Tomat Merah', 15000, $sayur, 'tomat.jpg'],
            ['Brokoli Hijau', 18000, $sayur, 'brokoli.jpg'],
            ['Selada Fresh', 10000, $sayur, 'selada.jpg'],
            ['Kentang Premium', 14000, $sayur, 'kentang.jpg'],    // NEW

            // ================= MINUMAN =================
            ['Coca Cola 1L', 17000, $minuman, 'cocacola.jpg'],
            ['Teh Botol Sosro', 8000, $minuman, 'tehbotol.jpg'],
            ['Air Mineral Aqua', 6000, $minuman, 'aqua.jpg'],
            ['Sprite 1L', 16000, $minuman, 'sprite.jpg'],
            ['Fanta Strawberry', 16000, $minuman, 'fanta.jpg'],   // NEW

            // ================= SNACK =================
            ['Keripik Kentang', 12000, $snack, 'keripik.jpg'],
            ['Biskuit Coklat', 15000, $snack, 'biskuit.jpg'],
            ['Cheetos Snack', 14000, $snack, 'cheetos.jpg'],
            ['Kacang Panggang', 13000, $snack, 'kacang.jpg'],
            ['Chiki Balls', 12000, $snack, 'chiki.jpg'],          // NEW

            // ================= JUICE =================
            ['Jus Mangga Fresh', 22000, $juice, 'jus-mangga.jpg'],
            ['Jus Alpukat Premium', 25000, $juice, 'jus-alpukat.jpg'],
            ['Jus Jeruk Original', 20000, $juice, 'jus-jeruk.jpg'],
            ['Jus Stroberi Segar', 24000, $juice, 'jus-stroberi.jpg'], // NEW
        ];

        foreach ($products as $item) {

            if (!$item[2]) continue;

            $discount = rand(0, 25);
            $rating   = rand(35, 50) / 10;

            Product::create([
                'name'        => $item[0],
                'slug'        => Str::slug($item[0]) . '-' . uniqid(),
                'description' => $item[0] . ' kualitas premium, segar, dan siap kirim setiap hari.',
                'price'       => $item[1],
                'category_id' => $item[2]->id,
                'stock'       => rand(50, 150),
                'image'       => 'images/products/' . $item[3],
                'discount'    => $discount,
                'rating'      => $rating,
                'is_active'   => true,
            ]);
        }
    }
}