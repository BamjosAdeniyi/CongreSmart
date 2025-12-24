<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\SabbathSchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $nigerianFirstNamesMale = ['Adewale', 'Emeka', 'Tunde', 'Chinedu', 'Musa', 'Ikenna', 'Olumide', 'Yakubu', 'Abubakar', 'Oluwaseun'];
        $nigerianFirstNamesFemale = ['Ngozi', 'Fatima', 'Aisha', 'Bolanle', 'Funmilayo', 'Zainab', 'Chioma', 'Temitope', 'Hadiza', 'Omolara'];
        $nigerianLastNames = ['Adeoye', 'Okafor', 'Nwankwo', 'Bello', 'Ogunbayo', 'Ibrahim', 'Okoro', 'Adeleke', 'Abdullahi', 'Ojo', 'Eze', 'Suleiman', 'Bankole', 'Ugwu', 'Mohammed', 'Folarin', 'Umar', 'Adekunle', 'Adebisi', 'Garba'];

        $gender = $faker->randomElement(['male', 'female']);
        $firstName = $gender === 'male' ? $faker->randomElement($nigerianFirstNamesMale) : $faker->randomElement($nigerianFirstNamesFemale);
        $lastName = $faker->randomElement($nigerianLastNames);
        $isBaptized = $faker->boolean(80); // 80% chance of being baptized
        $membershipDate = $faker->dateTimeBetween('-10 years', '-1 year');

        return [
            'member_id' => (string) Str::uuid(),
            'first_name' => $firstName,
            'middle_name' => $faker->boolean(20) ? ($gender === 'male' ? $faker->randomElement($nigerianFirstNamesMale) : $faker->randomElement($nigerianFirstNamesFemale)) : null,
            'last_name' => $lastName,
            'family_name' => $lastName,
            'gender' => $gender,
            'phone' => '080' . $faker->unique()->numerify('########'),
            'email' => strtolower($firstName . '.' . $lastName) . $faker->unique()->numerify('##') . '@example.com',
            'address' => $faker->address,
            'date_of_birth' => $faker->dateTimeBetween('-70 years', '-15 years'),
            'membership_type' => $faker->randomElement(['community', 'student']),
            'membership_category' => $faker->randomElement(['adult', 'youth', 'child', 'university-student']),
            'role_in_church' => $faker->randomElement(['Member', 'Deacon', 'Deaconess', 'Elder', null]),
            'baptism_status' => $isBaptized ? 'baptized' : 'not-baptized',
            'date_of_baptism' => $isBaptized ? $faker->dateTimeBetween($membershipDate, '-6 months') : null,
            'membership_date' => $membershipDate,
            'membership_status' => $faker->randomElement(['active', 'active', 'active', 'inactive', 'transferred']),
            'sabbath_school_class_id' => SabbathSchoolClass::inRandomOrder()->first()?->id,
            'created_by' => User::inRandomOrder()->first()?->id,
            'updated_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
