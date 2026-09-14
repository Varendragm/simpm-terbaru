<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceHistory;
use App\Models\Station;
use Illuminate\Http\Request;

class MaintenanceHistoryController extends Controller
{
    public function index(Request $request)
    {
        $stations = Station::orderBy('name')->get();

        $query = MaintenanceHistory::with('machine.station');

        if ($request->filled('station_id')) {
            $query->whereHas('machine', fn ($q) => $q->where('station_id', $request->station_id));
        }
        if ($request->filled('machine_id')) {
            $query->where('machine_id', $request->machine_id);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        $riwayat = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();

        return view('history.index', compact('riwayat', 'stations'));
    }
}
