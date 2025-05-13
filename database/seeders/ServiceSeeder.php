<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $customer = Customer::first();
        $user = User::first();
        $product = Product::first();

        Service::create([
            'nomorFaktur' => 1001,
            'kerusakan' => 'Broken Screen',
            'jenisPerangkat' => 'Laptop',
            'status' => false,
            'totalBiaya' => 150,
            'keuntungan' => 50,
            'tglMasuk' => '2025-05-01',
            'tglSelesai' => '2025-05-10',
            'idCustomer' => $customer->idCustomer,
            'idUser' => $user->idUser,
            'idProduct' => $product->idProduct,
        ]);
    }
}
