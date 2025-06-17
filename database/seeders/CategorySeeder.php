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
                'namaKategori' => 'Sparepart', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeKategori' => 'LAPT001',
                'namaKategori' => 'Laptop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeKategori' => 'PCAC001',
                'namaKategori' => 'Aksesoris Komputer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
         
            [
                'kodeKategori' => 'SERV001',
                'namaKategori' => 'Jasa ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeKategori' => 'SOFT001',
                'namaKategori' => 'Software',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeKategori' => 'PRNT001',
                'namaKategori' => 'Printer & Tinta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kodeKategori' => 'NETW001',
                'namaKategori' => 'Perangkat Listrik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
               [
                'kodeKategori' => 'NEW01',
                'namaKategori' => 'CCTV',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                [
                'kodeKategori' => 'PCAC002',
                'namaKategori' => 'Komputer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
