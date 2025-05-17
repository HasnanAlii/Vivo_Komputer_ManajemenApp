<?php

namespace Database\Seeders;

use App\Models\Purchasing;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PurchasingSeeder extends Seeder
{
    public function run()
    {
      
        $customer = Customer::first();
        $product = Product::first();

        for ($i = 1; $i <= 50; $i++) {
            Purchasing::create([
                'nomorFaktur' => 2000 + $i, // nomorFaktur beda tiap loop
                'jumlah' => rand(10, 100), // jumlah random antara 10-100
                'hargaBeli' => 100,
                'hargaJual' => 150,
                'keuntungan' => rand(1000, 5000), // keuntungan random
                'tanggal' => date('Y-m-d', strtotime("2025-05-05 +$i days")), // tanggal bertambah setiap loop
                'idCustomer' => $customer->idCustomer,
                'idProduct' => $product->idProduct,
            ]);
        }
    }
}
