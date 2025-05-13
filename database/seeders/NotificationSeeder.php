<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\Service;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $service = Service::first();

        if (!$service) {
            $this->command->warn('No service found. Skipping NotificationSeeder.');
            return;
        }

        Notification::create([
            'tglKirim' => now(),
            'pesan' => 'Service telah selesai dikerjakan.',
            'idService' => $service->idService,
        ]);
    }
}
