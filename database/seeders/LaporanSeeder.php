<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laporan;
use App\Models\Kategori;
use App\Models\Inventory;
use App\Models\Transaksi;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Service;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::first(); // Ambil satu kategori sebagai default jika tidak ada
        $inventory = Inventory::first(); // Ambil satu inventory jika tersedia
        $pembelians = Pembelian::all();
        $transaksis = Transaksi::all();
        $services = Service::all();
        $produk = Produk::first(); // Ambil satu produk jika tersedia

        // Buat laporan dari pembelian
        foreach ($pembelians as $pembelian) {
            Laporan::create([
                'id_transaksi' => null, // Karena ini laporan dari pembelian, bukan transaksi
                'id_kategori' => $pembelian->id_kategori ?? $kategori?->id,
                'id_iventory' => $pembelian->id_iventory ?? $inventory?->id,
                'id_pembelian' => $pembelian->id,
                'id_service' => null,
                'nama_barang_jasa' => $pembelian->nama,
                'jumlah' => $pembelian->jumlah,
                'tanggal' => $pembelian->created_at ?? Carbon::now(),
                'modal' => ($pembelian->harga_beli) * ($pembelian->jumlah),
                'laba' => (($pembelian->harga_jual) - ($pembelian->harga_beli)) * ($pembelian->jumlah),
                'total_keuntungan' => ($pembelian->harga_jual) * ($pembelian->jumlah),
            ]);
        }

        // Buat laporan dari transaksi
        foreach ($transaksis as $transaksi) {
            Laporan::create([
                'id_transaksi' => $transaksi->id,
                'id_kategori' => $transaksi->id_kategori ?? $kategori?->id,
                'id_iventory' => $transaksi->id_iventory ?? $inventory?->id,
                'id_pembelian' => null,
                'id_service' => null,
                'nama_barang_jasa' => "Transaksi Faktur #" . ($transaksi->id ?? 'Unknown'),
                'jumlah' => $transaksi->jumlah,
                'tanggal' => $transaksi->tanggal ?? Carbon::now(),
                'modal' => ($produk->harga_awal) * ($transaksi->jumlah),
                'laba' => (($produk->harga_jual) - ($produk->harga_beli)) * ($pembelian->jumlah),
                'total_keuntungan' =>($produk->harga_jual)  * ($pembelian->jumlah),
            ]);
        }

        // Buat laporan dari service
        foreach ($services as $service) {
            Laporan::create([
                'id_transaksi' => null, // Karena ini laporan dari service, bukan transaksi
                'id_kategori' => $service->id_kategori ?? $kategori?->id,
                'id_iventory' => $service->id_iventory ?? $inventory?->id,
                'id_pembelian' => null,
                'id_service' => $service->id,
                'nama_barang_jasa' => "Service: " . $service->nama_kerusakan,
                'jumlah' => $service->jumlah,
                'tanggal' => $service->created_at ?? Carbon::now(),
                'modal' => 0, // Jika ada biaya suku cadang, bisa dihitung
                'laba' => $service->biaya_service, // Sesuaikan dengan harga service yang sesungguhnya
                'total_keuntungan' => $service->biaya_service ,
            ]);
        }
    }
}
