<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employess';
    protected $primaryKey = 'idEmployee';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'jabatan',
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
