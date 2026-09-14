<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'location', 'description', 'status'];

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
