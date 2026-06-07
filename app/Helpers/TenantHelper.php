<?php

if (!function_exists('tenant_path')) {
    /**
     * Generate a tenant-specific storage path.
     * If accessed within a tenant context, it prefixes the path with the tenant's UUID.
     * Otherwise, it returns the original path.
     *
     * @param string $path
     * @return string
     */
    function tenant_path($path)
    {
        if (app()->bound('tenant')) {
            $tenant = app('tenant');
            return 'tenants/' . $tenant->id . '/' . ltrim($path, '/');
        }

        return $path;
    }
}
