<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyConfig;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_package_and_company_creation_with_uuid()
    {
        // 1. Test Package creation
        $package = Package::create([
            'package_code' => 'PKG-TEST',
            'package_name' => 'Test Package',
            'package_max_products' => 10,
            'package_price' => 50000.00,
        ]);

        $this->assertNotNull($package->id);
        $this->assertTrue(is_string($package->id)); // Memastikan UUID (string)
        $this->assertEquals(36, strlen($package->id));

        // 2. Test Company creation
        $company = Company::create([
            'package_id' => $package->id,
            'company_code' => 'CP-TEST',
            'company_name' => 'Test Company',
            'company_domain' => 'test.com',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);

        $this->assertNotNull($company->id);
        $this->assertEquals($package->id, $company->package_id);
    }

    public function test_foreign_key_company_id_invalid()
    {
        $this->expectException(QueryException::class);

        // Seharusnya gagal karena company_id asal-asalan (tidak ada di tabel mst_companies)
        CompanyConfig::create([
            'company_id' => '123e4567-e89b-12d3-a456-426614174000',
            'cfg_app_logo' => 'logo.png',
            'cfg_primary_color' => '#000000',
            'cfg_secondary_color' => '#ffffff',
        ]);
    }

    public function test_unique_company_code_and_domain()
    {
        $package = Package::create([
            'package_code' => 'PKG-TEST',
            'package_name' => 'Test Package',
            'package_max_products' => 10,
            'package_price' => 50000.00,
        ]);

        Company::create([
            'package_id' => $package->id,
            'company_code' => 'CP-TEST',
            'company_name' => 'Test Company 1',
            'company_domain' => 'test1.com',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);

        $this->expectException(QueryException::class);
        
        // Seharusnya gagal karena company_code 'CP-TEST' sudah ada
        Company::create([
            'package_id' => $package->id,
            'company_code' => 'CP-TEST', // Duplikat
            'company_name' => 'Test Company 2',
            'company_domain' => 'test2.com',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);
    }

    public function test_soft_deletes()
    {
        $package = Package::create([
            'package_code' => 'PKG-TEST',
            'package_name' => 'Test Package',
            'package_max_products' => 10,
            'package_price' => 50000.00,
        ]);

        $company = Company::create([
            'package_id' => $package->id,
            'company_code' => 'CP-TEST',
            'company_name' => 'Test Company',
            'company_domain' => 'test.com',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);

        // Uji Soft Delete Company
        $company->delete();
        $this->assertNull(Company::find($company->id)); // Gagal dicari pakai find() biasa
        $this->assertNotNull(Company::withTrashed()->find($company->id)); // Berhasil dicari dengan withTrashed()
        
        // Restore Company
        $company->restore();
        $this->assertNotNull(Company::find($company->id)); // Berhasil dicari lagi
    }

    public function test_relationships_company_to_config_and_package_to_company()
    {
        $package = Package::create([
            'package_code' => 'PKG-TEST',
            'package_name' => 'Test Package',
            'package_max_products' => 10,
            'package_price' => 50000.00,
        ]);

        $company = Company::create([
            'package_id' => $package->id,
            'company_code' => 'CP-TEST',
            'company_name' => 'Test Company',
            'company_domain' => 'test.com',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);

        $config = CompanyConfig::create([
            'company_id' => $company->id,
            'cfg_app_logo' => 'logo.png',
            'cfg_primary_color' => '#000000',
            'cfg_secondary_color' => '#ffffff',
        ]);

        // Uji Relasi: package -> companies
        $this->assertEquals($company->id, $package->companies->first()->id);
        
        // Uji Relasi: company -> config
        $this->assertEquals($config->id, $company->config->id);
    }

    public function test_cascade_delete_on_company_config()
    {
        $package = Package::create([
            'package_code' => 'PKG-TEST',
            'package_name' => 'Test Package',
            'package_max_products' => 10,
            'package_price' => 50000.00,
        ]);

        $company = Company::create([
            'package_id' => $package->id,
            'company_code' => 'CP-TEST',
            'company_name' => 'Test Company',
            'company_domain' => 'test.com',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);

        $config = CompanyConfig::create([
            'company_id' => $company->id,
            'cfg_app_logo' => 'logo.png',
            'cfg_primary_color' => '#000000',
            'cfg_secondary_color' => '#ffffff',
        ]);

        $companyId = $company->id;
        
        // Hapus permanen company untuk melihat efek cascade
        $company->forceDelete();

        // Config harusnya ikut terhapus
        $this->assertNull(CompanyConfig::where('company_id', $companyId)->first());
    }

    public function test_restrict_delete_on_package()
    {
        $package = Package::create([
            'package_code' => 'PKG-TEST',
            'package_name' => 'Test Package',
            'package_max_products' => 10,
            'package_price' => 50000.00,
        ]);

        $company = Company::create([
            'package_id' => $package->id,
            'company_code' => 'CP-TEST',
            'company_name' => 'Test Company',
            'company_domain' => 'test.com',
            'subscription_status' => 'active',
            'subscription_start_at' => now(),
            'subscription_expired_at' => now()->addYear(),
        ]);

        $this->expectException(QueryException::class);

        // Seharusnya gagal dihapus permanen karena ada Company yang sedang terhubung (RESTRICT)
        $package->forceDelete();
    }
}
