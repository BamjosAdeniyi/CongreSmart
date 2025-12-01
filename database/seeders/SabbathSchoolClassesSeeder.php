<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SabbathSchoolClass;
use Illuminate\Support\Str;

class SabbathSchoolClassesSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['name'=>'Adult Class','description'=>'Adult Sabbath School class','age_range'=>'18+'],
            ['name'=>'Youth Class','description'=>'Youth (13-17)','age_range'=>'13-17'],
            ['name'=>'Children Class','description'=>'Children (0-12)','age_range'=>'0-12'],
        ];

        foreach ($classes as $c) {
            SabbathSchoolClass::create([
                'id' => (string) Str::uuid(),
                'name' => $c['name'],
                'description' => $c['description'],
                'age_range' => $c['age_range'],
                'active' => true,
            ]);
        }
    }
}
