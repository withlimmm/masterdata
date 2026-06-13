<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class TenantProvisioningService
{
    /**
     * Provision the tenant in the respective microservice database.
     * 
     * @param Company $company
     * @param User $adminUser
     * @param string $rawPassword The unhashed password to be passed to the microservice if needed.
     * @return bool
     */
    public static function provision(Company $company, User $adminUser, string $rawPassword)
    {
        // Get the system code from the subscribed package
        $systemCode = $company->package->system->system_code ?? null;

        if (!$systemCode) {
            Log::warning("Tenant provisioning skipped: No system code found for company {$company->company_code}");
            return false;
        }

        try {
            switch ($systemCode) {
                case 'SYS-POS':
                    self::syncToDatabase('mysql_pos', $company, $adminUser, $rawPassword);
                    break;
                case 'SYS-WMS':
                    self::syncToDatabase('mysql_wms', $company, $adminUser, $rawPassword);
                    break;
                default:
                    Log::info("Tenant provisioning: System {$systemCode} does not require external DB sync.");
                    break;
            }

            return true;
        } catch (\Exception $e) {
            // Log the error but do not throw to prevent breaking the Central App flow.
            // In a production environment, this could be dispatched to a queued job with retries.
            Log::error("Failed to provision tenant {$company->company_code} to {$systemCode}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Sync tenant data to a specific microservice database.
     */
    private static function syncToDatabase(string $connectionName, Company $company, User $adminUser, string $rawPassword)
    {
        Log::info("Starting sync for {$company->company_code} to connection {$connectionName}");

        $db = DB::connection($connectionName);

        // Optional: Check if connection is working
        $db->getPdo();

        $db->beginTransaction();
        try {
            // 1. Insert/Update Vendor (Tenant) record in the microservice
            // We assume the microservice has a `vendors` or `tenants` table
            // For flexibility, let's just insert into a hypothetical `tenants` table
            // In a real scenario, the microservice schema dictates this.
            
            // Note: If the microservice schema is not ready, this will fail and be caught by the Try-Catch.
            $tenantExists = $db->table('tenants')->where('vendor_id', $company->vendor_id)->exists();
            
            if (!$tenantExists) {
                $db->table('tenants')->insert([
                    'vendor_id' => $company->vendor_id,
                    'name' => $company->company_name,
                    'domain' => $company->company_domain,
                    'status' => $company->subscription_status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 2. Insert the Admin User
            // The microservice will use vendor_id to isolate data
            $userExists = $db->table('users')->where('email', $adminUser->email)->exists();
            
            if (!$userExists) {
                $db->table('users')->insert([
                    'vendor_id' => $company->vendor_id, // Linking user to the vendor
                    'name' => $adminUser->name,
                    'email' => $adminUser->email,
                    'password' => Hash::make($rawPassword), // Hash again or pass the hashed one
                    'role' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $db->commit();
            Log::info("Successfully synced {$company->company_code} to {$connectionName}");
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
