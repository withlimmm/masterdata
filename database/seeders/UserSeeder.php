<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $rakira = \App\Models\Company::where('company_code', 'RAKIRA')->first();

        // Buat Super Admin
        User::updateOrCreate(
            ['email' => 'admin@rakiradigital.com'],
            [
                'name' => 'Super Admin Rakira',
                'password' => Hash::make('password123'),
                'role' => 'super_admin', // Sesuai migration
                'company_id' => $rakira?->id,
            ]
        );

        // Buat Editor
        User::updateOrCreate(
            ['email' => 'editor@rakiradigital.com'],
            [
                'name' => 'Editor Rakira',
                'password' => Hash::make('password123'),
                'role' => 'editor',
                'company_id' => $rakira?->id,
            ]
        );
    }
}
