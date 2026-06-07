@extends('layouts.admin')

@section('title', ($tenant->id ? 'Edit' : 'Tambah') . ' Tenant - Rakira CMS')
@section('page_title', $tenant->id ? 'Edit Tenant' : 'Tambah Tenant Baru')
@section('page_subtitle', 'Kelola data langganan SaaS client')

@section('content')

<form method="POST"
      action="{{ $tenant->id ? route('admin.saas-tenants.update', $tenant) : route('admin.saas-tenants.store') }}"
      class="space-y-6 max-w-3xl">
    @csrf
    @if($tenant->id) @method('PUT') @endif

    {{-- Identitas --}}
    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-6 space-y-4">
        <h3 class="font-black text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">business</span>
            Identitas Perusahaan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Nama Perusahaan *</label>
                <input type="text" name="company_name" value="{{ old('company_name', $tenant->company_name) }}"
                       required class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none"
                       placeholder="AKA Group Consulting">
                @error('company_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Domain *</label>
                <input type="text" name="domain" value="{{ old('domain', $tenant->domain) }}"
                       required class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none"
                       placeholder="akagroupconsulting.com">
                @error('domain')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Nama Kontak *</label>
                <input type="text" name="contact_name" value="{{ old('contact_name', $tenant->contact_name) }}"
                       required class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none"
                       placeholder="Budi Santoso">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Email Kontak *</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $tenant->contact_email) }}"
                       required class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none"
                       placeholder="budi@akagroupconsulting.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Telepon/WA</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $tenant->contact_phone) }}"
                       class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none"
                       placeholder="0812-3456-7890">
            </div>
        </div>
    </div>

    {{-- Langganan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-6 space-y-4">
        <h3 class="font-black text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">subscriptions</span>
            Detail Langganan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Plan *</label>
                <select name="plan" required class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none bg-white">
                    <option value="basic" @selected(old('plan', $tenant->plan) === 'basic')>Basic</option>
                    <option value="professional" @selected(old('plan', $tenant->plan) === 'professional')>Professional</option>
                    <option value="enterprise" @selected(old('plan', $tenant->plan) === 'enterprise')>Enterprise</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Harga/Tahun (Rp)</label>
                <input type="number" name="price_yearly" value="{{ old('price_yearly', $tenant->price_yearly) }}"
                       min="0" class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none"
                       placeholder="4990000">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Tanggal Berlangganan</label>
                <input type="date" name="subscribed_at" value="{{ old('subscribed_at', $tenant->subscribed_at?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Tanggal Expired *</label>
                <input type="date" name="expires_at" value="{{ old('expires_at', $tenant->expires_at?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none">
                @error('expires_at')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Status *</label>
                <select name="status" required class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none bg-white">
                    @foreach(['trial','active','suspended','expired'] as $s)
                        <option value="{{ $s }}" @selected(old('status', $tenant->status) === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-on-surface-variant mb-1.5 uppercase tracking-wider">Catatan Internal</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-outline-variant/40 rounded-xl text-sm focus:ring-2 focus:ring-primary/30 outline-none resize-none"
                      placeholder="Catatan tambahan untuk internal...">{{ old('notes', $tenant->notes) }}</textarea>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center gap-4">
        <button type="submit" class="px-7 py-3 bg-primary text-white font-bold text-sm rounded-xl hover:bg-primary/90 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-base">save</span>
            {{ $tenant->id ? 'Simpan Perubahan' : 'Tambah Tenant' }}
        </button>
        <a href="{{ route('admin.saas-tenants.index') }}" class="px-7 py-3 bg-surface-container-low text-on-surface-variant font-bold text-sm rounded-xl hover:bg-surface-container transition-colors">
            Batal
        </a>
    </div>
</form>

@endsection
