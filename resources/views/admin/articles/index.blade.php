@extends('layouts.admin')

@section('title', 'Manajemen Blog - Rakira CMS')
@section('page_title', 'Artikel & Berita')
@section('page_subtitle', 'Tulis dan terbitkan konten menarik untuk audiens Anda.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    {{-- Header Actions --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="bg-primary/5 p-3 rounded-2xl">
                <span class="material-symbols-outlined text-primary">article</span>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-900">Total Konten</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $articles->count() }} Artikel Terdaftar</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:w-64 group text-slate-400 focus-within:text-slate-800">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </div>
                <input type="text" placeholder="Cari artikel..." 
                    style="padding-left: 2.5rem;" class="w-full bg-slate-50 border border-slate-200 rounded-xl pr-4 py-3 text-xs font-bold focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none text-slate-800">
            </div>
            <a href="{{ route('admin.articles.create') }}" 
                class="bg-slate-900 text-white px-6 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-slate-800 transition-all shadow-lg active:scale-95">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Tulis Artikel
            </a>
        </div>
    </div>

    {{-- Articles Grid/List --}}
    <div class="bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400">Info Artikel</th>
                    <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori</th>
                    <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Penulis</th>
                    <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($articles as $article)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="py-5 px-8">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-12 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0">
                                @if($article->cover_image)
                                    <img src="{{ asset('storage/' . $article->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <span class="material-symbols-outlined">image</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900 line-clamp-1">{{ $article->title }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">Dibuat {{ $article->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[9px] font-black uppercase tracking-widest border border-slate-200">
                            {{ $article->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[10px] font-black">
                                {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-slate-600">{{ $article->author->name ?? 'Admin' }}</span>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        @if($article->status === 'published')
                            <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black uppercase tracking-widest">Published</span>
                        @else
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-400 border border-slate-200 text-[9px] font-black uppercase tracking-widest">Draft</span>
                        @endif
                    </td>
                    <td class="py-5 px-8 text-right">
                        <div class="flex justify-end items-center gap-3">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                class="w-9 h-9 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all group-hover:bg-white group-hover:shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                    class="w-9 h-9 rounded-xl border border-slate-100 flex items-center justify-center text-slate-300 hover:text-red-500 hover:border-red-100 transition-all group-hover:bg-white group-hover:shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="flex flex-col items-center gap-3 opacity-20">
                            <span class="material-symbols-outlined text-6xl text-slate-400">auto_stories</span>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Belum ada artikel yang ditulis</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
