<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\SabbathSchoolClass;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MembersSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SabbathSchoolClass::pluck('id')->toArray();

        $members = [
            ['first_name'=>'John','last_name'=>'Doe','family_name'=>'Doe','gender'=>'male'],
            ['first_name'=>'Jane','last_name'=>'Smith','family_name'=>'Smith','gender'=>'female'],
            ['first_name'=>'Mary','last_name'=>'Johnson','family_name'=>'Johnson','gender'=>'female'],
            ['first_name'=>'Samuel','last_name'=>'Okoro','family_name'=>'Okoro','gender'=>'male'],
            ['first_name'=>'Grace','last_name'=>'Ibrahim','family_name'=>'Ibrahim','gender'=>'female'],
            ['first_name'=>'Paul','last_name'=>'Brown','family_name'=>'Brown','gender'=>'male'],
            ['first_name'=>'Ruth','last_name'=>'Adams','family_name'=>'Adams','gender'=>'female'],
            ['first_name'=>'Peter','last_name'=>'Kofi','family_name'=>'Kofi','gender'=>'male'],
            ['first_name'=>'Linda','last_name'=>'Akin','family_name'=>'Akin','gender'=>'female'],
            ['first_name'=>'Daniel','last_name'=>'Eze','family_name'=>'Eze','gender'=>'male'],
            ['first_name'=>'Evelyn','last_name'=>'Nwosu','family_name'=>'Nwosu','gender'=>'female'],
            ['first_name'=>'Michael','last_name'=>'Okafor','family_name'=>'Okafor','gender'=>'male'],
        ];

        foreach ($members as $index => $m) {
            Member::create([
                'member_id' => (string) Str::uuid(),
                'first_name' => $m['first_name'],
                'middle_name' => null,
                'last_name' => $m['last_name'],
                'family_name' => $m['family_name'],
                'gender' => $m['gender'],
                'phone' => null,
                'email' => null,
                'address' => null,
                'date_of_birth' => Carbon::now()->subYears(20 + ($index % 15)),
                'membership_type' => 'community',
                'membership_category' => ($index % 3 === 0) ? 'adult' : 'adult',
                'role_in_church' => null,
                'baptism_status' => 'baptized',
                'date_of_baptism' => Carbon::now()->subYears(1 + ($index % 3)),
                'membership_date' => Carbon::now()->subYears(1 + ($index % 3)),
                'membership_status' => 'active',
                'sabbath_school_class_id' => $classes[$index % count($classes)] ?? null,
                'created_by' => null,
                'updated_by' => null,
                'photo' => null,
            ]);
        }
    }
}
