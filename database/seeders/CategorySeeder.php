<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'kodeKategori' => 'ELEC001',
                'namaKategori' => 'Elektronik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeKategori' => 'FASH001',
                'namaKategori' => 'Fashion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeKategori' => 'FOOD001',
                'namaKategori' => 'Makanan & Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
