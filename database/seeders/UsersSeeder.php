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
            ['first_name'=>'Joseph', 'last_name'=>'John','email'=>'ict@church.com','role'=>'ict','password'=>'ict123'],
            ['first_name'=>'Judith', 'last_name'=>'Abel','email'=>'clerk@church.com','role'=>'clerk','password'=>'clerk123'],
            ['first_name'=>'Sabbath', 'last_name'=>'Superintendent','email'=>'superintendent@church.com','role'=>'superintendent','password'=>'super123'],
            ['first_name'=>'Samuel', 'last_name'=>'Adeyi','email'=>'financial@church.com','role'=>'financial','password'=>'finance123'],
            ['first_name'=>'Felix', 'last_name'=>'Okon','email'=>'coordinator1@church.com','role'=>'coordinator', 'password'=>'coord123'],
            ['first_name'=>'Chima', 'last_name'=>'Onyekachi','email'=>'coordinator2@church.com','role'=>'coordinator', 'password'=>'coord123'],
            ['first_name'=>'Oluwatosin', 'last_name'=>'Ajayi','email'=>'coordinator3@church.com','role'=>'coordinator', 'password'=>'coord123'],
            ['first_name'=>'John', 'last_name'=>'Adelabu','email'=>'pastor@church.com','role'=>'pastor', 'password'=>'pastor123'],
            ['first_name'=>'Shade', 'last_name'=>'Sarah','email'=>'welfare@church.com','role'=>'welfare', 'password'=>'welfare123'],
        ];

        foreach ($users as $u) {
            User::create([
                'id' => (string) Str::uuid(),
                'first_name' => $u['first_name'],
                'last_name' => $u['last_name'],
                'email' => $u['email'],
                'password' => Hash::make($u['password']), // change in production
                'role' => $u['role'],
                'active' => true,
            ]);
        }
    }
}
