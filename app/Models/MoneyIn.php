<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyIn extends Model
{
    use HasFactory;

    protected $table = 'money_in';

    protected $primaryKey = 'id';

    protected $fillable = ['keterangan', 'jumlah', 'tanggal', 'idFinance'];

    public function finance()
    {
        return $this->belongsTo(Finance::class, 'idFinance');
    }
}
