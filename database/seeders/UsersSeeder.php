<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name'=>'ICT Administrator','email'=>'ict@example.com','role'=>'ict'],
            ['name'=>'Church Clerk','email'=>'clerk@example.com','role'=>'clerk'],
            ['name'=>'Sabbath Superintendent','email'=>'superintendent@example.com','role'=>'superintendent'],
            ['name'=>'Financial Secretary','email'=>'financial@example.com','role'=>'financial'],
            ['name'=>'Coordinator One','email'=>'coordinator1@example.com','role'=>'coordinator'],
            ['name'=>'Pastor','email'=>'pastor@example.com','role'=>'pastor'],
            ['name'=>'Welfare Lead','email'=>'welfare@example.com','role'=>'welfare'],
        ];

        foreach ($users as $u) {
            User::create([
                'id' => (string) Str::uuid(),
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make('Password123!'), // change in production
                'role' => $u['role'],
                'active' => true,
            ]);
        }
    }
}
