<?php

namespace Database\Seeders;

use App\Models\MoneyOut;
use App\Models\Finance;
use Illuminate\Database\Seeder;

class MoneyOutSeeder extends Seeder
{
    public function run()
    {
        $finance = Finance::first();

        MoneyOut::create([
            'keterangan' => 'Purchase Payment',
            'jumlah' => 2000,
            'tanggal' => '2025-05-09',
            'idFinance' => $finance->idFinance,
        ]);
    }
}
