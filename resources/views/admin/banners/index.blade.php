@extends('layouts.admin')

@section('title', 'Manajemen Banner - Rakira CMS')
@section('page_title', 'Daftar Banner')
@section('page_subtitle', 'Kelola banner yang akan ditampilkan di halaman utama website.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    {{-- Header & Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-indigo-500 text-2xl">view_carousel</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Banner</p>
                <p class="text-2xl font-black text-slate-800">{{ $banners->count() }}</p>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-emerald-500 text-2xl">public</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Aktif / Terbit</p>
                <p class="text-2xl font-black text-slate-800">{{ $banners->where('is_active', true)->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="w-full md:w-auto text-sm text-slate-500 px-4 font-semibold">
            Maksimal 3 banner yang akan dirender secara dinamis di *homepage*.
        </div>
        
        <a href="{{ route('admin.banners.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">add</span>
            Tambah Banner Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3">
        <span class="material-symbols-outlined">check_circle</span>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Banners Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($banners as $banner)
        <div class="group bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col p-6">
            {{-- Header Image --}}
            <div class="w-full h-40 rounded-xl bg-slate-100 overflow-hidden mb-5 relative border border-slate-200">
                <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                <div class="absolute top-3 right-3">
                    @if($banner->is_active)
                        <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-black uppercase tracking-widest flex items-center gap-1 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active
                        </span>
                    @else
                        <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 text-[9px] font-black uppercase tracking-widest shadow-sm flex items-center gap-1">
                            Draft
                        </span>
                    @endif
                </div>
            </div>

            {{-- Body Card --}}
            <div class="flex-1">
                <h3 class="text-lg font-black text-slate-800 leading-snug mb-2 group-hover:text-slate-600 transition-colors">
                    {{ $banner->title ?: 'Tanpa Judul' }}
                </h3>
                @if($banner->link_url)
                <p class="text-xs text-blue-500 break-all mb-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">link</span>
                    {{ Str::limit($banner->link_url, 40) }}
                </p>
                @endif
                <p class="text-xs font-bold text-slate-400 uppercase">Urutan Tampil: {{ $banner->sort_order }}</p>
            </div>

            {{-- Footer Area --}}
            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                    ID: #{{ str_pad($banner->id, 3, '0', STR_PAD_LEFT) }}
                </span>

                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.banners.edit', $banner) }}" 
                        class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </a>
                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus banner ini?')">
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
                <span class="material-symbols-outlined text-4xl text-slate-300">view_carousel</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Banner</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-md">Tambahkan banner promosi pertama Anda untuk meramaikan halaman beranda.</p>
            <a href="{{ route('admin.banners.create') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-800 bg-slate-100 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all">
                Buat Banner Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
