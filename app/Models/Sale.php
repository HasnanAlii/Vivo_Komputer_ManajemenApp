<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;
use App\Models\Inventory;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['pelanggan_id', 'tanggal', 'jumlah', 'total_harga', 'tipe', 'id_produk'];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($transaksi) {
    //         // Kurangi stok produk
    //         $produk = Produk::find($transaksi->id_produk);
    //         if ($produk && $produk->jumlah >= $transaksi->jumlah) {
    //             $produk->jumlah -= $transaksi->jumlah;
    //             $produk->save();
    //         } else {
    //             throw new \Exception("Stok produk tidak mencukupi");
    //         }

    //         // Kurangi stok inventory jika ada
    //         $inventory = Inventory::where('id', $produk->id_iventory)->first();
    //         if ($inventory && $inventory->jumlah >= $transaksi->jumlah) {
    //             $inventory->jumlah -= $transaksi->jumlah;
    //             $inventory->save();
    //         }
    //     });
    // }
}
