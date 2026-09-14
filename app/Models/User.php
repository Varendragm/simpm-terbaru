<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'employee_code', 'phone', 'role', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isSupervisor(): bool { return $this->role === 'supervisor'; }
    public function isTeknisi(): bool { return $this->role === 'teknisi'; }
    public function isManajer(): bool { return $this->role === 'manajer'; }

    public function pmSchedules()
    {
        return $this->hasMany(PmSchedule::class, 'technician_id');
    }
}
