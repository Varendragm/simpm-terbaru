<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\PmSchedule;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PmScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $stations = Station::orderBy('name')->get();
        $teknisi = User::where('role', 'teknisi')->orderBy('name')->get();

        $query = PmSchedule::with('machine.station', 'technician');

        if ($user->isTeknisi()) {
            $query->where('technician_id', $user->id);
        }

        if ($request->filled('station_id')) {
            $query->whereHas('machine', fn ($q) => $q->where('station_id', $request->station_id));
        }
        if ($request->filled('machine_id')) {
            $query->where('machine_id', $request->machine_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        $jadwal = $query->orderBy('tanggal')->paginate(20)->withQueryString();

        return view('schedules.index', compact('jadwal', 'stations', 'teknisi'));
    }

    public function create()
    {
        $this->authorizeSupervisor();

        $stations = Station::orderBy('name')->get();
        $teknisi = User::where('role', 'teknisi')->orderBy('name')->get();

        return view('schedules.create', compact('stations', 'teknisi'));
    }

    public function store(Request $request)
    {
        $this->authorizeSupervisor();

        $data = $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'jenis' => 'required|string|max:150',
            'technician_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'interval_hari' => 'nullable|integer|min:0',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
        ]);

        $data['status'] = 'terjadwal';
        $data['created_by'] = Auth::id();

        PmSchedule::create($data);

        return redirect()->route('schedules.index')->with('status', 'Jadwal preventive maintenance berhasil dibuat.');
    }

    public function show(PmSchedule $schedule)
    {
        $schedule->load('machine.station', 'technician', 'report.spareparts', 'validationHistory');

        return view('schedules.show', compact('schedule'));
    }

    protected function authorizeSupervisor(): void
    {
        abort_unless(Auth::user()->isSupervisor(), 403, 'Hanya Supervisor yang dapat mengelola jadwal.');
    }
}
