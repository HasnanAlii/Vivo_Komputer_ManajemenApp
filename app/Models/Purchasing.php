<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchasing extends Model
{
    protected $primaryKey = 'idPurchasing';

   protected $fillable = [
    'nomorFaktur', 'jumlah', 'hargaBeli', 'hargaJual', 'type', 'spek', 'serialNumber',
    'keuntungan', 'tanggal', 'idCustomer', 'idProduct', 'idFinance','buktiTransaksi'
];



    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomer', 'idCustomer');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idProduct', 'idProduct');
    }
    public function finance()
    {
        return $this->belongsTo(Finance::class, 'idFinance', 'idFinance');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'idCategory', 'idCategory');
    }

}
