<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesPermissionsSeeder::class,
            UsersSeeder::class,
            FinancialCategoriesSeeder::class,
            SabbathSchoolClassesSeeder::class,
            MembersSeeder::class,
            ContributionsSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
