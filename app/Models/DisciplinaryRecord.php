<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisciplinaryRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'discipline_record_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'discipline_record_id',
        'member_id',
        'offense_type',
        'offense_description',
        'discipline_type',
        'start_date',
        'end_date',
        'status',
        'recorded_by',
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
