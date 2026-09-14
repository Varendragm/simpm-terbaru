<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id', 'jenis', 'technician_id', 'tanggal', 'interval_hari',
        'prioritas', 'status', 'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public const STATUS_LABELS = [
        'terjadwal' => 'Terjadwal',
        'menunggu_validasi' => 'Menunggu Validasi',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function report()
    {
        return $this->hasOne(InspectionReport::class);
    }

    public function validationHistory()
    {
        return $this->hasOne(ValidationHistory::class);
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
