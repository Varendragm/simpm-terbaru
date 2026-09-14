<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachinePerformanceData extends Model
{
    use HasFactory;

    protected $table = 'machine_performance_data';

    protected $fillable = [
        'machine_id', 'period', 'planned_time_minutes', 'downtime_minutes',
        'repair_time_minutes', 'failure_count', 'actual_output', 'ideal_output', 'good_output',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
