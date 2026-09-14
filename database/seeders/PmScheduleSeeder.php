<?php

namespace Database\Seeders;

use App\Models\InspectionReport;
use App\Models\Machine;
use App\Models\PmSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PmScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $supervisor = User::where('role', 'supervisor')->first();
        $teknisiList = User::where('role', 'teknisi')->get();
        $machines = Machine::all();

        if ($machines->isEmpty() || $teknisiList->isEmpty()) {
            return;
        }

        $jenisList = [
            'Pemeriksaan Rutin Bulanan',
            'Pelumasan & Pengencangan Baut',
            'Pemeriksaan Kelistrikan',
            'Pemeriksaan Getaran & Bearing',
            'Kalibrasi Instrumen',
        ];

        $prioritasList = ['rendah', 'sedang', 'tinggi'];
        $today = Carbon::today();

        $i = 0;
        foreach ($machines as $machine) {
            $teknisi = $teknisiList[$i % $teknisiList->count()];

            // 1) Jadwal yang akan datang (status: terjadwal)
            PmSchedule::create([
                'machine_id' => $machine->id,
                'jenis' => $jenisList[$i % count($jenisList)],
                'technician_id' => $teknisi->id,
                'tanggal' => $today->copy()->addDays(2 + $i),
                'interval_hari' => 30,
                'prioritas' => $prioritasList[$i % 3],
                'status' => 'terjadwal',
                'created_by' => $supervisor?->id,
            ]);

            // 2) Jadwal hari ini (status: terjadwal) — untuk demo dashboard "Maintenance Hari Ini"
            if ($i < 2) {
                PmSchedule::create([
                    'machine_id' => $machine->id,
                    'jenis' => 'Pemeriksaan Harian',
                    'technician_id' => $teknisi->id,
                    'tanggal' => $today,
                    'interval_hari' => 1,
                    'prioritas' => 'sedang',
                    'status' => 'terjadwal',
                    'created_by' => $supervisor?->id,
                ]);
            }

            // 3) Jadwal yang sudah diisi laporan & menunggu validasi
            if ($i < 3) {
                $menunggu = PmSchedule::create([
                    'machine_id' => $machine->id,
                    'jenis' => 'Pemeriksaan Rutin Mingguan',
                    'technician_id' => $teknisi->id,
                    'tanggal' => $today->copy()->subDays(1),
                    'interval_hari' => 7,
                    'prioritas' => 'sedang',
                    'status' => 'menunggu_validasi',
                    'created_by' => $supervisor?->id,
                ]);

                InspectionReport::create([
                    'pm_schedule_id' => $menunggu->id,
                    'kategori' => ['mekanik', 'elektrik', 'instrumentasi'][$i % 3],
                    'deskripsi_temuan' => 'Ditemukan indikasi keausan ringan pada komponen bergerak, suara operasional dalam batas normal.',
                    'tindakan' => 'Dilakukan pelumasan ulang dan pengencangan baut pengikat, pembersihan filter udara.',
                    'rekomendasi' => 'Jadwalkan pemeriksaan lanjutan dalam 30 hari ke depan.',
                    'downtime_menit' => 45 + ($i * 10),
                    'submitted_at' => now()->subHours(6),
                ]);
            }

            $i++;
        }
    }
}
