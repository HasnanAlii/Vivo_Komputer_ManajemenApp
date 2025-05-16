<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Product;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil satu produk yang sesuai untuk perbaikan (misalnya kategori = 'Sparepart')
        $product = Product::first();

        // Jika tidak ditemukan, pakai produk pertama
        if (!$product) {
            $product = Product::first();
        }

        // Buat customer dummy
        $customer = Customer::create([
            'nama' => 'Rina Putri',
            'noTelp' => '08234567890',
            'alamat' => 'Jl. Merdeka No.99',
        ]);

        // Buat data service
        Service::create([
            'nomorFaktur' => 2025001,
            'kerusakan' => 'Keyboard rusak',
            'jenisPerangkat' => 'Laptop',
            'status' => false,
            'totalBiaya' => 300000,
            'keuntungan' => 100000,
            'tglMasuk' => now()->subDays(5),
            'tglSelesai' => now()->addDays(3),
            'idCustomer' => $customer->idCustomer,
            'idProduct' => $product->idProduct,
            'idFinance' => null,
        ]);
    }
}
