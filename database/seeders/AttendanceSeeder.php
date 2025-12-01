<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttendanceRecord;
use App\Models\Member;
use App\Models\SabbathSchoolClass;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::take(8)->pluck('member_id')->toArray();
        $classes = SabbathSchoolClass::pluck('id')->toArray();
        $user = null; // optional: you can set recorded_by to a seeded user id if you wish

        // create 4 weekly attendances for each member (some present, some absent)
        for ($week = 0; $week < 4; $week++) {
            $date = Carbon::now()->subWeeks($week)->next(\Carbon\Carbon::SATURDAY)->toDateString();
            foreach ($members as $i => $memberId) {
                AttendanceRecord::create([
                    'id' => (string) Str::uuid(),
                    'member_id' => $memberId,
                    'class_id' => $classes[$i % count($classes)] ?? null,
                    'date' => $date,
                    'present' => ($i + $week) % 3 !== 0,
                    'notes' => null,
                    'marked_by' => null,
                ]);
            }
        }
    }
}
