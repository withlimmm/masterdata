@extends('layouts.main')

@section('title', Str::limit(strip_tags(__t($article->title)), 60) . ' - Rakira Digital Blog')
@section('meta_description', Str::limit(strip_tags(__t($article->excerpt ?? $article->content)), 155))
@section('meta_keywords', implode(', ', array_filter([
    __t($article->category->name ?? ''),
    'blog', 'rakira digital', 'tips digital', 'software house indonesia'
])))
@section('og_type', 'article')

@push('og_tags')
@if($article->cover_image)
<meta property="og:image" content="{{ asset('storage/' . $article->cover_image) }}">
@endif
<meta property="article:published_time" content="{{ ($article->published_at ?? $article->created_at)->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
<meta property="article:author" content="{{ $article->author->name ?? 'Rakira Digital' }}">
<meta property="article:section" content="{{ __t($article->category->name ?? 'Technology') }}">
@endpush

@push('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BlogPosting",
  "headline": "{{ addslashes(strip_tags(__t($article->title))) }}",
  "description": "{{ addslashes(Str::limit(strip_tags(__t($article->excerpt ?? $article->content)), 155)) }}",
  "image": [
    @if($article->cover_image)
    "{{ asset('storage/' . $article->cover_image) }}"
    @else
    "{{ asset('images/og-rakira.png') }}"
    @endif
  ],
  "datePublished": "{{ ($article->published_at ?? $article->created_at)->toIso8601String() }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": {
    "@@type": "Person",
    "name": "{{ $article->author->name ?? 'Tim Rakira Digital' }}",
    "url": "{{ url('/tentang-kami') }}"
  },
  "publisher": {
    "@@type": "Organization",
    "name": "Rakira Digital Nusantara",
    "logo": {
      "@@type": "ImageObject",
      "url": "{{ asset('images/logo-rakira.png') }}"
    }
  },
  "mainEntityOfPage": {
    "@@type": "WebPage",
    "@@id": "{{ url()->current() }}"
  },
  "articleSection": "{{ __t($article->category->name ?? 'Technology') }}",
  "inLanguage": "{{ app()->getLocale() }}-ID",
  "wordCount": {{ str_word_count(strip_tags(__t($article->content))) }},
  "url": "{{ url()->current() }}"
}
</script>
@endpush

@section('content')
<div class="pt-24 bg-white min-h-screen">
    {{-- Hero/Header Artikel --}}
    <article class="pb-20">
        <header class="pt-16 pb-12 text-center" data-aos="fade-down">
            <div class="content-container max-w-4xl">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <span class="px-4 py-1.5 rounded-full bg-primary/5 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/10">
                        {{ __t($article->category->name ?? 'Update') }}
                    </span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                        {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight text-slate-900 mb-8 max-w-5xl mx-auto">
                    {{ __t($article->title) }}
                </h1>

                <div class="flex items-center justify-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs border border-slate-200">
                        {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ $article->author->name ?? 'Admin Rakira' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">{{ __('Penulis Konten') }}</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Gambar Sampul Besar --}}
        <div class="content-container max-w-6xl mb-16" data-aos="zoom-in">
            <div class="aspect-[21/9] rounded-[3rem] overflow-hidden shadow-2xl bg-slate-100 border border-slate-100">
                @if($article->cover_image)
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ __t($article->title) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-200">
                        <span class="material-symbols-outlined notranslate text-8xl" translate="no">image</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="content-container max-w-3xl">
            <div class="prose prose-lg max-w-none prose-slate prose-headings:font-black prose-headings:tracking-tight prose-a:text-primary prose-img:rounded-3xl shadow-none">
                {!! nl2br(__t($article->content)) !!}
            </div>

            {{-- Footer Artikel: Share --}}
            <div class="mt-20 pt-10 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ __('Bagikan Artikel:') }}</p>
                    <div class="flex gap-2">
                        <a href="#" aria-label="Bagikan ke Facebook" class="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white transition-all">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" aria-label="Bagikan ke Twitter" class="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white transition-all">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" aria-label="Bagikan ke LinkedIn" class="w-10 h-10 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white transition-all">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    </div>
                </div>
                <a href="{{ route('blog') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-900 transition-colors">
                    <span class="material-symbols-outlined notranslate text-[20px]" translate="no">arrow_back</span>
                    <span class="text-[10px] font-black uppercase tracking-widest">{{ __('Kembali ke Blog') }}</span>
                </a>
            </div>
        </div>
    </article>

    {{-- Artikel Terkait --}}
    @if($related_articles->isNotEmpty())
    <section class="py-24 bg-slate-50">
        <div class="content-container">
            <div class="flex items-center justify-between mb-12">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ __('Artikel Terkait') }}</h3>
                <a href="{{ route('blog') }}" aria-label="Lihat Semua Artikel" class="text-[10px] font-black uppercase tracking-[0.2em] text-primary hover:underline">{{ __('Lihat Semua') }}</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($related_articles as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}" class="group block space-y-4">
                    <div class="aspect-[16/10] rounded-3xl overflow-hidden bg-white border border-slate-100 shadow-sm">
                        @if($rel->cover_image)
                            <img src="{{ asset('storage/' . $rel->cover_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200">
                                <span class="material-symbols-outlined notranslate" translate="no">image</span>
                            </div>
                        @endif
                    </div>
                    <div class="px-2">
                        <p class="text-[9px] font-black uppercase tracking-widest text-primary mb-2">{{ __t($rel->category->name ?? 'Update') }}</p>
                        <h4 class="font-bold text-slate-900 group-hover:text-primary transition-colors leading-snug line-clamp-2">{{ __t($rel->title) }}</h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection
