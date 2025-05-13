<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $primaryKey = 'idLaporan';

    protected $fillable = ['tanggal', 'jenisLaporan', 'idSale', 'idPurchasing', 'idService', 'idFinance'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'idSale');
    }

    public function purchasing()
    {
        return $this->belongsTo(Purchasing::class, 'idPurchasing');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'idService');
    }

    public function finance()
    {
        return $this->belongsTo(Finance::class, 'idFinance');
    }
}
