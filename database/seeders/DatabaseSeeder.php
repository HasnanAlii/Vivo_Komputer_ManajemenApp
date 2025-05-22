<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            EmployeeSeeder::class,
            // ServiceSeeder::class,
            // PurchasingSeeder::class,
            // SaleSeeder::class,
            // FinanceSeeder::class,
            // // MoneyInSeeder::class,
            // MoneyOutSeeder::class,
            // NotificationSeeder::class,
            // ReportSeeder::class,
        ]);
    }
}
