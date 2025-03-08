<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::insert([
            ['nama' => 'Ram,', 'code' => 'ELK'],
            ['nama' => 'Laptop', 'code' => 'FUR'],
            ['nama' => 'Jasa', 'code' => 'PAK'],
            ['nama' => 'Vga', 'code' => 'MAK'],
        ]);

        
    }
}
