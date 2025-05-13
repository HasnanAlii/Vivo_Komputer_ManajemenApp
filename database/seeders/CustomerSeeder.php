<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::create([
            'nama' => 'John Doe',
            'alamat' => '123 Main Street, Springfield, IL',
            'noTelp' => '+1-555-1234',
        ]);

        Customer::create([
            'nama' => 'Jane Smith',
            'alamat' => '456 Elm Street, Springfield, IL',
            'noTelp' => '+1-555-5678',
        ]);

        // Add more customer data here
    }
}
