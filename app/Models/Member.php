<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory, HasUuid;

    protected $primaryKey = 'member_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'member_id', 'first_name', 'middle_name', 'last_name',
        'family_name', 'gender', 'phone', 'email', 'address',
        'date_of_birth', 'membership_type', 'membership_category',
        'role_in_church', 'baptism_status', 'date_of_baptism',
        'membership_date', 'membership_status',
        'sabbath_school_class_id', 'photo',
        'active_disciplinary_record_id',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_baptism' => 'date',
        'membership_date' => 'date',
    ];

    /* -----------------------
       Accessors
    ------------------------*/

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? \Carbon\Carbon::parse($this->date_of_birth)->age : 0;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'member_id';
    }

    /* -----------------------
       Relationships
    ------------------------*/

    public function sabbathClass()
    {
        return $this->belongsTo(SabbathSchoolClass::class, 'sabbath_school_class_id', 'id');
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceRecord::class, 'member_id', 'member_id');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'member_id', 'member_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
