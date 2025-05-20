<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $primaryKey = 'idTransactionItem';

    protected $fillable = [
        'idSale',
        'idProduct',
        'namaBarang',
        'hargaTransaksi',
        'jumlah',
    ];
}
