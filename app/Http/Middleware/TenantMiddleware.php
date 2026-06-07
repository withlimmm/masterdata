<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // Fix: Hapus 'www.' agar domain dengan atau tanpa www tetap terdeteksi
        if (str_starts_with($host, 'www.')) {
            $host = substr($host, 4);
        }

        // Jika host adalah local/testing, pakai fallback agar web tidak error
        if (in_array($host, ['localhost', '127.0.0.1', '::1']) || str_ends_with($host, '.test')) {
            $company = Company::where('company_domain', $host)->first() ?? Company::first();
        } else {
            $company = Company::where('company_domain', $host)->first();
        }

        if ($company) {
            app()->instance('tenant', $company);
        } else {
            // Jika di-deploy ke production dan domain tidak terdaftar, bisa lempar 404
            if (!app()->environment('local', 'testing')) {
                abort(404, 'Tenant not found for this domain.');
            }
        }

        return $next($request);
    }
}
