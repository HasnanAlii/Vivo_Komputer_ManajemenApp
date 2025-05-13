<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $product = Product::first();

        Sale::create([
            'nomorFaktur' => 3001,
            'jumlah' => 10,
            'totalHarga' => 7000,
            'keuntungan' => 1500,
            'tanggal' => '2025-05-06',
            'idUser' => $user->idUser,
            'idProduct' => $product->idProduct,
        ]);
    }
}
