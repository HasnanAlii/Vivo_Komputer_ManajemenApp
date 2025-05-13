<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $primaryKey = 'idNotification';

    protected $fillable = ['tglKirim', 'pesan', 'idService'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'idService');
    }
}
