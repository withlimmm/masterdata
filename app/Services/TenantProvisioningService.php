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
            // 1. Insert/Update Client (Tenant) record in the POS microservice
            $clientExists = $db->table('ms_clients')->where('client_domain', $company->company_domain)->first();
            $clientId = $clientExists ? $clientExists->client_id : \Illuminate\Support\Str::uuid()->toString();

            if (!$clientExists) {
                $db->table('ms_clients')->insert([
                    'client_id' => $clientId,
                    'client_name' => $company->company_name,
                    'client_domain' => $company->company_domain,
                    'client_status' => $company->subscription_status === 'active' ? 'active' : 'inactive',
                    'client_email' => $company->company_email ?? $adminUser->email,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 2. Insert the Default Outlet
            $outletId = \Illuminate\Support\Str::uuid()->toString();
            $db->table('ms_outlets')->insert([
                'outlet_id' => $outletId,
                'outlet_client_id' => $clientId,
                'outlet_code' => 'OUT-DEFAULT',
                'outlet_name' => 'Cabang Utama ' . $company->company_name,
                'outlet_address' => 'Alamat Cabang Utama',
                'outlet_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Insert the Admin User
            $userExists = $db->table('ms_users')->where('user_email', $adminUser->email)->exists();
            
            if (!$userExists) {
                $db->table('ms_users')->insert([
                    'user_id' => \Illuminate\Support\Str::uuid()->toString(),
                    'user_client_id' => $clientId,
                    'user_outlet_id' => $outletId, // Linking to default outlet
                    'user_code' => 'ADM-SAAS',
                    'user_name' => $adminUser->name,
                    'user_email' => $adminUser->email,
                    'user_password' => Hash::make($rawPassword),
                    'user_pin' => '1234', // Default PIN
                    'user_status' => 'active',
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
