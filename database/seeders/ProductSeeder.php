<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk1 = Product::create([
            'nama' => 'Kue Nastar',
            'deskripsi' => 'Kue Nastar dengan rasa manis nan lezat',
            'harga' => 75000,
            'stok' => 50,
            'gambar' => 'https://via.placeholder.com/250',
        ]);

        $produk1->variants()->createMany([
            ['ukuran' => '100g', 'harga' => 75000],
            ['ukuran' => '250g', 'harga' => 175000],
        ]);

        // Tambahkan produk dan variannya sesuai kebutuhan
    }
}
