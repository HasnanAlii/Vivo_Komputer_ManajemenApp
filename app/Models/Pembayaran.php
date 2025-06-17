<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi jamak
    protected $table = 'pembayaran';

    // Primary key default 'id', tapi bisa diubah jika perlu
    protected $primaryKey = 'id';

    // Mass assignable attributes
    protected $fillable = [
        'idCustomer',
        'idShopping',
        'idFinance',
        'bayar',
        'sisaCicilan',
    ];

    // Relasi ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idCustomer', 'idCustomer');
    }

    // Relasi ke shopping (jika digunakan)
    public function shopping()
    {
        return $this->belongsTo(Shopping::class, 'idShopping', 'id');
    }

    // Relasi ke finance (jika digunakan)
    public function finance()
    {
        return $this->belongsTo(Finance::class, 'idFinance', 'idFinance');
    }
    public function pembayaran()
{
    return $this->hasMany(Pembayaran::class, 'idShopping', 'idShopping');
}

}
