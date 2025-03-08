<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Inventory;
use App\Models\Transaksi;
use App\Models\Pembelian;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'nama_barang_jasa',
        'modal',
        'laba',
        'total_keuntungan',
        'tanggal',
        'id_kategori',
        'id_iventory',
        'id_transaksi',
        'id_pembelian',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'id_iventory');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }
    public function service()
    {
        return $this->belongsTo(Pembelian::class, 'id_service');
    }
    public static function boot()
    {
        parent::boot();

        static::created(function ($laporan) {
            // Perhitungan otomatis berdasarkan transaksi dan pembelian
            $pembelian = Pembelian::find($laporan->id_pembelian);
            $transaksi = Transaksi::find($laporan->id_transaksi);

            if ($pembelian && $transaksi) {
                $laporan->modal = $pembelian->harga_beli * $pembelian->jumlah;
                $laporan->laba = ($transaksi->total_harga - $laporan->modal);
                $laporan->total_keuntungan = $laporan->laba;
                $laporan->save();
            }
        });
    }
}
