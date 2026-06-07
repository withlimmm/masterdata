@extends('layouts.admin')

@section('title', 'SaaS Tenants - Rakira CMS')
@section('page_title', 'SaaS Subscriptions')
@section('page_subtitle', 'Kelola lisensi & status berlangganan client')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-outline-variant/20">
        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Tenant</p>
        <p class="text-3xl font-black text-on-surface mt-1">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-emerald-50 rounded-2xl p-5 shadow-sm border border-emerald-100">
        <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Aktif</p>
        <p class="text-3xl font-black text-emerald-700 mt-1">{{ $stats['active'] }}</p>
    </div>
    <div class="bg-amber-50 rounded-2xl p-5 shadow-sm border border-amber-100">
        <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Hampir Expired</p>
        <p class="text-3xl font-black text-amber-700 mt-1">{{ $stats['expiring'] }}</p>
        <p class="text-[10px] text-amber-500 mt-0.5">dalam 7 hari</p>
    </div>
    <div class="bg-red-50 rounded-2xl p-5 shadow-sm border border-red-100">
        <p class="text-xs font-bold text-red-600 uppercase tracking-wider">Expired</p>
        <p class="text-3xl font-black text-red-700 mt-1">{{ $stats['expired'] }}</p>
    </div>
</div>

{{-- Toolbar --}}
<div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-4 flex flex-col md:flex-row items-start md:items-center gap-3">
    <form method="GET" class="flex flex-1 flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari domain, perusahaan, email..."
               class="flex-1 min-w-[200px] text-sm px-4 py-2.5 border border-outline-variant/40 rounded-xl focus:ring-2 focus:ring-primary/30 outline-none">
        <select name="status" class="text-sm px-4 py-2.5 border border-outline-variant/40 rounded-xl focus:ring-2 focus:ring-primary/30 outline-none bg-white">
            <option value="">Semua Status</option>
            @foreach(['trial','active','suspended','expired'] as $s)
                <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="plan" class="text-sm px-4 py-2.5 border border-outline-variant/40 rounded-xl focus:ring-2 focus:ring-primary/30 outline-none bg-white">
            <option value="">Semua Plan</option>
            @foreach(['basic','professional','enterprise'] as $p)
                <option value="{{ $p }}" @selected(request('plan')===$p)>{{ ucfirst($p) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
            Filter
        </button>
    </form>
    <a href="{{ route('admin.saas-tenants.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors whitespace-nowrap">
        <span class="material-symbols-outlined text-base">add</span>
        Tambah Tenant
    </a>
</div>

{{-- Flash Message --}}
@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium px-5 py-3 rounded-2xl flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        {{ session('success') }}
    </div>
@endif

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-outline-variant/20 bg-surface-container-lowest text-left">
                    <th class="px-5 py-4 text-xs font-black uppercase tracking-wider text-on-surface-variant">Perusahaan / Domain</th>
                    <th class="px-5 py-4 text-xs font-black uppercase tracking-wider text-on-surface-variant">Plan</th>
                    <th class="px-5 py-4 text-xs font-black uppercase tracking-wider text-on-surface-variant">Status</th>
                    <th class="px-5 py-4 text-xs font-black uppercase tracking-wider text-on-surface-variant">Expired</th>
                    <th class="px-5 py-4 text-xs font-black uppercase tracking-wider text-on-surface-variant">Sisa Hari</th>
                    <th class="px-5 py-4 text-xs font-black uppercase tracking-wider text-on-surface-variant">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse ($tenants as $tenant)
                    @php
                        $daysLeft   = $tenant->days_remaining;
                        $daysColor  = $daysLeft <= 0 ? 'text-red-600' : ($daysLeft <= 7 ? 'text-amber-600' : 'text-emerald-600');
                    @endphp
                    <tr class="hover:bg-surface-container-lowest/60 transition-colors group">
                        <td class="px-5 py-4">
                            <p class="font-bold text-on-surface">{{ $tenant->company_name }}</p>
                            <a href="https://{{ $tenant->domain }}" target="_blank"
                               class="text-xs text-primary hover:underline flex items-center gap-1 mt-0.5">
                                <span class="material-symbols-outlined text-xs">open_in_new</span>
                                {{ $tenant->domain }}
                            </a>
                            <p class="text-xs text-on-surface-variant mt-0.5">{{ $tenant->contact_email }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $tenant->plan === 'enterprise' ? 'bg-purple-100 text-purple-700' : ($tenant->plan === 'professional' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                {{ $tenant->plan_label }}
                            </span>
                            @if($tenant->price_yearly)
                                <p class="text-xs text-on-surface-variant mt-1">Rp {{ number_format($tenant->price_yearly, 0, ',', '.') }}/thn</p>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $tenant->status_badge }}">
                                {{ ucfirst($tenant->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-on-surface-variant">
                            {{ $tenant->expires_at ? $tenant->expires_at->format('d M Y') : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-black {{ $daysColor }}">
                                {{ $tenant->expires_at ? $daysLeft . ' hari' : '-' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.saas-tenants.show', $tenant) }}"
                                   class="p-1.5 text-on-surface-variant hover:text-primary transition-colors" title="Detail">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                <a href="{{ route('admin.saas-tenants.edit', $tenant) }}"
                                   class="p-1.5 text-on-surface-variant hover:text-primary transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.saas-tenants.destroy', $tenant) }}"
                                      onsubmit="return confirm('Hapus tenant {{ $tenant->company_name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-on-surface-variant hover:text-red-500 transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-5xl block mb-3 opacity-30">business_center</span>
                            <p class="font-bold">Belum ada tenant terdaftar</p>
                            <p class="text-xs mt-1">Tambahkan client pertama Anda</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tenants->hasPages())
        <div class="px-5 py-4 border-t border-outline-variant/20">{{ $tenants->links() }}</div>
    @endif
</div>

@endsection
