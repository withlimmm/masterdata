<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyConfig;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('package')->latest()->get();
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $packages = Package::all();
        return view('admin.companies.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:mst_packages,id',
            'company_code' => 'required|string|max:10|unique:mst_companies,company_code',
            'company_name' => 'required|string|max:100',
            'company_domain' => 'required|string|max:100|unique:mst_companies,company_domain',
            'subscription_status' => ['required', Rule::in(['active', 'suspended', 'expired'])],
            'subscription_months' => 'required|integer|min:1',
            
            // Admin User Data
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create Company
            $company = Company::create([
                'package_id' => $validated['package_id'],
                'company_code' => strtoupper($validated['company_code']),
                'company_name' => $validated['company_name'],
                'company_domain' => strtolower($validated['company_domain']),
                'subscription_status' => $validated['subscription_status'],
                'subscription_start_at' => now(),
                'subscription_expired_at' => now()->addMonths((int) $validated['subscription_months']),
            ]);

            // 2. Create Company Config
            CompanyConfig::create([
                'company_id' => $company->id,
                'cfg_site_name' => $company->company_name,
                'cfg_app_logo' => 'logos/default.png',
                'cfg_primary_color' => '#1A73E8',
                'cfg_secondary_color' => '#FFFFFF',
            ]);

            // 3. Create Admin User
            User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['admin_password']),
                'role' => 'admin',
                'company_id' => $company->id,
            ]);

            DB::commit();

            return redirect()->route('admin.companies.index')->with('success', 'Perusahaan/Tenant berhasil didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Company $company)
    {
        $packages = Package::all();
        return view('admin.companies.edit', compact('company', 'packages'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:mst_packages,id',
            'company_code' => 'required|string|max:10|unique:mst_companies,company_code,' . $company->id,
            'company_name' => 'required|string|max:100',
            'company_domain' => 'required|string|max:100|unique:mst_companies,company_domain,' . $company->id,
            'subscription_status' => ['required', Rule::in(['active', 'suspended', 'expired'])],
            'subscription_expired_at' => 'required|date',
        ]);

        $company->update([
            'package_id' => $validated['package_id'],
            'company_code' => strtoupper($validated['company_code']),
            'company_name' => $validated['company_name'],
            'company_domain' => strtolower($validated['company_domain']),
            'subscription_status' => $validated['subscription_status'],
            'subscription_expired_at' => $validated['subscription_expired_at'],
        ]);

        return redirect()->route('admin.companies.index')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Perusahaan berhasil dihapus (Soft Delete).');
    }

    public function regenerateApiKey(Company $company)
    {
        $company->generateApiKey();
        return back()->with('success', 'API Key berhasil di-regenerate!');
    }
}
