@extends('layouts.admin')

@section('title', 'Manajemen Blog - Rakira CMS')
@section('page_title', 'Blog & Articles')
@section('page_subtitle', 'Kelola, tulis, dan terbitkan konten menarik untuk audiens Anda.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    {{-- Header & Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-indigo-500 text-2xl">article</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Artikel</p>
                <p class="text-2xl font-black text-slate-800">{{ $articles->count() }}</p>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-emerald-500 text-2xl">check_circle</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Published</p>
                <p class="text-2xl font-black text-slate-800">{{ $articles->where('status', 'published')->count() }}</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-amber-500 text-2xl">edit_document</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Drafts</p>
                <p class="text-2xl font-black text-slate-800">{{ $articles->where('status', 'draft')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="relative w-full md:w-80 group text-slate-400 focus-within:text-slate-800">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input type="text" placeholder="Cari artikel..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none text-slate-800 shadow-sm">
        </div>
        
        <a href="{{ route('admin.articles.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">add</span>
            Tulis Artikel Baru
        </a>
    </div>

    {{-- Articles Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($articles as $article)
        <div class="group bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
            {{-- Card Header / Image --}}
            <div class="relative h-48 bg-slate-100 overflow-hidden">
                @if($article->cover_image)
                    <img src="{{ asset('storage/' . $article->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-50">
                        <span class="material-symbols-outlined text-4xl mb-2">image_not_supported</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest">No Cover Image</span>
                    </div>
                @endif
                
                {{-- Status Badge (Floating) --}}
                <div class="absolute top-4 right-4">
                    @if($article->status === 'published')
                        <span class="px-3 py-1.5 rounded-xl bg-emerald-500/90 backdrop-blur-sm text-white border border-white/20 text-[9px] font-black uppercase tracking-widest shadow-lg flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            Published
                        </span>
                    @else
                        <span class="px-3 py-1.5 rounded-xl bg-slate-800/90 backdrop-blur-sm text-white border border-white/20 text-[9px] font-black uppercase tracking-widest shadow-lg flex items-center gap-1">
                            Draft
                        </span>
                    @endif
                </div>

                {{-- Category Badge (Floating) --}}
                <div class="absolute bottom-4 left-4">
                    <span class="px-3 py-1.5 rounded-xl bg-white/90 backdrop-blur-sm text-slate-800 text-[9px] font-black uppercase tracking-widest shadow-sm">
                        {{ $article->category->name ?? 'Uncategorized' }}
                    </span>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-6 flex flex-col flex-1">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                    {{ $article->created_at->format('d M Y') }}
                </p>
                <h3 class="text-lg font-bold text-slate-800 leading-snug mb-4 line-clamp-2 group-hover:text-slate-600 transition-colors">
                    {{ $article->title }}
                </h3>

                {{-- Footer Area --}}
                <div class="mt-auto pt-5 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[10px] font-black border border-slate-200">
                            {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="text-xs font-bold text-slate-600">{{ $article->author->name ?? 'Admin' }}</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('admin.articles.edit', $article->id) }}" 
                            class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                        </a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus artikel ini?')">
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
                <span class="material-symbols-outlined text-4xl text-slate-300">article</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Artikel</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-md">Mulai buat dan bagikan cerita menarik atau wawasan terbaru kepada audiens Anda.</p>
            <a href="{{ route('admin.articles.create') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-800 bg-slate-100 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all">
                Buat Artikel Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
