<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RolePermission;
use Illuminate\Support\Str;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'pastor' => [
                'members_view'=>true,'members_add'=>false,'members_edit'=>false,'members_delete'=>false,
                'sabbath_school_view'=>true,'sabbath_school_manage'=>true,'sabbath_school_mark_attendance'=>false,
                'finance_view'=>true,'finance_record'=>false,'finance_reports'=>true,
                'reports_view'=>true,'reports_export'=>true,
                'settings_view'=>false,'settings_edit'=>false,'users_view'=>false,'users_manage'=>false
            ],
            'clerk' => [
                'members_view'=>true,'members_add'=>true,'members_edit'=>true,'members_delete'=>false,
                'sabbath_school_view'=>false,'sabbath_school_manage'=>false,'sabbath_school_mark_attendance'=>false,
                'finance_view'=>false,'finance_record'=>false,'finance_reports'=>false,
                'reports_view'=>true,'reports_export'=>false,
                'settings_view'=>false,'settings_edit'=>false,'users_view'=>false,'users_manage'=>false
            ],
            'superintendent' => [
                'members_view'=>true,'members_add'=>false,'members_edit'=>false,'members_delete'=>false,
                'sabbath_school_view'=>true,'sabbath_school_manage'=>true,'sabbath_school_mark_attendance'=>false,
                'finance_view'=>false,'finance_record'=>false,'finance_reports'=>false,
                'reports_view'=>true,'reports_export'=>false,
                'settings_view'=>false,'settings_edit'=>false,'users_view'=>false,'users_manage'=>false
            ],
            'coordinator' => [
                'members_view'=>true,'members_add'=>false,'members_edit'=>false,'members_delete'=>false,
                'sabbath_school_view'=>true,'sabbath_school_manage'=>false,'sabbath_school_mark_attendance'=>true,
                'finance_view'=>false,'finance_record'=>false,'finance_reports'=>false,
                'reports_view'=>false,'reports_export'=>false,
                'settings_view'=>false,'settings_edit'=>false,'users_view'=>false,'users_manage'=>false
            ],
            'financial' => [
                'members_view'=>true,'members_add'=>false,'members_edit'=>false,'members_delete'=>false,
                'sabbath_school_view'=>false,'sabbath_school_manage'=>false,'sabbath_school_mark_attendance'=>false,
                'finance_view'=>true,'finance_record'=>true,'finance_reports'=>true,
                'reports_view'=>true,'reports_export'=>true,
                'settings_view'=>false,'settings_edit'=>false,'users_view'=>false,'users_manage'=>false
            ],
            'ict' => [
                'members_view'=>true,'members_add'=>true,'members_edit'=>true,'members_delete'=>true,
                'sabbath_school_view'=>true,'sabbath_school_manage'=>true,'sabbath_school_mark_attendance'=>true,
                'finance_view'=>true,'finance_record'=>true,'finance_reports'=>true,
                'reports_view'=>true,'reports_export'=>true,
                'settings_view'=>true,'settings_edit'=>true,'users_view'=>true,'users_manage'=>true
            ],
            'welfare' => [
                'members_view'=>true,'members_add'=>false,'members_edit'=>false,'members_delete'=>false,
                'sabbath_school_view'=>true,'sabbath_school_manage'=>false,'sabbath_school_mark_attendance'=>false,
                'finance_view'=>false,'finance_record'=>false,'finance_reports'=>false,
                'reports_view'=>true,'reports_export'=>false,
                'settings_view'=>false,'settings_edit'=>false,'users_view'=>false,'users_manage'=>false
            ],
        ];

        foreach ($roles as $role => $perms) {
            RolePermission::create(array_merge(['id' => (string) Str::uuid(), 'role' => $role], $perms));
        }
    }
}
