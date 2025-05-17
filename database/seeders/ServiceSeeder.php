<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Finance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::pluck('idCustomer')->toArray();
        $finances = Finance::pluck('idFinance')->toArray();

        for ($i = 0; $i < 50; $i++) {
            $tglMasuk = Carbon::now()->subDays(rand(0, 30));
            $tglSelesai = rand(0, 1) ? $tglMasuk->copy()->addDays(rand(1, 5)) : null;

            Service::create([
                'nomorFaktur'   => rand(100000, 999999),
                'kerusakan'     => rand(0, 1) ? fake()->word() : null,
                'jenisPerangkat'=> fake()->randomElement(['Laptop', 'HP', 'Printer', 'Monitor']),
                'status'        => $tglSelesai ? true : false,
                'biayaJasa'     => rand(50000, 150000),
                'totalHarga'    => rand(100000, 300000),
                'keuntungan'    => rand(50000, 150000),
                'tglMasuk'      => $tglMasuk,
                'tglSelesai'    => $tglSelesai,
                'idCustomer'    => fake()->randomElement($customers),
                'idProduct'     => 1,
                'idFinance'     => fake()->randomElement($finances),
            ]);
        }
    }
}
