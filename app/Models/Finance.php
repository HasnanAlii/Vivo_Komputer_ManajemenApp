<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $table = 'finance';

    protected $primaryKey = 'idFinance';

    protected $fillable = ['danaMasuk', 'modal', 'totalDana', 'tanggal', 'keuntungan', 'idUser', 'idSale', 'idPurchasing', 'idService', 'idProduct'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'idSale');
    }

    public function purchasing()
    {
        return $this->belongsTo(Purchasing::class, 'idPurchasing');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'idService');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProduct');
    }
}
