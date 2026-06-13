@extends('layouts.admin')

@section('title', 'Manajemen Layanan - Rakira CMS')
@section('page_title', 'Daftar Layanan')
@section('page_subtitle', 'Kelola kategori layanan yang ditawarkan dan ditampilkan di website.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    {{-- Header & Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-indigo-500 text-2xl">category</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Layanan</p>
                <p class="text-2xl font-black text-slate-800">{{ $services->count() }}</p>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-emerald-500 text-2xl">public</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Aktif / Terbit</p>
                <p class="text-2xl font-black text-slate-800">{{ $services->where('status', 'active')->count() }}</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-slate-500 text-2xl">drafts</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Draft</p>
                <p class="text-2xl font-black text-slate-800">{{ $services->where('status', 'draft')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="relative w-full md:w-80 group text-slate-400 focus-within:text-slate-800">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input type="text" placeholder="Cari layanan..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none text-slate-800 shadow-sm">
        </div>
        
        <a href="{{ route('admin.services.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">add</span>
            Tambah Layanan Baru
        </a>
    </div>

    {{-- Services Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($services as $s)
        @php
            $serviceTitle = __t($s->title);
            $serviceShortDescription = __t($s->short_description);
        @endphp
        <div class="group bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col p-6">
            {{-- Header Card --}}
            <div class="flex items-start justify-between mb-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-800 group-hover:bg-slate-900 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <span class="material-symbols-outlined text-3xl">{{ $s->icon_image ?: 'settings' }}</span>
                </div>
                
                {{-- Status Badge --}}
                @if($s->status === 'active')
                    <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-black uppercase tracking-widest flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active
                    </span>
                @else
                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 text-[9px] font-black uppercase tracking-widest flex items-center gap-1">
                        Draft
                    </span>
                @endif
            </div>

            {{-- Body Card --}}
            <div class="flex-1">
                <h3 class="text-xl font-black text-slate-800 leading-snug mb-3 group-hover:text-slate-600 transition-colors">
                    {{ $serviceTitle }}
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed line-clamp-2">
                    {{ $serviceShortDescription }}
                </p>
            </div>

            {{-- Footer Area --}}
            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                    ID: #{{ str_pad($s->id, 3, '0', STR_PAD_LEFT) }}
                </span>

                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.services.edit', $s) }}" 
                        class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </a>
                    <form action="{{ route('admin.services.destroy', $s) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus layanan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" 
                            class="w-8 h-8 rounded-full bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 bg-white border border-slate-200 border-dashed rounded-[2rem] text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-slate-300">category</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Layanan</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-md">Tambahkan layanan pertama Anda untuk menampilkannya di halaman depan website.</p>
            <a href="{{ route('admin.services.create') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-800 bg-slate-100 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all">
                Buat Layanan Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
