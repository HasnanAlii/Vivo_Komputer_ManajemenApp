<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Inventory;
use App\Models\Pelanggan;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil produk pertama
        $produk = Produk::first();

        // Cek apakah produk tersedia dan memiliki stok yang cukup
        if (!$produk || $produk->jumlah < 1) {
            echo "Tidak ada produk dengan stok yang cukup.\n";
            return;
        }

        // Ambil pelanggan pertama\
        $pelanggan = Pelanggan::first();

        // Tentukan jumlah transaksi sesuai stok
        $jumlahTerjual = rand(1, $produk->jumlah); // Ambil jumlah acak dari stok yang tersedia

 
        Transaksi::create([
            'pelanggan_id' => $pelanggan->id,
            'nama_pelanggan' => $pelanggan->nama,  // Sesuaikan dengan nama kolom di database
            'nama_barang' => $produk->nama,
            'tanggal' => now(),
            'jumlah' => $jumlahTerjual,
            'total_harga' => $produk->harga_jual * $jumlahTerjual, // Hitung total harga
            'tipe' => 'faktur',
            'id_barang' => 1, // Sesuaikan dengan nama kolom di database
        ]);

        // Kurangi stok produk sesuai jumlah transaksi
        $produk->jumlah -= $jumlahTerjual;
        $produk->save();

        // Kurangi stok inventory jika ada
        $inventory = Inventory::find($produk->id_iventory);
        if ($inventory && $inventory->jumlah >= $jumlahTerjual) {
            $inventory->jumlah -= $jumlahTerjual;
            $inventory->save();
        }
    }
}
