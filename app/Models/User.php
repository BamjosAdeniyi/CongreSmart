<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuid;

    protected $fillable = [
        'id', 'name', 'email', 'password', 'role',
        'avatar', 'active', 'last_login',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    /* -----------------------
       Relationships
    ------------------------*/

    public function sabbathClass()
    {
        return $this->hasOne(SabbathSchoolClass::class, 'coordinator_id', 'id');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'recorded_by', 'id');
    }

    public function attendanceMarked()
    {
        return $this->hasMany(AttendanceRecord::class, 'marked_by', 'id');
    }
}
