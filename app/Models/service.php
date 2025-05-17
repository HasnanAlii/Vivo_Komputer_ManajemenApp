<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $primaryKey = 'idService';

    protected $fillable = ['nomorFaktur', 'kerusakan', 'jenisPerangkat', 'status', 'totalBiaya', 'keuntungan', 'tglMasuk', 'tglSelesai', 'idCustomer', 'idUser', 'idProduct'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
    
    public function finance() {
    return $this->belongsTo(Finance::class, 'idFinance', 'idFinance');
    }


 public function products()
{
    return $this->belongsTo(Product::class, 'idProduct', 'idProduct');
}

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'idService');
    }
    public function getProductsAttribute()
{
    if (!$this->idProduct) {
        return collect();  // Kembalikan collection kosong, bukan null
    }

    $ids = explode(',', $this->idProduct);

    return Product::whereIn('idProduct', $ids)->get();
}

}
