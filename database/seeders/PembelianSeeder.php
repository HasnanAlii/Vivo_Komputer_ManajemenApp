<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembelian;
use App\Models\Inventory;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pembelians = [
            [
                'nama' => 'RAM 8GB DDR4',
                'harga_beli' => 500000,
                'laba' => 250000,
                'harga_jual' => 750000,
                'id_kategori' => 1, 
                'id_produk' => 1, 
                'jumlah' => 10
            ],
            [
                'nama' => 'Laptop Asus X441',
                'harga_beli' => 5000000,
                'laba' => 500000,
                'harga_jual' => 5500000,
                'id_kategori' => 2, 
                'id_produk' => 2, 
                'jumlah' => 5
            ],
            [
                'nama' => 'VGA GTX 1650',
                'harga_beli' => 2500000,
                'laba' => 250000,
                'harga_jual' => 2750000,
                'id_kategori' => 4, 
                'id_produk' => 3, 
                'jumlah' => 3
            ],
        ];

        foreach ($pembelians as $pembelian) {
            // Simpan ke tabel Pembelian
            $pembelianData = Pembelian::create($pembelian);

            // Simpan ke tabel Inventory berdasarkan pembelian
            Inventory::updateOrCreate(
                ['nama_barang' => $pembelian['nama']], // Jika nama_barang sudah ada, update
                [
                    'jumlah' => $pembelian['jumlah'],
                    'harga_modal' => $pembelian['harga_beli'],
                    'harga_jual' => $pembelian['harga_jual'],
                    'id_kategori' => $pembelian['id_kategori']
                ]
            );
        }
    }
}
