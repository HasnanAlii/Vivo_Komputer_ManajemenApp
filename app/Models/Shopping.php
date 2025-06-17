<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;

    protected $table = 'shopping';

    protected $fillable = [
        'sumber',
        'jumlah',
        'statuspembayaran',
        'totalbelanja',
        'idFinance'
    ];
    protected $casts = [
    'statuspembayaran' => 'boolean',
];

     public function finance()
    {
        return $this->belongsTo(Finance::class, 'idFinance', 'idFinance');
    }
  
public function pembayaranCicilan()
{
    return $this->hasMany(Pembayaran::class, 'idShopping', 'id');
}
public function cicilanTerakhir()
{
    return $this->hasOne(Pembayaran::class, 'idShopping')->latestOfMany();
}
public function pembayaran()
{
    return $this->hasMany(Pembayaran::class, 'idShopping', 'id');
}

}
