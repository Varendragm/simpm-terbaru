<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Station;
use App\Services\PerformanceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PerformanceController extends Controller
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

        $machines = $machinesQuery->orderBy('name')->get();

        $rows = $machines->map(function ($machine) use ($calculator, $period) {
            return [
                'machine' => $machine,
                'perf' => $calculator->forMachine($machine, $period),
            ];
        });

        $chartOee = $rows->map(fn ($r) => [
            'label' => $r['machine']->name,
            'value' => $r['perf']['oee'] ?? 0,
        ]);

        return view('performance.index', compact('stations', 'machines', 'rows', 'period', 'chartOee'));
    }

    public function show(Request $request, Machine $machine, PerformanceCalculator $calculator)
    {
        $period = $request->get('period', Carbon::now()->format('Y-m'));
        $perf = $calculator->forMachine($machine, $period);

        $periods = collect(range(0, 5))->map(fn ($i) => Carbon::now()->subMonths(5 - $i)->format('Y-m'));
        $trend = $calculator->trend($machine, $periods->all());

        $nextSchedule = $machine->pmSchedules()
            ->where('status', 'terjadwal')
            ->where('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->first();

        $riwayat = $machine->maintenanceHistories()->orderByDesc('tanggal')->take(15)->get();

        return view('performance.show', compact('machine', 'perf', 'period', 'trend', 'nextSchedule', 'riwayat'));
    }
}
