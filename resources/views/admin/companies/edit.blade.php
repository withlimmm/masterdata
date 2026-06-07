@extends('layouts.admin')
@section('title', 'Edit Klien - Rakira CMS')
@section('page_title', 'Edit Data Klien')
@section('content')
<div class="max-w-2xl bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm p-6">
    <form action="{{ route('admin.companies.update', $company) }}" method="POST">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Paket Berlangganan</label>
                <select name="package_id" class="w-full border-gray-300 rounded-md" required>
                    @foreach($packages as $p)
                    <option value="{{ $p->id }}" {{ $company->package_id == $p->id ? 'selected' : '' }}>{{ $p->package_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kode Perusahaan</label>
                <input type="text" name="company_code" value="{{ old('company_code', $company->company_code) }}" class="w-full border-gray-300 rounded-md uppercase" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Nama Perusahaan</label>
                <input type="text" name="company_name" value="{{ old('company_name', $company->company_name) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Domain/Subdomain</label>
                <input type="text" name="company_domain" value="{{ old('company_domain', $company->company_domain) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">SaaS API Key (Untuk Microservice)</label>
                <div class="flex gap-2">
                    <input type="text" value="{{ $company->api_key }}" class="w-full border-gray-300 rounded-md bg-gray-50 text-gray-500 font-mono text-sm" readonly>
                    <button type="button" onclick="document.getElementById('regenerate-form').submit();" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Regenerate
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Gunakan kunci ini di file .env aplikasi klien eksternal.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Kedaluwarsa Langganan</label>
                <input type="date" name="subscription_expired_at" value="{{ old('subscription_expired_at', $company->subscription_expired_at->format('Y-m-d')) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status Langganan</label>
                <select name="subscription_status" class="w-full border-gray-300 rounded-md">
                    <option value="active" {{ $company->subscription_status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ $company->subscription_status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="expired" {{ $company->subscription_status == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <button type="submit" class="btn-primary mt-4">Simpan Perubahan</button>
        </div>
    </form>
</div>

<form id="regenerate-form" action="{{ route('admin.companies.regenerate-key', $company) }}" method="POST" class="hidden">
    @csrf
</form>
@endsection