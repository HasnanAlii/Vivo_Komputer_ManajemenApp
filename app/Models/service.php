<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan;
use App\Models\Produk;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';

    protected $fillable = [
        'nama_kerusakan',
        'pelanggan_id',
        'id_barang',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_barang');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            // Memastikan pelanggan terdaftar di tabel pelanggan sebelum menyimpan service
            if (!Pelanggan::find($service->pelanggan_id)) {
                throw new \Exception("Pelanggan tidak ditemukan!");
            }
        });
    }
}
