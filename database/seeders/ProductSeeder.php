<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [];

        // Buat 50 data sparepart laptop dan komputer kategori 1
        for ($i = 1; $i <= 50; $i++) {
            $products[] = [
                'namaBarang'  => "Sparepart Laptop/Komputer #$i",
                'jumlah'      => 20000,
                'hargaBeli'   => 500000,
                'hargaJual'   => 700000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
