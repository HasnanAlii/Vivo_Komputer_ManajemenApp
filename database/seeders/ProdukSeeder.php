<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::insert([
            ['nama' => 'RAM 16GB', 'jumlah' => 50, 'harga_awal' => 500000, 'harga_jual' => 750000, 'id_kategori' => 1, 'garansi' => '1 Tahun'],
            ['nama' => 'Laptop Asus ROG', 'jumlah' => 20, 'harga_awal' => 15000000, 'harga_jual' => 18000000, 'id_kategori' => 2, 'garansi' => '2 Tahun'],
            ['nama' => 'Jasa Service Komputer', 'jumlah' => null, 'harga_awal' => null, 'harga_jual' => 500000, 'id_kategori' => 3, 'garansi' => null],
            ['nama' => 'VGA RTX 3060', 'jumlah' => 30, 'harga_awal' => 4000000, 'harga_jual' => 5000000, 'id_kategori' => 4, 'garansi' => '3 Tahun'],
        ]);
    }
}
