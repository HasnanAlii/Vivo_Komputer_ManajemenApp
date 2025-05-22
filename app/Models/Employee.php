<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;


    protected $primaryKey = 'idEmployee';

    protected $table = 'employess';

    
    protected $fillable = [
        'fullName',
    ];

    public function sales()
{
    return $this->hasMany(Sale::class, 'idEmployee', 'idEmployee');
}

public function services()
{
    return $this->hasMany(Service::class, 'idEmployee', 'idEmployee');
}

}
