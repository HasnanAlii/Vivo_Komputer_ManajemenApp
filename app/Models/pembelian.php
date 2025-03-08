<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = [
        'nama',
        'harga_beli',
        'harga_jual',
        'laba',
        'id_kategori',
        'id_produk',
        'jumlah',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($pembelian) {
            // Menambahkan jumlah produk ke tabel produk setelah pembelian
            $produk = Produk::find($pembelian->id_produk);
            if ($produk) {
                $produk->jumlah += $pembelian->jumlah;
                $produk->save();
            }
        });
    }
}
