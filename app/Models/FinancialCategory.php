<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialCategory extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'id', 'name', 'description', 'category_type',
        'active', 'created_by'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /* -----------------------
       Relationships
    ------------------------*/

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'category_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
