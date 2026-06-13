<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;

class TenantMiddleware
{
    /**
     
Handle an incoming request.*
@param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next*/
public function handle(Request $request, Closure $next): Response{$host = $request->getHost();

        // Hapus 'www.' agar domain dengan atau tanpa www tetap terdeteksi
        if (str_starts_with($host, 'www.')) {
            $host = substr($host, 4);
        }

        // Tentukan daftar Domain Utama (Central Domains)
        $centralDomains = ['localhost', '127.0.0.1', '::1', 'rakiradigital.com'];
        $isCentralDomain = in_array($host, $centralDomains) || str_ends_with($host, '.test');

        // Jika host adalah domain utama, pakai fallback agar web tidak error
        if ($isCentralDomain) {
            $company = Company::where('company_domain', $host)->first() ?? Company::first();
        } else {
            // Jika host adalah domain klien, cari spesifik
            $company = Company::where('company_domain', $host)->first();
        }

        if ($company) {
            app()->instance('tenant', $company);
        } else {
            // KUNCI PERBAIKAN: Hanya lempar 404 JIKA ini BUKAN domain utama
            if (!$isCentralDomain && !app()->environment('local', 'testing')) {
                abort(404, 'Tenant not found for this domain.');
            }
        }

        return $next($request);
    }
}