<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Super Admin
        User::updateOrCreate(
            ['email' => 'admin@rakiradigital.com'],
            [
                'name' => 'Super Admin Rakira',
                'password' => Hash::make('password123'),
                'role' => 'super_admin', // Sesuai migration
            ]
        );

        // Buat Editor
        User::updateOrCreate(
            ['email' => 'editor@rakiradigital.com'],
            [
                'name' => 'Editor Rakira',
                'password' => Hash::make('password123'),
                'role' => 'editor',
            ]
        );
    }
}
