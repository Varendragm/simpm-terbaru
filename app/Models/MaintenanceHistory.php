<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_laporan', 'machine_id', 'pm_schedule_id', 'source', 'kategori',
        'pekerjaan', 'pelaksana', 'downtime_menit', 'hasil', 'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function pmSchedule()
    {
        return $this->belongsTo(PmSchedule::class);
    }
}
