<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SystemNotification extends Model
{
    use HasUuid;

    protected $fillable = [
        'id', 'title', 'message', 'type', 'is_read', 'user_id', 'action_url'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    protected $appends = ['read_by_current_user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reads()
    {
        return $this->belongsToMany(User::class, 'notification_reads', 'notification_id', 'user_id')
                    ->withPivot('read_at');
    }

    public function getReadByCurrentUserAttribute()
    {
        if (!Auth::check()) return false;

        // If it's a personal notification (user_id is set), use the is_read flag
        if ($this->user_id) {
            return $this->is_read;
        }

        // If it's a global notification, check the pivot table
        return $this->reads()->where('user_id', Auth::id())->exists();
    }
}
