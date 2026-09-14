<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceHistory;
use App\Models\PmSchedule;
use App\Models\ValidationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ValidationController extends Controller
{
    public function index()
    {
        $antrean = PmSchedule::with('machine.station', 'technician', 'report')
            ->where('status', 'menunggu_validasi')
            ->orderBy('updated_at')
            ->get();

        $riwayat = ValidationHistory::with('machine', 'pmSchedule', 'validator')
            ->orderByDesc('tanggal')
            ->take(20)
            ->get();

        return view('validation.index', compact('antrean', 'riwayat'));
    }

    public function show(PmSchedule $schedule)
    {
        abort_unless($schedule->status === 'menunggu_validasi', 404);
        $schedule->load('machine.station', 'technician', 'report.spareparts');

        return view('validation.show', compact('schedule'));
    }

    public function store(Request $request, PmSchedule $schedule)
    {
        $data = $request->validate([
            'hasil' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
            'jadwal_berikutnya' => 'nullable|date',
        ]);

        DB::transaction(function () use ($data, $schedule) {
            $schedule->update([
                'status' => $data['hasil'] === 'disetujui' ? 'selesai' : 'ditolak',
            ]);

            ValidationHistory::create([
                'pm_schedule_id' => $schedule->id,
                'machine_id' => $schedule->machine_id,
                'validated_by' => Auth::id(),
                'hasil' => $data['hasil'],
                'catatan' => $data['catatan'] ?? null,
                'tanggal' => now(),
            ]);

            if ($data['hasil'] === 'disetujui') {
                MaintenanceHistory::create([
                    'no_laporan' => 'PM-'.now()->format('Ymd').'-'.Str::padLeft((string) $schedule->id, 4, '0'),
                    'machine_id' => $schedule->machine_id,
                    'pm_schedule_id' => $schedule->id,
                    'source' => 'pm',
                    'kategori' => optional($schedule->report)->kategori,
                    'pekerjaan' => $schedule->jenis,
                    'pelaksana' => optional($schedule->technician)->name,
                    'downtime_menit' => optional($schedule->report)->downtime_menit ?? 0,
                    'hasil' => 'Baik',
                    'tanggal' => now(),
                ]);
            }

            if (! empty($data['jadwal_berikutnya'])) {
                PmSchedule::create([
                    'machine_id' => $schedule->machine_id,
                    'jenis' => $schedule->jenis,
                    'technician_id' => $schedule->technician_id,
                    'tanggal' => $data['jadwal_berikutnya'],
                    'interval_hari' => $schedule->interval_hari,
                    'prioritas' => $schedule->prioritas,
                    'status' => 'terjadwal',
                    'created_by' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('validation.index')->with('status', 'Validasi berhasil disimpan.');
    }
}
