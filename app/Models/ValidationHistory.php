<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'pm_schedule_id', 'machine_id', 'validated_by', 'hasil', 'catatan', 'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pmSchedule()
    {
        return $this->belongsTo(PmSchedule::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
