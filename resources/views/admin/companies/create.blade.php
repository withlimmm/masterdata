@extends('layouts.admin')
@section('title', 'Daftarkan Klien - Rakira CMS')
@section('page_title', 'Registrasi Klien Baru')
@section('content')
<div class="max-w-4xl bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm p-6">
    <form action="{{ route('admin.companies.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="font-bold text-lg border-b pb-2">Data Perusahaan</h3>
                <div>
                    <label class="block text-sm font-medium mb-1">Paket Berlangganan</label>
                    <select name="package_id" class="w-full border-gray-300 rounded-md" required>
                        @foreach($packages as $p)
                        <option value="{{ $p->id }}">{{ $p->package_name }} - Rp {{ number_format($p->package_price,0,',','.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kode Perusahaan (Maks 10 char)</label>
                    <input type="text" name="company_code" value="{{ old('company_code') }}" class="w-full border-gray-300 rounded-md uppercase" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Perusahaan</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Domain/Subdomain Klien</label>
                    <input type="text" name="company_domain" value="{{ old('company_domain') }}" class="w-full border-gray-300 rounded-md" placeholder="clientA.rakiradigital.test" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Lama Langganan (Bulan)</label>
                    <input type="number" name="subscription_months" value="{{ old('subscription_months', 12) }}" class="w-full border-gray-300 rounded-md" required min="1">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Status Langganan</label>
                    <select name="subscription_status" class="w-full border-gray-300 rounded-md">
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
            </div>
            
            <div class="space-y-4">
                <h3 class="font-bold text-lg border-b pb-2">Data Admin Klien</h3>
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Admin</label>
                    <input type="text" name="admin_name" value="{{ old('admin_name') }}" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email Login Admin</label>
                    <input type="email" name="admin_email" value="{{ old('admin_email') }}" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password Login Admin</label>
                    <input type="password" name="admin_password" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn-primary mt-6 w-full py-3">Daftarkan Klien & Buat Tenant</button>
    </form>
</div>
@endsection