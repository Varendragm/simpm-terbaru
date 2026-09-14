<?php

namespace App\Services;

use App\Models\Machine;
use App\Models\MachinePerformanceData;
use Illuminate\Support\Collection;

/**
 * Menghitung indikator performa mesin (OEE, Availability, Reliability, MTTR, MTBF)
 * dari data operasional mentah (machine_performance_data), sesuai PRD §6.8 dan
 * design.md §5. Tidak pernah mengarang/menyimpan angka performa sebagai data statis.
 *
 * Jika data input untuk suatu indikator belum tersedia, nilai dikembalikan sebagai
 * null dan tampilan wajib menunjukkan status "Belum tersedia" alih-alih 0 atau angka fiktif.
 */
class PerformanceCalculator
{
    /**
     * Hitung seluruh indikator performa satu mesin untuk satu periode (format YYYY-MM).
     * Jika $period null, menghitung akumulasi dari seluruh data yang ada.
     */
    public function forMachine(Machine $machine, ?string $period = null): array
    {
        $query = $machine->performanceData();

        if ($period) {
            $query->where('period', $period);
        }

        $rows = $query->get();

        return $this->fromRows($rows);
    }

    /**
     * Hitung indikator performa gabungan (rata-rata pabrik) dari kumpulan mesin.
     */
    public function forMachines(Collection $machines, ?string $period = null): array
    {
        $rows = MachinePerformanceData::whereIn('machine_id', $machines->pluck('id'))
            ->when($period, fn ($q) => $q->where('period', $period))
            ->get();

        return $this->fromRows($rows);
    }

    /**
     * Tren OEE mingguan/bulanan untuk grafik (mengembalikan array periode => oee|null).
     */
    public function trend(Machine $machine, array $periods): array
    {
        $trend = [];
        foreach ($periods as $period) {
            $result = $this->forMachine($machine, $period);
            $trend[$period] = $result['oee'];
        }

        return $trend;
    }

    protected function fromRows(Collection $rows): array
    {
        if ($rows->isEmpty()) {
            return $this->emptyResult();
        }

        $plannedTime = (int) $rows->sum('planned_time_minutes');
        $downtime = (int) $rows->sum('downtime_minutes');
        $repairTime = (int) $rows->sum('repair_time_minutes');
        $failureCount = (int) $rows->sum('failure_count');

        $hasOutputData = $rows->every(fn ($r) => $r->actual_output !== null && $r->ideal_output !== null && $r->good_output !== null);
        $actualOutput = $hasOutputData ? (int) $rows->sum('actual_output') : null;
        $idealOutput = $hasOutputData ? (int) $rows->sum('ideal_output') : null;
        $goodOutput = $hasOutputData ? (int) $rows->sum('good_output') : null;

        // Availability = (Planned Time - Downtime) / Planned Time x 100%
        $availability = $plannedTime > 0
            ? round((($plannedTime - $downtime) / $plannedTime) * 100, 2)
            : null;

        // MTTR = Total Repair Time / Number of Failures
        $mttr = $failureCount > 0 ? round($repairTime / $failureCount, 2) : null;

        // MTBF = Total Operating Time / Number of Failures
        $operatingTime = max($plannedTime - $downtime, 0);
        $mtbf = $failureCount > 0 ? round($operatingTime / $failureCount, 2) : null;

        // Reliability = e^(-t / MTBF) x 100%, t diasumsikan = rata-rata operating time per kegagalan (di sini memakai operating time berjalan)
        $reliability = ($mtbf !== null && $mtbf > 0)
            ? round(exp(-$operatingTime / max($mtbf, 0.0001)) * 100, 2)
            : null;

        // Performance = Actual Output / Ideal Output x 100%
        $performance = ($idealOutput !== null && $idealOutput > 0)
            ? round(($actualOutput / $idealOutput) * 100, 2)
            : null;

        // Quality = Good Output / Total Output(actual) x 100%
        $quality = ($actualOutput !== null && $actualOutput > 0)
            ? round(($goodOutput / $actualOutput) * 100, 2)
            : null;

        // OEE = Availability x Performance x Quality (semuanya dalam desimal 0-1, hasil dalam %)
        $oee = ($availability !== null && $performance !== null && $quality !== null)
            ? round(($availability / 100) * ($performance / 100) * ($quality / 100) * 100, 2)
            : null;

        return [
            'availability' => $availability,
            'performance' => $performance,
            'quality' => $quality,
            'oee' => $oee,
            'mttr' => $mttr,
            'mtbf' => $mtbf,
            'reliability' => $reliability,
            'downtime_minutes' => $downtime,
            'planned_time_minutes' => $plannedTime,
            'failure_count' => $failureCount,
            'has_data' => true,
        ];
    }

    protected function emptyResult(): array
    {
        return [
            'availability' => null,
            'performance' => null,
            'quality' => null,
            'oee' => null,
            'mttr' => null,
            'mtbf' => null,
            'reliability' => null,
            'downtime_minutes' => 0,
            'planned_time_minutes' => 0,
            'failure_count' => 0,
            'has_data' => false,
        ];
    }
}
