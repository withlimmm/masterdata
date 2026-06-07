<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SaaSCheckController extends Controller
{
    public function check(Request $request)
    {
        $domain = $request->query('domain');
        $key = $request->query('key');

        if (!$domain || !$key) {
            return response()->json([
                'valid' => false,
                'message' => 'Parameter domain dan key wajib diisi.'
            ], 400);
        }

        $company = Company::with('package')->where('company_domain', $domain)
            ->where('api_key', $key)
            ->first();

        if (!$company) {
            return response()->json([
                'valid' => false,
                'message' => 'Domain atau API Key tidak valid.'
            ], 404);
        }

        // Auto expire if needed
        $expiredAt = Carbon::parse($company->subscription_expired_at);
        if ($expiredAt->isPast() && $company->subscription_status === 'active') {
            $company->update(['subscription_status' => 'expired']);
        }

        return response()->json([
            'valid' => $company->subscription_status === 'active',
            'status' => $company->subscription_status,
            'package' => $company->package->package_name ?? 'Unknown',
            'company_name' => $company->company_name,
            'expired_at' => $expiredAt->toDateString(),
        ]);
    }
}
