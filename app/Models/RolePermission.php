<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'role_permissions';

    protected $fillable = [
        'id', 'role',
        'members_view', 'members_add', 'members_edit', 'members_delete',
        'sabbath_school_view', 'sabbath_school_manage', 'sabbath_school_mark_attendance',
        'finance_view', 'finance_record', 'finance_reports',
        'reports_view', 'reports_export',
        'settings_view', 'settings_edit',
        'users_view', 'users_manage',
        'updated_by'
    ];

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
