<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Station;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'station_id' => 'required|exists:stations,id',
            'code' => 'required|string|max:20|unique:machines,code',
            'name' => 'required|string|max:150',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|string|max:100',
            'install_year' => 'nullable|integer|min:1950|max:'.(date('Y') + 1),
            'status' => 'required|in:normal,perhatian,perbaikan',
            'notes' => 'nullable|string',
        ]);

        Machine::create($data);

        return back()->with('status', 'Mesin baru berhasil ditambahkan.');
    }

    public function update(Request $request, Machine $machine)
    {
        $data = $request->validate([
            'station_id' => 'required|exists:stations,id',
            'code' => 'required|string|max:20|unique:machines,code,'.$machine->id,
            'name' => 'required|string|max:150',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|string|max:100',
            'install_year' => 'nullable|integer|min:1950|max:'.(date('Y') + 1),
            'status' => 'required|in:normal,perhatian,perbaikan',
            'notes' => 'nullable|string',
        ]);

        $machine->update($data);

        return back()->with('status', 'Data mesin berhasil diperbarui.');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();

        return back()->with('status', 'Mesin berhasil dihapus.');
    }

    /** Endpoint kecil untuk mengisi <select> mesin secara dinamis (filter berjenjang). */
    public function byStation(Station $station)
    {
        return response()->json(
            $station->machines()->orderBy('name')->get(['id', 'name', 'code'])
        );
    }
}
