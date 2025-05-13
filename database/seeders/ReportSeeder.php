<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use App\Models\Finance;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run()
    {
        $sale = Sale::first();
        $purchasing = Purchasing::first();
        $service = Service::first();
        $finance = Finance::first();

        Report::create([
            'tanggal' => '2025-05-11',
            'jenisLaporan' => 'harian',
            'idSale' => $sale->idSale,
            'idPurchasing' => $purchasing->idPurchasing,
            'idService' => $service->idService,
            'idFinance' => $finance->idFinance,
        ]);
    }
}
