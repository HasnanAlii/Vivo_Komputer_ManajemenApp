<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'idProduct';

    protected $fillable = ['namaBarang', 'kategori', 'kodeBarang', 'jumlah', 'hargaBeli', 'hargaJual'];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'idProduct');
    }

    public function purchasings()
    {
        return $this->hasMany(Purchasing::class, 'idProduct');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'idProduct');
    }

    public function finances()
    {
        return $this->hasMany(Finance::class, 'idProduct');
    }
}
