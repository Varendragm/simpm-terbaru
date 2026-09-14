<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\Station;
use Illuminate\Database\Seeder;

class StationMachineSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            ['code' => 'STG', 'name' => 'Stasiun Gilingan', 'location' => 'Area Produksi — Depan', 'description' => 'Ekstraksi nira dari batang tebu melalui rangkaian unit gilingan.', 'status' => 'aktif'],
            ['code' => 'STB', 'name' => 'Stasiun Boiler', 'location' => 'Area Produksi — Tengah', 'description' => 'Penyediaan uap untuk kebutuhan proses produksi & pembangkit listrik.', 'status' => 'aktif'],
            ['code' => 'STP', 'name' => 'Stasiun Puteran & Pemurnian', 'location' => 'Area Produksi — Belakang', 'description' => 'Pemisahan kristal gula dari larutan melalui proses puteran.', 'status' => 'aktif'],
        ];

        $stationIds = [];
        foreach ($stations as $s) {
            $stationIds[$s['code']] = Station::updateOrCreate(['code' => $s['code']], $s)->id;
        }

        $machines = [
            ['code' => 'G01', 'station' => 'STG', 'name' => 'Gilingan 01', 'type' => 'Unit Gilingan Tebu', 'status' => 'normal', 'capacity' => '120 TCD', 'install_year' => 2010, 'notes' => 'Unit gilingan pertama pada rangkaian ekstraksi.'],
            ['code' => 'G02', 'station' => 'STG', 'name' => 'Gilingan 02', 'type' => 'Unit Gilingan Tebu', 'status' => 'perhatian', 'capacity' => '120 TCD', 'install_year' => 2010, 'notes' => 'Riwayat getaran meningkat pada dudukan motor.'],
            ['code' => 'G03', 'station' => 'STG', 'name' => 'Gilingan 03', 'type' => 'Unit Gilingan Tebu', 'status' => 'normal', 'capacity' => '120 TCD', 'install_year' => 2012, 'notes' => null],
            ['code' => 'G04', 'station' => 'STG', 'name' => 'Gilingan 04', 'type' => 'Unit Gilingan Tebu', 'status' => 'perbaikan', 'capacity' => '120 TCD', 'install_year' => 2012, 'notes' => 'Sedang dalam perbaikan panel motor.'],
            ['code' => 'B01', 'station' => 'STB', 'name' => 'Boiler 01', 'type' => 'Ketel Uap Pipa Air', 'status' => 'normal', 'capacity' => '20 ton uap/jam', 'install_year' => 2008, 'notes' => null],
            ['code' => 'B02', 'station' => 'STB', 'name' => 'Boiler 02', 'type' => 'Ketel Uap Pipa Air', 'status' => 'normal', 'capacity' => '20 ton uap/jam', 'install_year' => 2008, 'notes' => null],
            ['code' => 'B03', 'station' => 'STB', 'name' => 'Boiler 03', 'type' => 'Ketel Uap Pipa Air', 'status' => 'perhatian', 'capacity' => '25 ton uap/jam', 'install_year' => 2015, 'notes' => 'Efisiensi pembakaran menurun, perlu pemeriksaan burner.'],
            ['code' => 'P01', 'station' => 'STP', 'name' => 'Puteran 01', 'type' => 'Centrifugal Batch', 'status' => 'normal', 'capacity' => '1.5 ton/batch', 'install_year' => 2011, 'notes' => null],
            ['code' => 'P02', 'station' => 'STP', 'name' => 'Puteran 02', 'type' => 'Centrifugal Batch', 'status' => 'normal', 'capacity' => '1.5 ton/batch', 'install_year' => 2011, 'notes' => null],
        ];

        foreach ($machines as $m) {
            $stationCode = $m['station'];
            unset($m['station']);
            $m['station_id'] = $stationIds[$stationCode];
            Machine::updateOrCreate(['code' => $m['code']], $m);
        }
    }
}
