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
        $gender = $this->faker->randomElement(['male', 'female']);
        $firstName = $this->faker->firstName($gender);
        $lastName = $this->faker->lastName;
        $isBaptized = $this->faker->boolean(80); // 80% chance of being baptized
        $membershipDate = $this->faker->dateTimeBetween('-10 years', '-1 year');

        return [
            'member_id' => (string) Str::uuid(),
            'first_name' => $firstName,
            'middle_name' => $this->faker->boolean(20) ? $this->faker->firstName($gender) : null,
            'last_name' => $lastName,
            'family_name' => $lastName,
            'gender' => $gender,
            'phone' => $this->faker->unique()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'date_of_birth' => $this->faker->dateTimeBetween('-70 years', '-15 years'),
            'membership_type' => $this->faker->randomElement(['community', 'student']),
            'membership_category' => $this->faker->randomElement(['adult', 'youth', 'child', 'university-student']),
            'role_in_church' => $this->faker->randomElement(['Member', 'Deacon', 'Deaconess', 'Elder', null]),
            'baptism_status' => $isBaptized ? 'baptized' : 'not-baptized',
            'date_of_baptism' => $isBaptized ? $this->faker->dateTimeBetween($membershipDate, '-6 months') : null,
            'membership_date' => $membershipDate,
            'membership_status' => $this->faker->randomElement(['active', 'active', 'active', 'inactive', 'transferred']),
            'sabbath_school_class_id' => SabbathSchoolClass::inRandomOrder()->first()?->id,
            'created_by' => User::inRandomOrder()->first()?->id,
            'updated_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
