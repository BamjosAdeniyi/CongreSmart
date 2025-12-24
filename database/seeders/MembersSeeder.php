<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nigerianFirstNamesMale = ['Adewale', 'Emeka', 'Tunde', 'Chinedu', 'Musa', 'Ikenna', 'Olumide', 'Yakubu', 'Abubakar', 'Oluwaseun', 'Babatunde', 'Chijoke', 'Femi', 'Ifeanyi', 'Segun'];
        $nigerianFirstNamesFemale = ['Ngozi', 'Fatima', 'Aisha', 'Bolanle', 'Funmilayo', 'Zainab', 'Chioma', 'Temitope', 'Hadiza', 'Omolara', 'Chinwe', 'Yetunde', 'Amaka', 'Eniola', 'Kemi'];
        $nigerianLastNames = ['Adeoye', 'Okafor', 'Nwankwo', 'Bello', 'Ogunbayo', 'Ibrahim', 'Okoro', 'Adeleke', 'Abdullahi', 'Ojo', 'Eze', 'Suleiman', 'Bankole', 'Ugwu', 'Mohammed', 'Folarin', 'Umar', 'Adekunle', 'Adebisi', 'Garba', 'Oni', 'Obi', 'Danjuma', 'Lawal', 'Yusuf'];

        $classes = \App\Models\SabbathSchoolClass::all();
        $users = \App\Models\User::all();

        for ($i = 0; $i < 30; $i++) {
            $gender = $i % 2 === 0 ? 'male' : 'female';
            $firstName = $gender === 'male' ? $nigerianFirstNamesMale[array_rand($nigerianFirstNamesMale)] : $nigerianFirstNamesFemale[array_rand($nigerianFirstNamesFemale)];
            $lastName = $nigerianLastNames[array_rand($nigerianLastNames)];
            $isBaptized = $i % 5 !== 0;
            $membershipDate = now()->subYears(rand(1, 10))->subDays(rand(1, 365));

            \App\Models\Member::create([
                'member_id' => (string) \Illuminate\Support\Str::uuid(),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'family_name' => $lastName,
                'middle_name' => $i % 3 === 0 ? ($gender === 'male' ? $nigerianFirstNamesMale[array_rand($nigerianFirstNamesMale)] : $nigerianFirstNamesFemale[array_rand($nigerianFirstNamesFemale)]) : null,
                'gender' => $gender,
                'phone' => '080' . rand(10000000, 99999999),
                'email' => strtolower($firstName . '.' . $lastName . $i) . '@example.com',
                'address' => rand(1, 100) . ' Nigerian Way, Lagos, Nigeria',
                'date_of_birth' => now()->subYears(rand(18, 65))->subDays(rand(1, 365)),
                'membership_type' => $i % 4 === 0 ? 'student' : 'community',
                'membership_category' => $i % 5 === 0 ? 'youth' : 'adult',
                'role_in_church' => $i % 10 === 0 ? 'Deacon' : 'Member',
                'baptism_status' => $isBaptized ? 'baptized' : 'not-baptized',
                'date_of_baptism' => $isBaptized ? $membershipDate->copy()->addMonths(rand(1, 6)) : null,
                'membership_date' => $membershipDate,
                'membership_status' => 'active',
                'sabbath_school_class_id' => $classes->isNotEmpty() ? $classes->random()->id : null,
                'created_by' => $users->isNotEmpty() ? $users->random()->id : null,
                'updated_by' => $users->isNotEmpty() ? $users->random()->id : null,
            ]);
        }
    }
}
