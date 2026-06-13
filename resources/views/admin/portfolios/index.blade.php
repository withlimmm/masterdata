@extends('layouts.admin')

@section('title', 'Manajemen Portofolio - Rakira CMS')
@section('page_title', 'Portofolio Proyek')
@section('page_subtitle', 'Kelola daftar karya terbaik Rakira Digital yang ditampilkan di website.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    {{-- Header & Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-indigo-500 text-2xl">folder_special</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Proyek</p>
                <p class="text-2xl font-black text-slate-800">{{ $portfolios->count() }}</p>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-emerald-500 text-2xl">check_circle</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Selesai (Done)</p>
                <p class="text-2xl font-black text-slate-800">{{ $portfolios->where('status', 'done')->count() }}</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-blue-500 text-2xl">public</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Aktif / Publik</p>
                <p class="text-2xl font-black text-slate-800">{{ $portfolios->where('status', 'active')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="relative w-full md:w-80 group text-slate-400 focus-within:text-slate-800">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input type="text" placeholder="Cari proyek..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none text-slate-800 shadow-sm">
        </div>
        
        <a href="{{ route('admin.portfolios.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">add</span>
            Tambah Proyek Baru
        </a>
    </div>

    {{-- Portfolio Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($portfolios as $portfolio)
        <div class="group bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
            {{-- Card Header / Image --}}
            <div class="relative h-48 bg-slate-100 overflow-hidden">
                @if($portfolio->thumbnail_image)
                    <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-50">
                        <span class="material-symbols-outlined text-4xl mb-2">image_not_supported</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest">No Thumbnail</span>
                    </div>
                @endif
                
                {{-- Status Badge --}}
                <div class="absolute top-4 right-4">
                    @if($portfolio->status === 'active')
                        <span class="px-3 py-1.5 rounded-xl bg-blue-500/90 backdrop-blur-sm text-white border border-white/20 text-[9px] font-black uppercase tracking-widest shadow-lg flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            Active
                        </span>
                    @elseif($portfolio->status === 'done')
                        <span class="px-3 py-1.5 rounded-xl bg-emerald-500/90 backdrop-blur-sm text-white border border-white/20 text-[9px] font-black uppercase tracking-widest shadow-lg flex items-center gap-1">
                            Done
                        </span>
                    @else
                        <span class="px-3 py-1.5 rounded-xl bg-slate-800/90 backdrop-blur-sm text-white border border-white/20 text-[9px] font-black uppercase tracking-widest shadow-lg flex items-center gap-1">
                            Draft
                        </span>
                    @endif
                </div>

                {{-- Category Badge --}}
                <div class="absolute bottom-4 left-4">
                    <span class="px-3 py-1.5 rounded-xl bg-white/90 backdrop-blur-sm text-slate-800 text-[9px] font-black uppercase tracking-widest shadow-sm">
                        {{ $portfolio->category->name ?? 'Uncategorized' }}
                    </span>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-6 flex flex-col flex-1">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">business</span>
                    {{ $portfolio->client_name ?? 'Internal Project' }}
                </p>
                <h3 class="text-lg font-bold text-slate-800 leading-snug mb-4 line-clamp-2 group-hover:text-slate-600 transition-colors">
                    {{ $portfolio->project_name }}
                </h3>

                {{-- Footer Area --}}
                <div class="mt-auto pt-5 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                        Updated {{ $portfolio->updated_at->diffForHumans() }}
                    </span>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}" 
                            class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                        </a>
                        <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus proyek ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                class="w-8 h-8 rounded-full bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 bg-white border border-slate-200 border-dashed rounded-[2rem] text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-slate-300">inventory_2</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Proyek</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-md">Mulai tambahkan hasil karya atau proyek unggulan untuk ditampilkan di portofolio.</p>
            <a href="{{ route('admin.portfolios.create') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-800 bg-slate-100 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all">
                Tambah Proyek Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
