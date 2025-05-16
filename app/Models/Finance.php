<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $table = 'finance';
    protected $primaryKey = 'idFinance';
    public $timestamps = false;

   protected $fillable = [
    'dana',
    'modal',
    'totalDana',
    'tanggal',
    'keuntungan',
    'keterangan', 
];


public function purchasings()
{
    return $this->hasOne(Purchasing::class, 'idFinance', 'idFinance');
}

public function sales()
{
    return $this->hasOne(Sale::class, 'idFinance', 'idFinance');
}
 public function services()
    {
        return $this->hasOne(Service::class, 'idFinance', 'idFinance');
    }







}
