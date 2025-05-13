<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $primaryKey = 'idSale';

    protected $fillable = ['nomorFaktur', 'jumlah', 'totalHarga', 'keuntungan', 'tanggal', 'idUser', 'idProduct'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProduct');
    }
}
