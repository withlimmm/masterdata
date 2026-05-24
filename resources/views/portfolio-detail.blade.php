@extends('layouts.main')

@section('title', __t($portfolio->project_name) . ' - Portofolio Rakira')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags(__t($portfolio->description)), 150))
@section('meta_keywords', __t($portfolio->project_name) . ', ' . __t($portfolio->category->name ?? 'Portofolio') . ', portofolio rakira digital')

@section('content')
<div class="pt-24 min-h-screen bg-white">
    {{-- Hero Section --}}
    <header class="relative w-full h-[60vh] md:h-[75vh] overflow-hidden">
        {{-- Banner Utama --}}
        @if($portfolio->thumbnail_image)
            <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" 
                 alt="{{ __t($portfolio->project_name) }}" 
                 class="w-full h-full object-cover animate-in fade-in zoom-in duration-1000">
        @else
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1200" 
                 class="w-full h-full object-cover">
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 w-full p-8 md:p-20 z-10">
            <div class="max-w-7xl mx-auto" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-6">
                    <span class="bg-primary px-4 py-2 rounded-full text-white text-[10px] font-black uppercase tracking-widest shadow-xl">
                        {{ __t($portfolio->category->name ?? 'Uncategorized') }}
                    </span>
                    <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-white text-[10px] font-black uppercase tracking-widest border border-white/30">
                        {{ strtoupper($portfolio->status) }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-7xl font-black text-white leading-tight mb-4 tracking-tight">
                    {{ __t($portfolio->project_name) }}
                </h1>
            </div>
        </div>
    </header>

    {{-- Content Section --}}
    <main class="max-w-7xl mx-auto px-8 md:px-20 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-20">
            {{-- Kiri: Detail Deskripsi --}}
            <div class="lg:col-span-8 space-y-12" data-aos="fade-right">
                <div class="space-y-6">
                    <h2 class="text-3xl font-black text-slate-900 flex items-center gap-4">
                        <span class="w-12 h-1.5 bg-primary rounded-full"></span>
                        {{ __('Tentang Proyek') }}
                    </h2>
                    <div class="text-slate-600 text-lg leading-relaxed prose prose-slate max-w-none italic">
                        {!! nl2br(e(__t($portfolio->description))) !!}
                    </div>
                </div>

                {{-- Galeri Foto Dinamis --}}
                <div class="space-y-8 pt-10">
                    <h3 class="text-xl font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined notranslate text-primary" translate="no">gallery_thumbnail</span>
                        {{ __('Galeri Proyek') }}
                    </h3>
                    
                    @if(is_array($portfolio->gallery_images) && count($portfolio->gallery_images) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($portfolio->gallery_images as $index => $img)
                                <div class="group relative rounded-[2.5rem] overflow-hidden shadow-2xl border border-slate-100 h-96" 
                                     data-aos="zoom-in" 
                                     data-aos-delay="{{ $index * 100 }}">
                                    <img src="{{ asset('storage/' . $img) }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Jika Galeri Kosong, tampilkan pesan informatif untuk admin --}}
                        <div class="p-10 border-2 border-dashed border-slate-100 rounded-[2.5rem] text-center">
                            <span class="material-symbols-outlined notranslate text-slate-200 text-6xl mb-4" translate="no">image_not_supported</span>
                            <p class="text-slate-400 font-medium italic">{{ __('Belum ada foto tambahan untuk proyek ini.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kanan: Info Sidebar --}}
            <div class="lg:col-span-4 space-y-8" data-aos="fade-left">
                <div class="bg-slate-50 rounded-[3rem] p-10 space-y-10 sticky top-32 border border-slate-100 shadow-sm">
                    <div class="space-y-2">
                        <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">{{ __('Nama Klien') }}</p>
                        <p class="text-xl font-bold text-slate-900">{{ __t($portfolio->client_name ?? 'Rakira Client') }}</p>
                    </div>
                    
                    <div class="space-y-2">
                        <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">{{ __('Industri / Kategori') }}</p>
                        <p class="text-xl font-bold text-slate-900">{{ __t($portfolio->category->name ?? 'Digital Solution') }}</p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">{{ __('Tanggal Proyek') }}</p>
                        <p class="text-xl font-bold text-slate-900">{{ $portfolio->created_at->format('d M Y') }}</p>
                    </div>

                    <hr class="border-slate-200">

                    <div class="space-y-6">
                        <p class="text-sm font-bold text-slate-600 leading-relaxed">
                            {{ __('Tertarik memiliki proyek serupa untuk bisnis Anda?') }}
                        </p>
                        <a href="{{ url('/#kontak') }}" class="flex items-center justify-center gap-3 w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                            {{ __('Konsultasi Sekarang') }}
                            <span class="material-symbols-outlined notranslate text-lg" translate="no">chat</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Back to Portfolio --}}
    <div class="pb-20 text-center">
        <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-2 text-slate-400 font-bold hover:text-primary transition-colors group">
            <span class="material-symbols-outlined notranslate group-hover:-translate-x-2 transition-transform" translate="no">arrow_back</span>
            {{ __('Kembali ke Daftar Portofolio') }}
        </a>
    </div>
</div>
@endsection
