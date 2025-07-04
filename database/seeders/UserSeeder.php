<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => true,
        ]);

        User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'status' => true,
        ]);

        User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => true,
        ]);

        User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Staff Baru',
            'email' => 'staffbaru@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => true,
        ]);

        User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Staff Muda',
            'email' => 'staffmuda@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => true,
        ]);

        User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Staff Lama',
            'email' => 'stafflama@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'status' => false,
        ]);
    }
}

