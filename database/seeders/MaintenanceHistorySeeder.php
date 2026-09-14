<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\MaintenanceHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MaintenanceHistorySeeder extends Seeder
{
    public function run(): void
    {
        $pelaksana = ['Budi Santoso', 'Rudi Hartono'];
        $kategori = ['Mekanik', 'Elektrik', 'Instrumentasi'];
        $hasil = ['Baik', 'Perlu Tindak Lanjut', 'Selesai Diperbaiki'];

        $no = 1;
        foreach (Machine::all() as $machine) {
            // Riwayat dari PM tervalidasi (source: pm)
            for ($i = 0; $i < 3; $i++) {
                MaintenanceHistory::create([
                    'no_laporan' => 'PM-'.Carbon::now()->subDays(10 + $i * 15)->format('Ymd').'-'.Str::padLeft((string) $no, 4, '0'),
                    'machine_id' => $machine->id,
                    'pm_schedule_id' => null,
                    'source' => 'pm',
                    'kategori' => $kategori[$i % 3],
                    'pekerjaan' => 'Pemeriksaan & pemeliharaan rutin terjadwal',
                    'pelaksana' => $pelaksana[$i % 2],
                    'downtime_menit' => rand(20, 120),
                    'hasil' => $hasil[$i % 3],
                    'tanggal' => Carbon::now()->subDays(10 + $i * 15),
                ]);
                $no++;
            }

            // Riwayat sinkronisasi dari SIPPM (source: sippm) — kontrak data sesuai PRD §7
            MaintenanceHistory::create([
                'no_laporan' => 'SIPPM-'.Carbon::now()->subDays(20)->format('Ymd').'-'.Str::padLeft((string) $no, 4, '0'),
                'machine_id' => $machine->id,
                'pm_schedule_id' => null,
                'source' => 'sippm',
                'kategori' => $kategori[$no % 3],
                'pekerjaan' => 'Perbaikan atas laporan kerusakan dari Operator (SIPPM)',
                'pelaksana' => $pelaksana[$no % 2],
                'downtime_menit' => rand(60, 240),
                'hasil' => 'Selesai Diperbaiki',
                'tanggal' => Carbon::now()->subDays(20),
            ]);
            $no++;
        }
    }
}
