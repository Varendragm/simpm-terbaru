<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::with('machines')->orderBy('name')->get();

        return view('stations.index', compact('stations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:20|unique:stations,code',
            'name' => 'required|string|max:150',
            'location' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Station::create($data);

        return back()->with('status', 'Stasiun baru berhasil ditambahkan.');
    }

    public function update(Request $request, Station $station)
    {
        $data = $request->validate([
            'code' => 'required|string|max:20|unique:stations,code,'.$station->id,
            'name' => 'required|string|max:150',
            'location' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $station->update($data);

        return back()->with('status', 'Data stasiun berhasil diperbarui.');
    }

    public function destroy(Station $station)
    {
        if ($station->machines()->exists()) {
            return back()->withErrors(['station' => 'Stasiun tidak dapat dihapus karena masih memiliki mesin.']);
        }

        $station->delete();

        return back()->with('status', 'Stasiun berhasil dihapus.');
    }
}
