<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasing extends Model
{
    use HasFactory;

    protected $table = 'purchasings';

    protected $primaryKey = 'idPurchasing';

    protected $fillable = ['nomorFaktur', 'jumlah', 'hargaBeli', 'hargaJual', 'keuntungan', 'tanggal', 'idUser', 'idCustomer', 'idProduct'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomer');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProduct');
    }
}
