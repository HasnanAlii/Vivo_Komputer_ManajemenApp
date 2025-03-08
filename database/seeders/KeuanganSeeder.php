<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Keuangan::insert([
            'pengeluaran' => 1000000.00,
            'pemasukan' => 5000000.00,
        ]);

        Keuangan::insert([
            'pengeluaran' => 2000000.00,
            'pemasukan' => 7000000.00,
        ]);
    }
}
