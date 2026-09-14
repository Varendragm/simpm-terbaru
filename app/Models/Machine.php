<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id', 'code', 'name', 'type', 'capacity', 'install_year', 'status', 'notes',
    ];

    public const STATUS_LABELS = [
        'normal' => 'Normal',
        'perhatian' => 'Perlu Perhatian',
        'perbaikan' => 'Dalam Perbaikan',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function performanceData()
    {
        return $this->hasMany(MachinePerformanceData::class);
    }

    public function pmSchedules()
    {
        return $this->hasMany(PmSchedule::class);
    }

    public function maintenanceHistories()
    {
        return $this->hasMany(MaintenanceHistory::class);
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
