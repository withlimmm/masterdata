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
<div class="pt-24 min-h-screen bg-surface">
    {{-- Hero/Header Artikel --}}
    <article class="pb-20">
        <header class="pt-16 pb-12 text-center" data-aos="fade-down">
            <div class="max-w-4xl mx-auto px-4 md:px-20">
                <div class="flex items-center justify-center gap-3 mb-6">
                    <span class="px-4 py-1.5 rounded-full bg-primary/5 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/10">
                        {{ __t($article->category->name ?? 'Update') }}
                    </span>
                    <span class="w-1 h-1 rounded-full bg-outline-variant/30"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant flex items-center gap-1.5">
                        <span class="material-symbols-outlined notranslate text-[14px]" translate="no">calendar_today</span>
                        {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight text-on-surface mb-8 max-w-5xl mx-auto">
                    {{ __t($article->title) }}
                </h1>

                <div class="flex items-center justify-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant font-black text-xs border border-outline-variant/10">
                        {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-bold text-on-surface uppercase tracking-widest">{{ $article->author->name ?? 'Tim Rakira' }}</p>
                        <p class="text-[10px] text-on-surface-variant font-medium">{{ __('Penulis Konten') }}</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Gambar Sampul Besar --}}
        <div class="max-w-6xl mx-auto px-4 md:px-20 mb-16" data-aos="zoom-in">
            <div class="aspect-[21/9] rounded-[3rem] overflow-hidden shadow-2xl bg-surface-container border border-outline-variant/10">
                @if($article->cover_image)
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ __t($article->title) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-outline-variant">
                        <span class="material-symbols-outlined notranslate text-8xl" translate="no">image</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="max-w-4xl mx-auto px-4 md:px-20">
            <div class="prose prose-lg max-w-none prose-slate prose-headings:font-black prose-headings:text-on-surface prose-p:text-on-surface-variant prose-a:text-primary prose-img:rounded-[2rem] shadow-none">
                {!! nl2br(__t($article->content)) !!}
            </div>

            {{-- Footer Artikel: Share --}}
            <div class="mt-20 pt-10 border-t border-outline-variant/10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <p class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">{{ __('Bagikan Artikel:') }}</p>
                    <div class="flex gap-2">
                        <a href="#" aria-label="Bagikan ke Facebook" class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-white hover:border-primary transition-all">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" aria-label="Bagikan ke Twitter" class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-white hover:border-primary transition-all">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" aria-label="Bagikan ke LinkedIn" class="w-10 h-10 rounded-full border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:bg-primary hover:text-white hover:border-primary transition-all">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    </div>
                </div>
                <a href="{{ route('blog') }}" class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined notranslate text-[20px]" translate="no">arrow_back</span>
                    <span class="text-[10px] font-black uppercase tracking-widest">{{ __('Kembali ke Blog') }}</span>
                </a>
            </div>
        </div>
    </article>

    {{-- Artikel Terkait --}}
    @if($related_articles->isNotEmpty())
    <section class="py-24 bg-surface-container-low border-t border-outline-variant/10">
        <div class="max-w-7xl mx-auto px-4 md:px-20">
            <div class="flex items-center justify-between mb-12">
                <h3 class="text-2xl font-black text-on-surface tracking-tight">{{ __('Artikel Terkait') }}</h3>
                <a href="{{ route('blog') }}" aria-label="Lihat Semua Artikel" class="text-[10px] font-black uppercase tracking-[0.2em] text-primary hover:underline">{{ __('Lihat Semua') }}</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($related_articles as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}" class="group block surface-card overflow-hidden rounded-[2rem] bg-white border border-outline-variant/10 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                    <div class="aspect-[16/10] overflow-hidden bg-surface-container relative">
                        @if($rel->cover_image)
                            <img src="{{ asset('storage/' . $rel->cover_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-outline-variant">
                                <span class="material-symbols-outlined notranslate" translate="no">image</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <p class="text-[9px] font-black uppercase tracking-widest text-primary mb-2">{{ __t($rel->category->name ?? 'Update') }}</p>
                        <h4 class="font-bold text-on-surface group-hover:text-primary transition-colors leading-snug line-clamp-2">{{ __t($rel->title) }}</h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection
