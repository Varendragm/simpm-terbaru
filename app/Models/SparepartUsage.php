<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparepartUsage extends Model
{
    protected $fillable = ['inspection_report_id', 'nama', 'jumlah', 'satuan'];

    public function inspectionReport()
    {
        return $this->belongsTo(InspectionReport::class);
    }
}
