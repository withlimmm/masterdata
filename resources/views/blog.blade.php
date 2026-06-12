@extends('layouts.main')

@section('title', 'Blog & Wawasan Digital - ' . ($settings->company_name ?? 'Rakira Digital') . ' | Tips Teknologi & Bisnis')
@section('meta_description', 'Baca artikel dan tips terbaru seputar web development, aplikasi mobile, transformasi digital, dan strategi bisnis teknologi dari tim ahli Rakira Digital.')
@section('meta_keywords', 'blog teknologi indonesia, tips pembuatan website, cara memilih software house, tren aplikasi mobile 2026, digital marketing bisnis, rakira digital blog, web development tutorial')

@push('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Blog",
  "name": "Blog Rakira Digital",
  "description": "Wawasan teknologi, tips bisnis, dan update tren digital dari Rakira Digital.",
  "url": "{{ url('/blog') }}",
  "publisher": { "@id": "{{ url('/') }}/#organization" },
  "blogPost": [
    @foreach($articles->take(5) as $i => $article)
    {
      "@@type": "BlogPosting",
      "headline": "{{ addslashes(strip_tags(__t($article->title))) }}",
      "url": "{{ url('/blog/' . $article->slug) }}",
      "datePublished": "{{ ($article->published_at ?? $article->created_at)->toIso8601String() }}",
      "author": { "@@type": "Person", "name": "{{ $article->author->name ?? 'Tim Rakira' }}" }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endpush

@section('content')
<div class="pt-24 min-h-screen bg-surface">
    <!-- Hero Section -->
    <header class="py-24 px-4 md:px-20 text-center relative overflow-hidden" data-aos="fade-down">
        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none" style="background: radial-gradient(circle at 50% 50%, rgba(0, 159, 227, 0.15) 0%, transparent 70%);"></div>
        <div class="max-w-4xl mx-auto relative z-10" 
             x-data="{ 
                text: '', 
                fullText: '{{ __('Eksplorasi Dunia') }} ',
                typingDone: false,
                init() {
                    let i = 0;
                    let timer = setInterval(() => {
                        this.text += this.fullText.charAt(i);
                        i++;
                        if (i >= this.fullText.length) {
                            clearInterval(timer);
                            this.typingDone = true;
                        }
                    }, 80);
                }
             }">
            <span class="text-primary font-black uppercase tracking-widest text-xs mb-6 inline-block">{{ __('Wawasan & Berita') }}</span>
            
            <h1 class="text-4xl md:text-7xl font-black text-on-surface mb-6 tracking-tight leading-tight min-h-[1.2em]">
                <span x-text="text"></span><template x-if="typingDone"><span class="text-primary" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">{{ __('Digital') }}</span></template><span class="animate-ping text-primary" x-show="!typingDone">|</span>
            </h1>

            <p class="text-lg md:text-xl text-on-surface-variant max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="1500">
                {{ __('Temukan strategi terbaru, tren industri, dan panduan teknis untuk membantu bisnis Anda tumbuh lebih pesat.') }}
            </p>
        </div>
    </header>

    <main class="px-4 md:px-20 pb-32 max-w-7xl mx-auto">
        <!-- Search & Filters -->
        <div class="flex flex-wrap justify-center gap-3 mb-16" data-aos="fade-up">
            <a href="{{ route('blog') }}" class="px-8 py-3 rounded-full font-bold transition-all {{ !request('category') ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20 hover:scale-105' : 'bg-white text-slate-600 border border-slate-300 hover:bg-slate-100 hover:text-slate-900 hover:border-slate-400' }}" {!! !request('category') ? 'style="background-color: #0f172a !important; color: white !important; border: none !important;"' : 'style="background-color: white !important; color: #475569 !important; border: 1px solid #cbd5e1 !important;"' !!}>
                {{ __('Semua') }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog', ['category' => $cat->slug]) }}" 
                   class="px-8 py-3 rounded-full font-bold transition-all {{ request('category') == $cat->slug ? 'bg-slate-900 text-white shadow-xl shadow-slate-900/20 hover:scale-105' : 'bg-white text-slate-600 border border-slate-300 hover:bg-slate-100 hover:text-slate-900 hover:border-slate-400' }}" {!! request('category') == $cat->slug ? 'style="background-color: #0f172a !important; color: white !important; border: none !important;"' : 'style="background-color: white !important; color: #475569 !important; border: 1px solid #cbd5e1 !important;"' !!}>
                    {{ __t($cat->name) }}
                </a>
            @endforeach
        </div>

        <!-- Blog Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($articles as $index => $article)
                <article class="group surface-card overflow-hidden rounded-[2.5rem] bg-white border border-outline-variant/10 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    {{-- Image --}}
                    <div class="relative h-72 overflow-hidden bg-surface-container">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ __t($article->title) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-outline-variant">
                                <span class="material-symbols-outlined notranslate text-6xl" translate="no">image</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                            <a href="{{ route('blog.show', $article->slug) }}" aria-label="{{ __('Baca Artikel') }}: {{ __t($article->title) }}" class="w-full bg-white text-black py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                {{ __('Baca Artikel') }}
                                <span class="material-symbols-outlined notranslate text-lg" translate="no">arrow_outward</span>
                            </a>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-primary/5 text-primary text-[10px] uppercase font-black tracking-widest px-3 py-1.5 rounded-lg border border-primary/10">
                                {{ __t($article->category->name ?? 'Update') }}
                            </span>
                            <span class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-black tracking-widest px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                                <span class="material-symbols-outlined notranslate text-[14px]" translate="no">calendar_today</span>
                                {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                            </span>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-on-surface mb-3 line-clamp-2 leading-snug group-hover:text-primary transition-colors">
                            {{ __t($article->title) }}
                        </h2>
                        
                        <p class="text-on-surface-variant text-sm mb-8 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags(__t($article->content)), 120) }}
                        </p>
                        
                        <div class="mt-auto flex items-center gap-2 pt-6 border-t border-outline-variant/10">
                            <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant font-black text-[10px]">
                                {{ strtoupper(substr($article->author->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-on-surface">{{ $article->author->name ?? 'Tim Rakira' }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-32 text-center" data-aos="zoom-in">
                    <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-6 text-outline-variant">
                        <span class="material-symbols-outlined notranslate text-5xl" translate="no">history_edu</span>
                    </div>
                    <h3 class="text-2xl font-bold text-on-surface mb-2">{{ __('Belum ada artikel') }}</h3>
                    <p class="text-on-surface-variant max-w-sm mx-auto">{{ __('Belum ada artikel yang diterbitkan untuk kategori ini.') }}</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
