<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Pelanggan;
use App\Models\Produk;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada pelanggan dan produk sebelum menambahkan service
        $pelanggan = Pelanggan::first();
        $produk = Produk::first();

        if ($pelanggan && $produk) {
            Service::insert([
                [
                    'nama_kerusakan' => 'Layar Pecah',
                    'pelanggan_id' => $pelanggan->id,
                    'id_barang' => $produk->id,
                    'biaya_service' => 500000
                ],
                [
                    'nama_kerusakan' => 'Keyboard Tidak Berfungsi',
                    'pelanggan_id' => $pelanggan->id,
                    'id_barang' => $produk->id,
                    'biaya_service' => 500000
                ],
            ]);
        }
    }
}
