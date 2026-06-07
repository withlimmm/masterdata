@extends('layouts.admin')

@section('title', 'Detail Tenant - ' . $tenant->company_name)
@section('page_title', $tenant->company_name)
@section('page_subtitle', $tenant->domain)

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: Info Cards --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Status Banner --}}
        @php
            $daysLeft = $tenant->days_remaining;
            $banner = match($tenant->status) {
                'active'    => 'bg-emerald-50 border-emerald-200 text-emerald-800',
                'expired'   => 'bg-red-50 border-red-200 text-red-800',
                'suspended' => 'bg-orange-50 border-orange-200 text-orange-800',
                'trial'     => 'bg-blue-50 border-blue-200 text-blue-800',
                default     => 'bg-gray-50 border-gray-200 text-gray-700',
            };
        @endphp
        <div class="rounded-2xl border p-5 flex items-center gap-4 {{ $banner }}">
            <span class="material-symbols-outlined text-3xl">
                {{ $tenant->status === 'active' ? 'verified' : ($tenant->status === 'expired' ? 'cancel' : 'warning') }}
            </span>
            <div>
                <p class="font-black text-lg">Status: {{ ucfirst($tenant->status) }}</p>
                <p class="text-sm">
                    @if($tenant->expires_at)
                        Expired: {{ $tenant->expires_at->format('d M Y') }}
                        @if($daysLeft > 0)
                            &mdash; <strong>{{ $daysLeft }} hari lagi</strong>
                        @else
                            &mdash; <strong>Sudah expired {{ abs($daysLeft) }} hari lalu</strong>
                        @endif
                    @else
                        Belum ada tanggal expired
                    @endif
                </p>
            </div>
        </div>

        {{-- Detail Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-6">
            <h3 class="font-black text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">info</span>
                Informasi Tenant
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Perusahaan</dt>
                    <dd class="mt-1 font-semibold text-on-surface">{{ $tenant->company_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Domain</dt>
                    <dd class="mt-1">
                        <a href="https://{{ $tenant->domain }}" target="_blank"
                           class="text-primary hover:underline font-semibold flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">open_in_new</span>
                            {{ $tenant->domain }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Kontak</dt>
                    <dd class="mt-1 font-semibold text-on-surface">{{ $tenant->contact_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email</dt>
                    <dd class="mt-1 font-semibold text-on-surface">{{ $tenant->contact_email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Telepon</dt>
                    <dd class="mt-1 font-semibold text-on-surface">{{ $tenant->contact_phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Plan</dt>
                    <dd class="mt-1">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $tenant->plan === 'enterprise' ? 'bg-purple-100 text-purple-700' : ($tenant->plan === 'professional' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ $tenant->plan_label }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Harga/Tahun</dt>
                    <dd class="mt-1 font-semibold text-on-surface">
                        {{ $tenant->price_yearly ? 'Rp ' . number_format($tenant->price_yearly, 0, ',', '.') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Berlangganan Sejak</dt>
                    <dd class="mt-1 font-semibold text-on-surface">
                        {{ $tenant->subscribed_at ? $tenant->subscribed_at->format('d M Y') : '-' }}
                    </dd>
                </div>
            </dl>
            @if($tenant->notes)
                <div class="mt-4 pt-4 border-t border-outline-variant/20">
                    <dt class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Catatan</dt>
                    <dd class="text-sm text-on-surface">{{ $tenant->notes }}</dd>
                </div>
            @endif
        </div>
    </div>

    {{-- Right: API Key --}}
    <div class="space-y-5">
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-6">
            <h3 class="font-black text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">key</span>
                API Key
            </h3>
            <p class="text-xs text-on-surface-variant mb-3">
                Key ini digunakan domain client untuk verifikasi status langganan ke endpoint Rakira.
            </p>
            <div class="bg-surface-container-lowest rounded-xl p-3 font-mono text-xs break-all text-on-surface-variant border border-outline-variant/20 mb-3">
                {{ $tenant->api_key ?? 'Belum ada API key' }}
            </div>
            <form method="POST" action="{{ route('admin.saas-tenants.regenerate-key', $tenant) }}"
                  onsubmit="return confirm('Regenerate API key? Domain client harus update key mereka.')">
                @csrf
                <button type="submit" class="w-full py-2.5 bg-amber-50 text-amber-700 border border-amber-200 text-sm font-bold rounded-xl hover:bg-amber-100 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">refresh</span>
                    Regenerate Key
                </button>
            </form>
        </div>

        {{-- API Endpoint Info --}}
        <div class="bg-slate-800 rounded-2xl p-5 text-white">
            <h4 class="font-black text-sm mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-400 text-base">integration_instructions</span>
                Endpoint Cek Status
            </h4>
            <p class="text-xs text-slate-400 mb-2">GET request dari domain client:</p>
            <code class="block bg-slate-900 rounded-lg p-3 text-xs text-green-400 break-all leading-relaxed">
                GET https://rakiradigital.com/api/saas/check<br>
                ?domain={{ $tenant->domain }}<br>
                &amp;key={{ Str::limit($tenant->api_key, 20) }}...
            </code>
            <p class="text-xs text-slate-400 mt-3 mb-2">Response JSON:</p>
            <code class="block bg-slate-900 rounded-lg p-3 text-xs text-yellow-300 leading-relaxed whitespace-pre">{{ json_encode([
                'valid'          => $tenant->status === 'active',
                'status'         => $tenant->status,
                'plan'           => $tenant->plan,
                'expires_at'     => $tenant->expires_at?->toDateString(),
                'days_remaining' => $tenant->days_remaining,
            ], JSON_PRETTY_PRINT) }}</code>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col gap-2">
            <a href="{{ route('admin.saas-tenants.edit', $tenant) }}"
               class="w-full py-3 bg-primary text-white font-bold text-sm rounded-xl hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-base">edit</span> Edit Tenant
            </a>
            <a href="{{ route('admin.saas-tenants.index') }}"
               class="w-full py-3 bg-surface-container-low text-on-surface-variant font-bold text-sm rounded-xl hover:bg-surface-container transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-base">arrow_back</span> Kembali
            </a>
        </div>
    </div>

</div>

@endsection

@php use Illuminate\Support\Str; @endphp
