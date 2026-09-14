<?php

namespace App\Http\Controllers;

use App\Models\InspectionReport;
use App\Models\PmSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspectionReportController extends Controller
{
    /** Form pengisian laporan pemeriksaan oleh Teknisi untuk satu jadwal PM. */
    public function create(PmSchedule $schedule)
    {
        $this->authorizeOwner($schedule);

        abort_if($schedule->status !== 'terjadwal', 403, 'Jadwal ini sudah tidak dapat diisi laporannya.');

        return view('schedules.report', compact('schedule'));
    }

    public function store(Request $request, PmSchedule $schedule)
    {
        $this->authorizeOwner($schedule);

        $data = $request->validate([
            'kategori' => 'required|in:mekanik,elektrik,instrumentasi',
            'parameter_teknis' => 'nullable|array',
            'deskripsi_temuan' => 'required|string',
            'tindakan' => 'required|string',
            'rekomendasi' => 'nullable|string',
            'downtime_menit' => 'required|integer|min:0',
            'spareparts' => 'nullable|array',
            'spareparts.*.nama' => 'required_with:spareparts|string|max:150',
            'spareparts.*.jumlah' => 'required_with:spareparts|numeric|min:0',
            'spareparts.*.satuan' => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($data, $schedule) {
            $report = InspectionReport::updateOrCreate(
                ['pm_schedule_id' => $schedule->id],
                [
                    'kategori' => $data['kategori'],
                    'parameter_teknis' => $data['parameter_teknis'] ?? null,
                    'deskripsi_temuan' => $data['deskripsi_temuan'],
                    'tindakan' => $data['tindakan'],
                    'rekomendasi' => $data['rekomendasi'] ?? null,
                    'downtime_menit' => $data['downtime_menit'],
                    'submitted_at' => now(),
                ]
            );

            $report->spareparts()->delete();
            foreach ($data['spareparts'] ?? [] as $row) {
                $report->spareparts()->create($row);
            }

            $schedule->update(['status' => 'menunggu_validasi']);
        });

        return redirect()->route('schedules.index')->with('status', 'Laporan pemeriksaan berhasil dikirim untuk validasi.');
    }

    protected function authorizeOwner(PmSchedule $schedule): void
    {
        $user = Auth::user();
        abort_unless($user->isTeknisi() && $schedule->technician_id === $user->id, 403);
    }
}
