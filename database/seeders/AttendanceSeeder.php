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
        $members = Member::all();
        $classes = SabbathSchoolClass::all();
        $users = \App\Models\User::all();

        if ($classes->isEmpty()) return;

        // create 8 weekly attendances for each member (some present, some absent)
        for ($week = 0; $week < 8; $week++) {
            $date = Carbon::now()->subWeeks($week)->previous(Carbon::SATURDAY)->toDateString();

            foreach ($members as $member) {
                // Member must have a class to have attendance recorded easily in this seeder
                $classId = $member->sabbath_school_class_id ?? $classes->random()->id;

                AttendanceRecord::create([
                    'id' => (string) Str::uuid(),
                    'member_id' => $member->member_id,
                    'class_id' => $classId,
                    'date' => $date,
                    'present' => rand(0, 10) > 2, // 80% attendance rate
                    'notes' => null,
                    'marked_by' => $users->random()->id,
                ]);
            }
        }
    }
}
