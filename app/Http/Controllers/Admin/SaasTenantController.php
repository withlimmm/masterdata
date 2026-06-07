<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaasTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaasTenantController extends Controller
{
    public function index(Request $request)
    {
        $query = SaasTenant::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('company_name', 'like', "%$s%")
                  ->orWhere('domain', 'like', "%$s%")
                  ->orWhere('contact_email', 'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        $tenants = $query->orderByRaw("FIELD(status,'trial','active','suspended','expired')")
                         ->orderBy('expires_at')
                         ->paginate(20)
                         ->withQueryString();

        $stats = [
            'total'    => SaasTenant::count(),
            'active'   => SaasTenant::where('status', 'active')->count(),
            'expiring' => SaasTenant::expiringSoon(7)->count(),
            'expired'  => SaasTenant::where('status', 'expired')->count(),
        ];

        return view('admin.saas.index', compact('tenants', 'stats'));
    }

    public function create()
    {
        return view('admin.saas.form', ['tenant' => new SaasTenant()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'  => 'required|string|max:200',
            'domain'        => 'required|string|max:200|unique:saas_tenants,domain',
            'contact_name'  => 'required|string|max:150',
            'contact_email' => 'required|email|max:150',
            'contact_phone' => 'nullable|string|max:30',
            'plan'          => 'required|in:basic,professional,enterprise',
            'price_yearly'  => 'nullable|numeric|min:0',
            'subscribed_at' => 'nullable|date',
            'expires_at'    => 'nullable|date|after_or_equal:subscribed_at',
            'status'        => 'required|in:active,expired,suspended,trial',
            'notes'         => 'nullable|string|max:2000',
        ]);

        SaasTenant::create($validated);

        return redirect()->route('admin.saas-tenants.index')
                         ->with('success', 'Tenant berhasil ditambahkan!');
    }

    public function show(SaasTenant $saasTenant)
    {
        return view('admin.saas.show', ['tenant' => $saasTenant]);
    }

    public function edit(SaasTenant $saasTenant)
    {
        return view('admin.saas.form', ['tenant' => $saasTenant]);
    }

    public function update(Request $request, SaasTenant $saasTenant)
    {
        $validated = $request->validate([
            'company_name'  => 'required|string|max:200',
            'domain'        => 'required|string|max:200|unique:saas_tenants,domain,' . $saasTenant->id,
            'contact_name'  => 'required|string|max:150',
            'contact_email' => 'required|email|max:150',
            'contact_phone' => 'nullable|string|max:30',
            'plan'          => 'required|in:basic,professional,enterprise',
            'price_yearly'  => 'nullable|numeric|min:0',
            'subscribed_at' => 'nullable|date',
            'expires_at'    => 'nullable|date',
            'status'        => 'required|in:active,expired,suspended,trial',
            'notes'         => 'nullable|string|max:2000',
        ]);

        $saasTenant->update($validated);

        return redirect()->route('admin.saas-tenants.index')
                         ->with('success', 'Data tenant berhasil diperbarui!');
    }

    public function destroy(SaasTenant $saasTenant)
    {
        $saasTenant->delete();
        return redirect()->route('admin.saas-tenants.index')
                         ->with('success', 'Tenant berhasil dihapus.');
    }

    /** Regenerate API key */
    public function regenerateKey(SaasTenant $saasTenant)
    {
        $saasTenant->update([
            'api_key' => Str::random(32) . bin2hex(random_bytes(16))
        ]);
        return back()->with('success', 'API Key berhasil di-regenerate!');
    }

    // ─── PUBLIC API: dipanggil dari domain client ─────────────────
    // GET /api/saas/check?domain=akagroupconsulting.com&key=xxx
    public function checkStatus(Request $request)
    {
        $tenant = SaasTenant::where('domain', $request->domain)
                            ->where('api_key', $request->key)
                            ->first();

        if (!$tenant) {
            return response()->json(['valid' => false, 'message' => 'Tenant not found'], 404);
        }

        // Auto-mark expired
        if ($tenant->expires_at && $tenant->expires_at->isPast() && $tenant->status === 'active') {
            $tenant->update(['status' => 'expired']);
        }

        return response()->json([
            'valid'          => $tenant->status === 'active',
            'status'         => $tenant->status,
            'plan'           => $tenant->plan,
            'company'        => $tenant->company_name,
            'expires_at'     => $tenant->expires_at?->toDateString(),
            'days_remaining' => $tenant->days_remaining,
        ]);
    }
}
