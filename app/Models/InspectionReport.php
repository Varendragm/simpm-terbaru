<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'pm_schedule_id', 'kategori', 'parameter_teknis', 'deskripsi_temuan',
        'tindakan', 'rekomendasi', 'downtime_menit', 'submitted_at',
    ];

    protected $casts = [
        'parameter_teknis' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function pmSchedule()
    {
        return $this->belongsTo(PmSchedule::class);
    }

    public function spareparts()
    {
        return $this->hasMany(SparepartUsage::class);
    }
}
