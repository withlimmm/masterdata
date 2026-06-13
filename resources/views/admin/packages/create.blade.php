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
                <div class="space-y-3 col-span-1 md:col-span-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Sistem (Header) <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400 text-[18px]">category</span>
                        </div>
                        <select name="system_id" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none text-slate-700 appearance-none">
                            <option value="">Pilih Sistem Langganan...</option>
                            @foreach($systems as $sys)
                                <option value="{{ $sys->id }}" {{ old('system_id') == $sys->id ? 'selected' : '' }}>
                                    {{ $sys->system_name }} ({{ $sys->system_code }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-5 pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400">expand_more</span>
                        </div>
                    </div>
                </div>

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

                <div class="space-y-3 col-span-1 md:col-span-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Deskripsi Singkat Paket</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <span class="material-symbols-outlined text-slate-400 text-[18px]">description</span>
                        </div>
                        <input type="text" name="package_description" value="{{ old('package_description') }}"
                            placeholder="Contoh: Solusi terbaik untuk pengelolaan bisnis..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-medium outline-none text-slate-700 placeholder-slate-300">
                    </div>
                </div>

                <div class="space-y-3 col-span-1 md:col-span-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Benefit Layanan</label>
                    <div class="relative">
                        <textarea name="package_benefits" rows="4"
                            placeholder="Contoh:&#10;100 Transaksi per Bulan&#10;Dukungan Prioritas"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-medium outline-none text-slate-700 placeholder-slate-300">{{ old('package_benefits') }}</textarea>
                    </div>
                    <p class="text-[10px] text-slate-400 ml-2">Tuliskan tiap benefit di baris baru (tekan Enter).</p>
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

                <div class="space-y-3 col-span-1 md:col-span-2 mt-4 bg-slate-50 border border-slate-200 rounded-3xl p-6 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-800">Tandai sebagai Paling Populer</h4>
                        <p class="text-xs text-slate-500 mt-1">Paket akan diberi lencana "Paling Populer" di halaman landing page.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_popular" value="1" class="sr-only peer" {{ old('is_popular') ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#009fe3]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#009fe3]"></div>
                    </label>
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