<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasTracking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTransfer extends Model
{
    use HasFactory, HasUuid, HasTracking;

    protected $fillable = [
        'id', 'member_id', 'transfer_type', 'status', 'direction',
        'church_name', 'from_class_id', 'to_class_id',
        'transfer_date', 'reason', 'notes', 'processed_by'
    ];

    protected $createdByField = 'processed_by';
    protected $updatedByField = 'processed_by';

    protected $casts = [
        'transfer_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function fromClass()
    {
        return $this->belongsTo(SabbathSchoolClass::class, 'from_class_id');
    }

    public function toClass()
    {
        return $this->belongsTo(SabbathSchoolClass::class, 'to_class_id');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
