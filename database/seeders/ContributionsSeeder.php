<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contribution;
use App\Models\Member;
use App\Models\FinancialCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ContributionsSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::all();
        $categories = FinancialCategory::all();
        $users = \App\Models\User::all();

        if ($categories->isEmpty()) return;

        foreach ($members as $member) {
            // Each member makes 1-5 contributions
            $numContributions = rand(1, 5);
            for ($j = 0; $j < $numContributions; $j++) {
                Contribution::create([
                    'id' => (string) Str::uuid(),
                    'member_id' => $member->member_id,
                    'category_id' => $categories->random()->id,
                    'amount' => rand(5, 50) * 100, // 500 to 5000
                    'date' => Carbon::now()->subDays(rand(0, 90))->toDateString(),
                    'payment_method' => rand(0, 1) ? 'cash' : 'transfer',
                    'reference_number' => 'REF' . strtoupper(substr((string) Str::uuid(), 0, 8)),
                    'notes' => null,
                    'recorded_by' => $users->random()->id,
                ]);
            }
        }
    }
}
