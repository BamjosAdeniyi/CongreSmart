<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contribution extends Model
{
    use HasFactory, HasUuid, HasTracking;

    protected $fillable = [
        'id', 'member_id', 'category_id', 'amount',
        'date', 'payment_method', 'reference_number',
        'notes', 'recorded_by', 'updated_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    /* -----------------------
       Relationships
    ------------------------*/

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function category()
    {
        return $this->belongsTo(FinancialCategory::class, 'category_id', 'id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }
}
