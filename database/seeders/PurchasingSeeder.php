<?php

namespace Database\Seeders;

use App\Models\Purchasing;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PurchasingSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $customer = Customer::first();
        $product = Product::first();

        Purchasing::create([
            'nomorFaktur' => 2001,
            'jumlah' => 50,
            'hargaBeli' => 100,
            'hargaJual' => 150,
            'keuntungan' => 2500,
            'tanggal' => '2025-05-05',
            'idUser' => $user->idUser,
            'idCustomer' => $customer->idCustomer,
            'idProduct' => $product->idProduct,
        ]);
    }
}
