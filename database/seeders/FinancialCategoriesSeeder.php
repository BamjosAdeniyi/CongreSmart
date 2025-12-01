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
            ['name'=>'Tithe','category_type'=>'regular','description'=>'Regular tithe giving'],
            ['name'=>'Offering','category_type'=>'regular','description'=>'General offering'],
            ['name'=>'Welfare','category_type'=>'project','description'=>'Welfare support fund'],
            ['name'=>'Building Fund','category_type'=>'project','description'=>'Building / maintenance'],
            ['name'=>'Missions','category_type'=>'project','description'=>'Mission support'],
            ['name'=>'Special','category_type'=>'special','description'=>'Special collections'],
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
