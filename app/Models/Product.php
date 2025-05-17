<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'idProduct';

    protected $fillable = [
        'namaBarang',
        'jumlah',
        'hargaBeli',
        'hargaJual',
        'idCategory'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'idCategory', 'idCategory');
    }

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
