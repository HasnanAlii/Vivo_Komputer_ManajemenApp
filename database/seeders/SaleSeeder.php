<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Finance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run()
    {
        $finances = Finance::pluck('idFinance')->toArray();
        $products = Product::all();

        if ($products->isEmpty()) {
            return; // Tidak ada produk, stop seeder
        }

        for ($i = 0; $i < 50; $i++) {
            $product = $products->random();

            $jumlah = rand(1, 10);
            $hargaJual = $product->hargaJual;
            $hargaBeli = $product->hargaBeli;

            $totalHarga = $hargaJual * $jumlah;
            $keuntungan = ($hargaJual - $hargaBeli) * $jumlah;

          if (rand(0,1) === 0) {
    // Pilih tanggal acak di minggu lalu
    $tanggal = Carbon::now()->subWeek()->startOfWeek()->addDays(rand(0,6))->toDateString();
} else {
    // Pilih tanggal acak di bulan lalu
    $bulanLalu = Carbon::now()->subMonth();
    $tanggal = $bulanLalu->copy()->startOfMonth()->addDays(rand(0, $bulanLalu->daysInMonth - 1))->toDateString();
}


            Sale::create([
                'nomorFaktur' => 3000 + $i,
                'jumlah' => $jumlah,
                'totalHarga' => $totalHarga,
                'keuntungan' => $keuntungan,
                'tanggal' => $tanggal,
                'idProduct' => $product->idProduct,
                'idFinance' => fake()->randomElement($finances),
            ]);
        }
    }
}
