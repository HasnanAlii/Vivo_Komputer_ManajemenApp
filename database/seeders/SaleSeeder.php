<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Finance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run()
    {
        
        $finances = Finance::pluck('idFinance')->toArray();
        
        for ($i = 0; $i < 50; $i++) {

            $jumlah = rand(1, 20);
            $hargaJual = $product->hargaJual ?? 1000;
            $hargaBeli = $product->hargaBeli ?? 800;

            $totalHarga = $hargaJual * $jumlah;
            $keuntungan = ($hargaJual - $hargaBeli) * $jumlah;

                Sale::create([
                'nomorFaktur' => 3000 + $i,
                'jumlah' => $jumlah,
                'totalHarga' => $totalHarga,
                'keuntungan' => $keuntungan,
                'tanggal' => Carbon::now()->subDays(rand(0, 60))->format('Y-m-d'),
                'idProduct' =>1 , 
                'idFinance' => fake()->randomElement($finances),
            ]);

                    }
    }
}
