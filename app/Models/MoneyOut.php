<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyOut extends Model
{
    use HasFactory;

    protected $table = 'money_out';

    protected $primaryKey = 'id';

    protected $fillable = ['keterangan', 'jumlah', 'tanggal', 'idFinance'];
    
    protected $casts = [
        'tanggal' => 'date',  // otomatis jadi objek Carbon
    ];

    public function finance()
    {
        return $this->belongsTo(Finance::class, 'idFinance');
    }
}
