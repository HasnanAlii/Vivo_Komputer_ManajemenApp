<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'namaBarang'  => 'Televisi 42 Inch',
                'jumlah'      => 10,
                'hargaBeli'   => 3000000,
                'hargaJual'   => 3500000,
                'idCategory'  => 1, // pastikan idCategory 1 = Elektronik
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Kemeja Batik',
                'jumlah'      => 25,
                'hargaBeli'   => 80000,
                'hargaJual'   => 120000,
                'idCategory'  => 2, // Fashion
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Kopi Arabika 250gr',
                'jumlah'      => 50,
                'hargaBeli'   => 25000,
                'hargaJual'   => 40000,
                'idCategory'  => 3, // Makanan & Minuman
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
