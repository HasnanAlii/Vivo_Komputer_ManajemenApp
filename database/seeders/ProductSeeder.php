<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'namaBarang' => 'Laptop ABC',
            'kategori' => 'Electronics',
            'kodeBarang' => 123456,
            'jumlah' => 100,
            'hargaBeli' => 500,
            'hargaJual' => 700,
        ]);

        Product::create([
            'namaBarang' => 'Mouse XYZ',
            'kategori' => 'Accessories',
            'kodeBarang' => 789012,
            'jumlah' => 200,
            'hargaBeli' => 20,
            'hargaJual' => 40,
        ]);

        // Add more product data here
    }
}
