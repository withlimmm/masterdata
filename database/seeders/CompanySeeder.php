<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyConfig;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $basicPackage = Package::where('package_code', 'PKG-BASIC')->first();
        $proPackage = Package::where('package_code', 'PKG-PRO')->first();

        // Company 1: Rakira Digital
        $rakira = Company::create([
            'package_id' => $proPackage->id,
            'company_code' => 'RAKIRA',
            'company_name' => 'Rakira Digital',
            'company_domain' => 'rakiradigital.test',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYears(10),
        ]);

        CompanyConfig::create([
            'company_id' => $rakira->id,
            'cfg_site_name' => 'Rakira Digital SaaS',
            'cfg_about_us' => 'We provide the best SaaS solutions.',
            'cfg_phone' => '6281234567890',
            'cfg_email' => 'hello@rakiradigital.com',
            'cfg_address' => 'Jakarta, Indonesia',
            'cfg_primary_color' => '#1A73E8',
            'cfg_secondary_color' => '#FFFFFF',
            'cfg_app_logo' => 'logos/default.png',
        ]);

        // Admin user for Rakira will be created by UserSeeder

        // Company 2: Client A (Subdomain example)
        $clientA = Company::create([
            'package_id' => $basicPackage->id,
            'company_code' => 'CLIENTA',
            'company_name' => 'Client A Corp',
            'company_domain' => 'clienta.rakiradigital.test',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addMonth(),
        ]);

        CompanyConfig::create([
            'company_id' => $clientA->id,
            'cfg_site_name' => 'Client A POS',
            'cfg_about_us' => 'Client A POS System',
            'cfg_phone' => '62899999999',
            'cfg_email' => 'admin@clienta.com',
            'cfg_address' => 'Surabaya, Indonesia',
            'cfg_primary_color' => '#E81A1A',
            'cfg_secondary_color' => '#000000',
            'cfg_app_logo' => 'logos/clienta.png',
        ]);

        // Create an admin user for Client A
        User::factory()->create([
            'name' => 'Client A Admin',
            'email' => 'admin@clienta.com',
            'password' => bcrypt('password'),
            'company_id' => $clientA->id,
            'role' => 'admin',
        ]);
    }
}
