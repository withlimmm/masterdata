@extends('layouts.admin')

@section('title', 'Tambah Paket - Rakira CMS')
@section('page_title', 'Tambah Paket Baru')
@section('page_subtitle', 'Tentukan batasan dan harga untuk paket langganan baru.')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- Header Actions --}}
    <div class="mb-8 flex items-center justify-between animate-in slide-in-from-left duration-500">
        <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-5 py-2.5 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-slate-900 hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm group">
            <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="text-[10px] font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.packages.store') }}" method="POST" class="animate-in fade-in duration-700">
        @csrf
        
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 md:p-12 shadow-sm space-y-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-bl-[150px] -z-0 opacity-50"></div>
            
            <div class="relative z-10 flex items-center gap-4 border-b border-slate-100 pb-8">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-inner">
                    <span class="material-symbols-outlined text-2xl">local_mall</span>
                </div>
                <div>
                    <h3 class="font-black text-slate-800 text-lg mb-1">Detail Paket Langganan</h3>
                    <p class="text-xs text-slate-400 font-medium">Lengkapi informasi dasar dan batasan sistem untuk paket ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Kode Paket <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400 text-[18px]">tag</span>
                        </div>
                        <input type="text" name="package_code" value="{{ old('package_code') }}" required
                            placeholder="Contoh: PKG-BASIC"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none text-slate-700 placeholder-slate-300 uppercase">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Paket <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400 text-[18px]">badge</span>
                        </div>
                        <input type="text" name="package_name" value="{{ old('package_name') }}" required
                            placeholder="Contoh: Basic Plan"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none text-slate-700 placeholder-slate-300">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Maksimal Produk <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400 text-[18px]">inventory</span>
                        </div>
                        <input type="number" name="package_max_products" value="{{ old('package_max_products') }}" required min="1"
                            placeholder="Contoh: 100"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none text-slate-700 placeholder-slate-300">
                    </div>
                    <p class="text-[10px] text-slate-400 ml-2">Batas jumlah produk yang dapat dibuat penyewa.</p>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Harga Langganan (Rp) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <span class="font-black text-slate-400 text-sm">Rp</span>
                        </div>
                        <input type="number" name="package_price" value="{{ old('package_price') }}" required min="0"
                            placeholder="Contoh: 99000"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-black outline-none text-slate-800 placeholder-slate-300 tracking-wider">
                    </div>
                    <p class="text-[10px] text-slate-400 ml-2">Harga per bulan. Ketik tanpa titik atau koma.</p>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex justify-end relative z-10">
                <button type="submit" 
                    class="w-full md:w-auto bg-slate-900 text-white px-12 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.15em] shadow-xl shadow-slate-900/20 hover:bg-slate-800 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Simpan Paket
                </button>
            </div>
        </div>
    </form>
</div>
@endsection