<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::insert([
            ['nama_barang' => 'Laptop Asus', 'jumlah' => 100, 'harga_modal' => 7000000, 'harga_jual' => 8500000, 'id_kategori' => 1],
            ['nama_barang' => 'Meja Kayu', 'jumlah' => 5, 'harga_modal' => 500000, 'harga_jual' => 750000, 'id_kategori' => 2],
            ['nama_barang' => 'Kemeja Pria', 'jumlah' => 20, 'harga_modal' => 150000, 'harga_jual' => 250000, 'id_kategori' => 3],
            ['nama_barang' => 'Snack Coklat', 'jumlah' => 50, 'harga_modal' => 5000, 'harga_jual' => 10000, 'id_kategori' => 4],
        ]);
        
    }
}
