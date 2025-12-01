<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SabbathSchoolClass extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'sabbath_school_classes';

    protected $fillable = [
        'id', 'name', 'description', 'coordinator_id',
        'age_range', 'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* -----------------------
       Relationships
    ------------------------*/

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id', 'id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'sabbath_school_class_id', 'id');
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceRecord::class, 'class_id', 'id');
    }
}
