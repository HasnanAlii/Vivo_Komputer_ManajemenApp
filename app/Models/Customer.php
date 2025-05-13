<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $primaryKey = 'idCustomer';

    protected $fillable = ['nama', 'alamat', 'noTelp'];

    public function services()
    {
        return $this->hasMany(Service::class, 'idCustomer');
    }

    public function purchasings()
    {
        return $this->hasMany(Purchasing::class, 'idCustomer');
    }
}
