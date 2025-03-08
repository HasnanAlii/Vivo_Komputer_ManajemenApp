<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::insert([
            ['nama' => 'Andi Saputra', 'alamat' => 'Jl. Merdeka No.10, Jakarta', 'no_hp' => '081234567890'],
            ['nama' => 'Budi Santoso', 'alamat' => 'Jl. Sudirman No.20, Bandung', 'no_hp' => '081298765432'],
            ['nama' => 'Citra Dewi', 'alamat' => 'Jl. Gatot Subroto No.5, Surabaya', 'no_hp' => '081354678921'],
            ['nama' => 'Dedi Pratama', 'alamat' => 'Jl. Ahmad Yani No.15, Yogyakarta', 'no_hp' => '081267894321'],
        ]);
    }
}
