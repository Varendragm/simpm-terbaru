<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\MachinePerformanceData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MachinePerformanceDataSeeder extends Seeder
{
    /**
     * Mengisi data operasional mentah 6 bulan terakhir per mesin.
     * Indikator performa (OEE, Availability, dst) DIHITUNG dari data ini oleh
     * App\Services\PerformanceCalculator, bukan disimpan sebagai angka jadi.
     * Beberapa mesin sengaja tidak diberi data output (actual/ideal/good) untuk
     * mendemonstrasikan status "Belum tersedia" pada Performance/Quality/OEE,
     * sesuai PRD §6.8.
     */
    public function run(): void
    {
        // profil kondisi tiap mesin: [downtime_ratio, failure_count_per_bulan, punya_data_output]
        $profiles = [
            'G01' => [0.03, 1, true],
            'G02' => [0.12, 3, true],
            'G03' => [0.04, 1, true],
            'G04' => [0.22, 4, false], // dalam perbaikan — data output belum tersedia
            'B01' => [0.02, 1, true],
            'B02' => [0.03, 1, true],
            'B03' => [0.10, 2, true],
            'P01' => [0.03, 1, true],
            'P02' => [0.05, 1, false], // sengaja kosong untuk mendemonstrasikan status belum tersedia
        ];

        $plannedPerMonth = 30 * 24 * 60; // 1 bulan operasi 24 jam, dalam menit

        foreach (Machine::all() as $machine) {
            [$downtimeRatio, $failures, $hasOutput] = $profiles[$machine->code] ?? [0.05, 1, true];

            for ($i = 5; $i >= 0; $i--) {
                $period = Carbon::now()->subMonths($i)->format('Y-m');

                $downtime = (int) round($plannedPerMonth * $downtimeRatio);
                $repairTime = (int) round($downtime * 0.9);

                $actual = $ideal = $good = null;

                if ($hasOutput) {
                    $performanceRatio = max(0.75, 1 - $downtimeRatio); // performa mendekati availability
                    $qualityRatio = 0.97;
                    $ideal = 1000;
                    $actual = (int) round($ideal * $performanceRatio);
                    $good = (int) round($actual * $qualityRatio);
                }

                MachinePerformanceData::updateOrCreate(
                    ['machine_id' => $machine->id, 'period' => $period],
                    [
                        'planned_time_minutes' => $plannedPerMonth,
                        'downtime_minutes' => $downtime,
                        'repair_time_minutes' => $repairTime,
                        'failure_count' => $failures,
                        'actual_output' => $actual,
                        'ideal_output' => $ideal,
                        'good_output' => $good,
                    ]
                );
            }
        }
    }
}
