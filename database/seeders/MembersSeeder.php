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
        // Clear the table first
        // Member::truncate(); // Disabling truncate to avoid foreign key issues, use fresh migration instead.

        // Create 50 members using the factory
        Member::factory()->count(50)->create();
    }
}
