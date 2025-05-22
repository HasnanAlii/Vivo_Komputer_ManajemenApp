<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $primaryKey = 'idCustomer';

    protected $fillable = ['nama', 'alamat', 'noTelp','cicilan'];

    public function services()
    {
        return $this->hasMany(Service::class, 'idCustomer');
    }

    public function purchasings()
    {
        return $this->hasMany(Purchasing::class, 'idCustomer');
    }
  // Customer.php
public function sales()
{
    return $this->hasMany(Sale::class, 'idCustomer', 'idCustomer'); 
    // pastikan foreign key dan local key sesuai skema tabelmu
}

    // Sale.php
public function product()
{
    return $this->belongsTo(Product::class, 'idProduct', 'idProduct');
}

}
