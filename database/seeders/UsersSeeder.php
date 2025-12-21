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
            ['name'=>'ICT Administrator','email'=>'ict@church.com','role'=>'ict','password'=>'ict123'],
            ['name'=>'Church Clerk','email'=>'clerk@church.com','role'=>'clerk','password'=>'clerk123'],
            ['name'=>'Sabbath Superintendent','email'=>'superintendent@church.com','role'=>'superintendent','password'=>'super123'],
            ['name'=>'Financial Secretary','email'=>'financial@church.com','role'=>'financial','password'=>'finance123'],
            ['name'=>'Coordinator One','email'=>'coordinator1@church.com','role'=>'coordinator', 'password'=>'coord123'],
            ['name'=>'Pastor','email'=>'pastor@church.com','role'=>'pastor', 'password'=>'pastor123'],
            ['name'=>'Welfare Lead','email'=>'welfare@church.com','role'=>'welfare', 'password'=>'welfare123'],
        ];

        foreach ($users as $u) {
            User::create([
                'id' => (string) Str::uuid(),
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make($u['password']), // change in production
                'role' => $u['role'],
                'active' => true,
            ]);
        }
    }
}
