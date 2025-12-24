<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceRecord extends Model
{
    use HasFactory, HasUuid, HasTracking;

    protected $table = 'attendance_records';

    protected $fillable = [
        'id', 'member_id', 'class_id', 'date',
        'present', 'notes', 'marked_by', 'updated_by'
    ];

    protected $casts = [
        'present' => 'boolean',
        'date' => 'date',
    ];

    /* -----------------------
       Relationships
    ------------------------*/

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function class()
    {
        return $this->belongsTo(SabbathSchoolClass::class, 'class_id', 'id');
    }

    public function marker()
    {
        return $this->belongsTo(User::class, 'marked_by', 'id');
    }
}
