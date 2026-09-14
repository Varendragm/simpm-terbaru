<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StationMachineSeeder::class,
            MachinePerformanceDataSeeder::class,
            PmScheduleSeeder::class,
            MaintenanceHistorySeeder::class,
        ]);
    }
}
