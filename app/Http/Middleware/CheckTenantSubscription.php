<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckTenantSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user tidak login atau merupakan superadmin (company_id null), abaikan
        if (!$user || !$user->company_id) {
            return $next($request);
        }

        $company = $user->company;

        if (!$company) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Data perusahaan tidak ditemukan.');
        }

        // Cek apakah status expired atau tanggal sudah lewat
        if ($company->subscription_status === 'expired' || now()->greaterThanOrEqualTo($company->subscription_expired_at)) {
            // Update status ke expired jika belum
            if ($company->subscription_status !== 'expired') {
                $company->update(['subscription_status' => 'expired']);
            }
            
            Auth::logout();
            return redirect()->route('login')->with('error', 'Masa berlangganan perusahaan Anda telah habis. Silakan hubungi Super Admin.');
        }

        if ($company->subscription_status === 'suspended') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun perusahaan Anda ditangguhkan (Suspended).');
        }

        // Set context tenant untuk global scope berdasarkan user yang login
        app()->instance('tenant', $company);

        return $next($request);
    }
}
