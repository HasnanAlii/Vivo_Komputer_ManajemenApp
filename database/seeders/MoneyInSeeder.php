<?php

namespace Database\Seeders;

use App\Models\MoneyIn;
use App\Models\Finance;
use Illuminate\Database\Seeder;

class MoneyInSeeder extends Seeder
{
    public function run()
    {
        $finance = Finance::first();

        MoneyIn::create([
            'keterangan' => 'Initial Deposit',
            'jumlah' => 5000,
            'tanggal' => '2025-05-08',
            'idFinance' => $finance->idFinance,
        ]);
    }
}
