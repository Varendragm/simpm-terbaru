<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MaintenanceHistory;
use App\Models\Station;
use App\Services\PerformanceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request, PerformanceCalculator $calculator)
    {
        $stations = Station::orderBy('name')->get();
        $period = $request->get('period', Carbon::now()->format('Y-m'));

        $machinesQuery = Machine::with('station');
        if ($request->filled('station_id')) {
            $machinesQuery->where('station_id', $request->station_id);
        }
        if ($request->filled('machine_id')) {
            $machinesQuery->where('id', $request->machine_id);
        }
        $machines = $machinesQuery->get();

        $perf = $calculator->forMachines($machines, $period);

        [$year, $month] = array_map('intval', explode('-', $period));

        $historyQuery = MaintenanceHistory::whereIn('machine_id', $machines->pluck('id'))
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month);

        $totalMaintenance = (clone $historyQuery)->count();
        $totalDowntime = (clone $historyQuery)->sum('downtime_menit');

        $mesinNormal = $machines->where('status', 'normal')->count();
        $mesinWarning = $machines->where('status', 'perhatian')->count();
        $mesinCritical = $machines->where('status', 'perbaikan')->count();

        $oeePerMesin = $machines->map(fn ($m) => [
            'label' => $m->name,
            'value' => $calculator->forMachine($m, $period)['oee'] ?? 0,
        ]);

        $downtimePerMesin = $machines->map(fn ($m) => [
            'label' => $m->name,
            'value' => $calculator->forMachine($m, $period)['downtime_minutes'] ?? 0,
        ]);

        $trendPeriods = collect(range(0, 5))->map(fn ($i) => Carbon::now()->subMonths(5 - $i)->format('Y-m'));
        $trendDowntime = $trendPeriods->map(function ($p) use ($machines) {
            [$y, $m] = array_map('intval', explode('-', $p));

            return [
                'label' => $p,
                'value' => MaintenanceHistory::whereIn('machine_id', $machines->pluck('id'))
                    ->whereYear('tanggal', $y)->whereMonth('tanggal', $m)->sum('downtime_menit'),
            ];
        });

        $perStation = $machines->groupBy('station.name')->map(function ($group, $stationName) use ($historyQuery) {
            $ids = $group->pluck('id');

            return [
                'stasiun' => $stationName,
                'jumlah_mesin' => $group->count(),
                'total_maintenance' => MaintenanceHistory::whereIn('machine_id', $ids)->count(),
                'total_downtime' => MaintenanceHistory::whereIn('machine_id', $ids)->sum('downtime_menit'),
            ];
        })->values();

        return view('reports.index', compact(
            'stations', 'machines', 'period', 'perf', 'totalMaintenance', 'totalDowntime',
            'mesinNormal', 'mesinWarning', 'mesinCritical', 'oeePerMesin', 'downtimePerMesin',
            'trendDowntime', 'perStation'
        ));
    }
}
