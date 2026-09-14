<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MaintenanceHistory;
use App\Models\PmSchedule;
use App\Services\PerformanceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request, PerformanceCalculator $calculator)
    {
        $user = Auth::user();

        return match ($user->role) {
            'supervisor' => $this->supervisor($calculator),
            'manajer' => $this->manajer($calculator),
            'teknisi' => $this->teknisi($user),
            default => abort(403),
        };
    }

    protected function supervisor(PerformanceCalculator $calculator)
    {
        $machines = Machine::with('station')->get();
        $period = Carbon::now()->format('Y-m');

        $totalMesin = $machines->count();
        $mesinNormal = $machines->where('status', 'normal')->count();
        $mesinPerhatian = $machines->where('status', 'perhatian')->count();
        $maintenanceHariIni = PmSchedule::whereDate('tanggal', Carbon::today())->count();

        $downtimeBulanIni = MaintenanceHistory::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('downtime_menit');

        $perf = $calculator->forMachines($machines, $period);

        $mesinPerluPerhatian = $machines->whereIn('status', ['perhatian', 'perbaikan'])->take(6);

        $jadwalTerdekat = PmSchedule::with('machine.station', 'technician')
            ->where('status', 'terjadwal')
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal')
            ->take(6)
            ->get();

        $menungguValidasi = PmSchedule::with('machine.station', 'technician')
            ->where('status', 'menunggu_validasi')
            ->orderBy('updated_at', 'desc')
            ->take(6)
            ->get();

        $downtimePerMesin = $machines->map(function ($m) use ($period, $calculator) {
            $p = $calculator->forMachine($m, $period);

            return ['label' => $m->name, 'value' => $p['downtime_minutes']];
        });

        return view('dashboard.supervisor', compact(
            'totalMesin', 'mesinNormal', 'mesinPerhatian', 'maintenanceHariIni',
            'downtimeBulanIni', 'perf', 'mesinPerluPerhatian', 'jadwalTerdekat',
            'menungguValidasi', 'downtimePerMesin'
        ));
    }

    protected function manajer(PerformanceCalculator $calculator)
    {
        $machines = Machine::with('station')->get();
        $period = Carbon::now()->format('Y-m');
        $perf = $calculator->forMachines($machines, $period);

        $totalDowntime = MaintenanceHistory::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('downtime_menit');

        $totalPerbaikan = MaintenanceHistory::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->count();

        $rankingBermasalah = $machines->map(function ($m) use ($period, $calculator) {
            $p = $calculator->forMachine($m, $period);

            return ['machine' => $m, 'downtime' => $p['downtime_minutes']];
        })->sortByDesc('downtime')->take(5);

        $downtimePerMesin = $machines->map(function ($m) use ($period, $calculator) {
            $p = $calculator->forMachine($m, $period);

            return ['label' => $m->name, 'value' => $p['downtime_minutes']];
        });

        return view('dashboard.manajer', compact(
            'perf', 'totalDowntime', 'totalPerbaikan', 'rankingBermasalah', 'downtimePerMesin'
        ));
    }

    protected function teknisi($user)
    {
        $jadwalAktif = PmSchedule::where('technician_id', $user->id)
            ->whereIn('status', ['terjadwal', 'menunggu_validasi'])
            ->count();

        $jatuhTempoHariIni = PmSchedule::where('technician_id', $user->id)
            ->whereDate('tanggal', Carbon::today())
            ->where('status', 'terjadwal')
            ->count();

        $selesaiBulanIni = PmSchedule::where('technician_id', $user->id)
            ->where('status', 'selesai')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->count();

        $jadwalSaya = PmSchedule::with('machine.station')
            ->where('technician_id', $user->id)
            ->whereIn('status', ['terjadwal', 'menunggu_validasi'])
            ->orderBy('tanggal')
            ->get();

        return view('dashboard.teknisi', compact(
            'jadwalAktif', 'jatuhTempoHariIni', 'selesaiBulanIni', 'jadwalSaya'
        ));
    }
}
