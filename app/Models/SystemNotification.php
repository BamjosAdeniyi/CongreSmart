<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    use HasUuid;

    protected $fillable = [
        'id', 'title', 'message', 'type', 'is_read', 'user_id', 'action_url'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
