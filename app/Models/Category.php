<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'idCategory';

    protected $fillable = ['kodeKategori', 'namaKategori'];

    public function products()
    {
        return $this->hasMany(Product::class, 'idCategory', 'idCategory');
    }
}
