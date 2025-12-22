<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialCategory;
use Illuminate\Support\Str;

class FinancialCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name'=>'Tithe','category_type'=>'income','description'=>'Regular tithe giving'],
            ['name'=>'Offering','category_type'=>'income','description'=>'General offering'],
            ['name'=>'Welfare','category_type'=>'income','description'=>'Welfare support fund'],
            ['name'=>'Building Fund','category_type'=>'income','description'=>'Building / maintenance'],
            ['name'=>'Missions','category_type'=>'income','description'=>'Mission support'],
            ['name'=>'Special','category_type'=>'income','description'=>'Special collections'],
            ['name'=>'Utilities','category_type'=>'expense','description'=>'Electricity, water, etc.'],
            ['name'=>'Maintenance','category_type'=>'expense','description'=>'Building maintenance'],
            ['name'=>'Office Supplies','category_type'=>'expense','description'=>'Office and administrative supplies'],
            ['name'=>'Mission Expenses','category_type'=>'expense','description'=>'Mission trip expenses'],
        ];

        foreach ($categories as $c) {
            FinancialCategory::create([
                'id' => (string) Str::uuid(),
                'name' => $c['name'],
                'description' => $c['description'],
                'category_type' => $c['category_type'],
                'active' => true,
            ]);
        }
    }
}
