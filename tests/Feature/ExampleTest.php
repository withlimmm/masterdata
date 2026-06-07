<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $package = \App\Models\Package::create([
            'package_code' => 'TESTPKG',
            'package_name' => 'Test Package',
            'package_max_products' => 10,
            'package_price' => 1000,
        ]);

        $company = \App\Models\Company::create([
            'package_id' => $package->id,
            'company_code' => 'TEST',
            'company_name' => 'Test Company',
            'company_domain' => 'localhost',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);

        \App\Models\CompanyConfig::create([
            'company_id' => $company->id,
            'cfg_site_name' => 'Test Site',
            'cfg_about_us' => 'Test About Us',
            'cfg_phone' => '1234567890',
            'cfg_email' => 'test@example.com',
            'cfg_address' => 'Test Address',
            'cfg_app_logo' => 'test.png',
            'cfg_primary_color' => '#000000',
            'cfg_secondary_color' => '#FFFFFF',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
