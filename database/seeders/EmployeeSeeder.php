<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        DB::table('employess')->insert([
            [
                'nama' => 'John Doe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Michael Johnson',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
