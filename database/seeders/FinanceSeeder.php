<?php

namespace Database\Seeders;

use App\Models\Finance;
use App\Models\User;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Database\Seeder;

class FinanceSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $sale = Sale::first();
        $purchasing = Purchasing::first();
        $service = Service::first();
        $product = Product::first();

        Finance::create([
            'danaMasuk' => 10000,
            'modal' => 5000,
            'totalDana' => 15000,
            'tanggal' => '2025-05-07',
            'keuntungan' => 5000,
            'idUser' => $user->idUser,
            'idSale' => $sale->idSale,
            'idPurchasing' => $purchasing->idPurchasing,
            'idService' => $service->idService,
            'idProduct' => $product->idProduct,
        ]);
    }
}
