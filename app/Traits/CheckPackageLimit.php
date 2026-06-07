<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait CheckPackageLimit
{
    /**
     * Check if the tenant has exceeded their package limit for a given model.
     *
     * @param string $modelClass The fully qualified class name of the model.
     * @return bool True if limit exceeded, false otherwise.
     */
    protected function hasExceededPackageLimit(string $modelClass): bool
    {
        if (!app()->bound('tenant')) {
            return false; // Not in tenant context, no limits
        }

        $tenant = app('tenant');
        $package = $tenant->package;

        if (!$package) {
            return true; // If somehow there's no package, block creation
        }

        // Limit configuration
        $maxItems = $package->package_max_products;

        // Since BelongsToCompany is active, we just count the current items
        $currentCount = $modelClass::count();

        if ($currentCount >= $maxItems) {
            Log::warning("Tenant {$tenant->company_code} exceeded package limit for {$modelClass}. Current: {$currentCount}, Max: {$maxItems}");
            return true;
        }

        return false;
    }

    /**
     * Helper to abort if limit is exceeded.
     *
     * @param string $modelClass
     */
    protected function enforcePackageLimit(string $modelClass)
    {
        if ($this->hasExceededPackageLimit($modelClass)) {
            abort(403, 'Kuota Paket Berlangganan Anda (' . app('tenant')->package->package_name . ') sudah mencapai batas maksimal. Silakan upgrade paket langganan Anda untuk menambah data baru.');
        }
    }
}
