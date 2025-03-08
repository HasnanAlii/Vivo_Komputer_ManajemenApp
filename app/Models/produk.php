<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama',
        'jumlah',
        'harga_awal',
        'harga_jual',
        'id_kategori',
        'garansi',
        'id_iventory',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'id_iventory');
    }
}
