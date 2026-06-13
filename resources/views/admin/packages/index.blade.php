@extends('layouts.admin')

@section('title', 'Master Paket - Rakira CMS')
@section('page_title', 'Master Paket Langganan')
@section('page_subtitle', 'Kelola paket langganan SaaS dan penetapan harganya.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    
    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="relative w-full md:w-80 group text-slate-400 focus-within:text-slate-800">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input type="text" placeholder="Cari paket langganan..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none text-slate-800 shadow-sm">
        </div>
        
        <a href="{{ route('admin.packages.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">add</span>
            Tambah Paket Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    {{-- Packages Pricing Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-center">
        @forelse($packages as $p)
        <div class="group relative bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col p-8 {{ $loop->iteration == 2 ? 'border-indigo-500 ring-4 ring-indigo-50 shadow-indigo-100 scale-105 z-10' : '' }}">
            
            @if($loop->iteration == 2)
            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
            <div class="absolute top-6 right-6 bg-indigo-50 text-indigo-700 text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-indigo-100">
                Populer
            </div>
            @endif

            {{-- Header --}}
            <div class="text-center mb-6">
                <span class="inline-block px-3 py-1 mb-3 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-bold tracking-widest uppercase border border-indigo-100">
                    {{ $p->system->system_name ?? 'Sistem Umum' }}
                </span>
                <h3 class="text-xl font-black text-slate-800 mb-2">{{ $p->package_name }}</h3>
                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold tracking-widest uppercase border border-slate-200">
                    {{ $p->package_code }}
                </span>
            </div>

            {{-- Pricing --}}
            <div class="text-center mb-8">
                <div class="flex items-end justify-center gap-1">
                    <span class="text-lg font-bold text-slate-400 mb-1">Rp</span>
                    <span class="text-5xl font-black text-slate-800 tracking-tight">{{ number_format($p->package_price, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-slate-400 font-medium mt-2">Per Bulan / Berlangganan</p>
            </div>

            {{-- Features / Limits --}}
            <div class="flex-1 space-y-4 mb-8">
                @if($p->package_benefits)
                    @foreach(explode("\n", str_replace("\r", "", $p->package_benefits)) as $benefit)
                        @if(trim($benefit) !== '')
                        <div class="flex items-start gap-3 text-sm text-slate-600 font-medium bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="w-8 h-8 shrink-0 rounded-full bg-white flex items-center justify-center text-emerald-500 shadow-sm mt-0.5">
                                <span class="material-symbols-outlined text-[18px]">check</span>
                            </div>
                            <div class="pt-1 leading-tight">{{ $benefit }}</div>
                        </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-sm text-slate-400 italic text-center py-4">Belum ada deskripsi benefit</div>
                @endif
            </div>

            {{-- Footer Actions --}}
            <div class="grid grid-cols-2 gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.packages.edit', $p) }}" 
                    class="flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-50 text-slate-600 font-bold text-xs uppercase tracking-wider hover:bg-slate-100 hover:text-slate-900 transition-all border border-slate-200">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    Edit
                </a>
                <form action="{{ route('admin.packages.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus paket ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-red-50 text-red-500 font-bold text-xs uppercase tracking-wider hover:bg-red-500 hover:text-white transition-all border border-red-100">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 bg-white border border-slate-200 border-dashed rounded-[2rem] text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-slate-300">inventory_2</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Paket Langganan</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-md">Buat paket pertama Anda untuk ditawarkan kepada pelanggan SaaS Anda.</p>
            <a href="{{ route('admin.packages.create') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-800 bg-slate-100 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all">
                Buat Paket Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection