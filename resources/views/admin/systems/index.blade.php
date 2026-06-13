@extends('layouts.admin')

@section('title', 'Master Sistem - Rakira CMS')
@section('page_title', 'Master Sistem Langganan')
@section('page_subtitle', 'Kelola header sistem untuk paket langganan SaaS (contoh: POS, WMS).')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    
    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="relative w-full md:w-80 group text-slate-400 focus-within:text-slate-800">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input type="text" placeholder="Cari sistem..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none text-slate-800 shadow-sm">
        </div>
        
        <a href="{{ route('admin.systems.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">add</span>
            Tambah Sistem Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
        <span class="material-symbols-outlined text-red-500">error</span>
        {{ session('error') }}
    </div>
    @endif

    {{-- Systems Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($systems as $sys)
        <div class="group relative bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col p-8">
            {{-- Header --}}
            <div class="mb-4 flex justify-between items-start">
                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 border border-indigo-100">
                    <span class="material-symbols-outlined">category</span>
                </div>
                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold tracking-widest uppercase border border-slate-200">
                    {{ $sys->system_code }}
                </span>
            </div>

            <div class="mb-6 flex-1">
                <h3 class="text-xl font-black text-slate-800 mb-2">{{ $sys->system_name }}</h3>
                <p class="text-sm text-slate-500">{{ $sys->description ?: 'Tidak ada deskripsi' }}</p>
                
                <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-100 text-xs font-bold text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    {{ $sys->packages->count() }} Paket Langganan
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="grid grid-cols-2 gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.systems.edit', $sys) }}" 
                    class="flex items-center justify-center gap-2 py-3 rounded-xl bg-slate-50 text-slate-600 font-bold text-xs uppercase tracking-wider hover:bg-slate-100 hover:text-slate-900 transition-all border border-slate-200">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    Edit
                </a>
                <form action="{{ route('admin.systems.destroy', $sys) }}" method="POST" onsubmit="return confirm('Hapus sistem ini secara permanen?')">
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
                <span class="material-symbols-outlined text-4xl text-slate-300">category</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Sistem</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-md">Buat kategori sistem pertama Anda untuk mengelompokkan paket langganan.</p>
            <a href="{{ route('admin.systems.create') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-800 bg-slate-100 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all">
                Buat Sistem Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
