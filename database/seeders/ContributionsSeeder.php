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
        $members = Member::take(6)->pluck('member_id')->toArray();
        $categories = FinancialCategory::pluck('id')->toArray();
        $now = Carbon::now();

        foreach ($members as $i => $mId) {
            Contribution::create([
                'id' => (string) Str::uuid(),
                'member_id' => $mId,
                'category_id' => $categories[$i % count($categories)],
                'amount' => 1000 + ($i * 250),
                'date' => $now->copy()->subDays($i * 7)->toDateString(),
                'payment_method' => 'cash',
                'reference_number' => 'REF' . strtoupper(substr((string) Str::uuid(), 0, 8)),
                'notes' => null,
                'recorded_by' => null,
            ]);
        }
    }
}
