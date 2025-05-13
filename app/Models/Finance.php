<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $table = 'finance';
    protected $primaryKey = 'idFinance';
    public $timestamps = false;

    protected $fillable = ['danaMasuk', 'modal', 'keuntungan', 'totalDana', 'tanggal'];
}
