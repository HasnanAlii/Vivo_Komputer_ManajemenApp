<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            KeuanganSeeder::class,
            KategoriSeeder::class,
            InventorySeeder::class,
            ProdukSeeder::class,
            PelangganSeeder::class,
            TransaksiSeeder::class,
            PembelianSeeder::class,
            ServiceSeeder::class,
            LaporanSeeder::class,
        ]);
    }
}
