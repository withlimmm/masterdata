@extends('layouts.admin')
@section('title', 'Daftarkan Klien - Rakira CMS')
@section('page_title', 'Registrasi Klien Baru')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="px-8 py-6 border-b border-gray-200 bg-gray-50/50">
            <h2 class="text-xl font-bold text-gray-900">Formulir Registrasi Klien</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data berikut untuk mendaftarkan klien baru dan membuat tenant.</p>
        </div>
        
        <form action="{{ route('admin.companies.store') }}" method="POST">
            @csrf
            
            <div class="p-8 space-y-10">
                <!-- Data Perusahaan -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">1. Data Perusahaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm" placeholder="Contoh: PT Rakira Digital" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" name="company_code" value="{{ old('company_code') }}" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm uppercase" placeholder="Contoh: RAKIRA" maxlength="10" required>
                            <p class="text-xs text-gray-500 mt-1.5">Maks 10 karakter, gunakan huruf/angka.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Domain/Subdomain Klien <span class="text-red-500">*</span></label>
                            <input type="text" name="company_domain" value="{{ old('company_domain') }}" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm" placeholder="clientA.rakiradigital.test" required>
                        </div>
                    </div>
                </div>

                <!-- Langganan -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">2. Detail Langganan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Paket Berlangganan <span class="text-red-500">*</span></label>
                            <select name="package_id" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm" required>
                                <option value="">-- Pilih Paket --</option>
                                @foreach($packages as $p)
                                <option value="{{ $p->id }}">{{ $p->package_name }} - Rp {{ number_format($p->package_price,0,',','.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lama Langganan (Bulan) <span class="text-red-500">*</span></label>
                            <input type="number" name="subscription_months" value="{{ old('subscription_months', 12) }}" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm" required min="1">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Langganan</label>
                            <select name="subscription_status" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm">
                                <option value="active">Active</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Data Akun Admin -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">3. Akun Admin Tenant</h3>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mb-4 text-sm text-slate-700">
                        <span class="font-bold text-slate-900">Info:</span> Akun ini akan digunakan oleh klien untuk login ke dalam dashboard tenant mereka.
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                            <input type="text" name="admin_name" value="{{ old('admin_name') }}" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm" placeholder="Nama Lengkap Admin" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                                <input type="email" name="admin_email" value="{{ old('admin_email') }}" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm" placeholder="admin@domainklien.com" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="admin_password" class="w-full border-gray-300 focus:border-slate-900 focus:ring-slate-900 rounded-lg shadow-sm" placeholder="••••••••" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <button type="submit" class="w-full flex justify-center items-center gap-2 text-white text-base font-bold py-3.5 px-8 rounded-lg shadow-sm transition-all hover:opacity-90" style="background-color: #0B1120;">
                    <span class="material-symbols-outlined text-[20px]">rocket_launch</span>
                    Daftarkan Klien & Buat Tenant
                </button>
                <p class="text-center text-xs text-gray-500 mt-4">Proses ini akan memakan waktu beberapa saat karena sistem akan membuat database baru untuk tenant.</p>
            </div>
        </form>
    </div>
</div>
@endsection