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
                'namaBarang'  => 'TV LED 42 Inch',
                'jumlah'      => 10,
                'hargaBeli'   => 3000000,
                'hargaJual'   => 3500000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Smartphone 6.5" 128GB',
                'jumlah'      => 20,
                'hargaBeli'   => 2500000,
                'hargaJual'   => 3200000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Laptop i5 14 Inch',
                'jumlah'      => 15,
                'hargaBeli'   => 5000000,
                'hargaJual'   => 6200000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Headphone Bluetooth',
                'jumlah'      => 30,
                'hargaBeli'   => 150000,
                'hargaJual'   => 250000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Kamera DSLR 24MP',
                'jumlah'      => 5,
                'hargaBeli'   => 4500000,
                'hargaJual'   => 5500000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Power Bank 10000mAh',
                'jumlah'      => 40,
                'hargaBeli'   => 120000,
                'hargaJual'   => 180000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Smartwatch Waterproof',
                'jumlah'      => 25,
                'hargaBeli'   => 300000,
                'hargaJual'   => 450000,
                'idCategory'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

            // Tambahan produk lain (jika ingin mencampur kategori)
            [
                'namaBarang'  => 'Kemeja Batik',
                'jumlah'      => 25,
                'hargaBeli'   => 80000,
                'hargaJual'   => 120000,
                'idCategory'  => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'namaBarang'  => 'Kopi Arabika 250gr',
                'jumlah'      => 50,
                'hargaBeli'   => 25000,
                'hargaJual'   => 40000,
                'idCategory'  => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
