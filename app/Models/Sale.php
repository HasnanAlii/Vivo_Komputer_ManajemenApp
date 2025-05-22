<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $primaryKey = 'idSale';

   
    protected $fillable = [
        'nomorFaktur',
        'jumlah',
        'totalHarga',
        'keuntungan',
        'tanggal',
        'idUser',
        'idProduct',
        'hargaTransaksi',
         'idCustomer',
         'idEmployee'
    ];


  
    public function product()
    {
        return $this->belongsTo(Product::class, 'idProduct', 'idProduct');
    }
    public function finance()
    {
        return $this->belongsTo(Finance::class, 'idFinance', 'idFinance');
    }
    public function customer()
{
    return $this->belongsTo(Customer::class, 'idCustomer', 'idCustomer');
}


public function employee()
{
    return $this->belongsTo(Employee::class, 'idEmployee', 'idEmployee');
}

}
