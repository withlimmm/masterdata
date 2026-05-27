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
<div class="pt-24 pb-section-padding min-h-screen bg-slate-50/50">
    <!-- Hero Section -->
    <section class="page-hero bg-transparent text-center" data-aos="fade-down">
        <div class="content-container max-w-4xl pt-16" 
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
            <span class="section-kicker mx-auto mb-6">{{ __('Wawasan & Berita') }}</span>
            
            <h1 class="mb-6 text-4xl font-black leading-[1.05] tracking-tight text-slate-900 sm:text-5xl lg:text-7xl min-h-[1.2em]">
                <span x-text="text"></span><template x-if="typingDone"><span class="text-primary" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">{{ __('Digital') }}</span></template><span class="animate-ping text-primary" x-show="!typingDone">|</span>
            </h1>

            <p class="section-subtitle mx-auto text-center max-w-2xl text-slate-500" data-aos="fade-up" data-aos-delay="1500">
                {{ __('Temukan strategi terbaru, tren industri, dan panduan teknis untuk membantu bisnis Anda tumbuh lebih pesat.') }}
            </p>
        </div>
    </section>

    <!-- Search & Filters -->
    <section class="page-section pt-8" data-aos="fade-up">
        <div class="content-container mb-12">
            <div class="flex flex-col items-center justify-center gap-6">
                <!-- Categories -->
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="{{ route('blog') }}" class="rounded-full px-6 py-2.5 text-xs font-black uppercase tracking-widest transition-all {{ !request('category') ? 'bg-slate-900 text-white shadow-xl' : 'bg-white border border-slate-200 text-slate-400 hover:border-primary hover:text-primary' }}">
                        {{ __('Semua') }}
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('blog', ['category' => $cat->slug]) }}" 
                           class="rounded-full px-6 py-2.5 text-xs font-black uppercase tracking-widest transition-all {{ request('category') == $cat->slug ? 'bg-slate-900 text-white shadow-xl' : 'bg-white border border-slate-200 text-slate-400 hover:border-primary hover:text-primary' }}">
                            {{ __t($cat->name) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Grid -->
    <section class="page-section pt-0">
        <div class="content-container grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
            @forelse($articles as $index => $article)
                <article class="group relative flex h-full flex-col overflow-hidden rounded-[2.5rem] bg-white border border-slate-100 transition-all hover:shadow-2xl hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    {{-- Category Badge --}}
                    <div class="absolute top-6 left-6 z-20">
                        <span class="bg-white/90 backdrop-blur-md text-slate-900 text-[9px] font-black uppercase tracking-[0.2em] px-4 py-2 rounded-full shadow-sm border border-white/20">
                            {{ __t($article->category->name ?? 'Update') }}
                        </span>
                    </div>

                    {{-- Image --}}
                    <div class="aspect-[16/10] relative overflow-hidden bg-slate-100">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ __t($article->title) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200">
                                <span class="material-symbols-outlined notranslate text-6xl" translate="no">image</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-3 mb-4 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined notranslate text-[14px]" translate="no">calendar_today</span>
                                {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined notranslate text-[14px]" translate="no">person</span>
                                {{ $article->author->name ?? 'Admin' }}
                            </span>
                        </div>
                        
                        <h2 class="text-xl font-bold text-slate-900 mb-4 line-clamp-2 leading-snug group-hover:text-primary transition-colors">
                            {{ __t($article->title) }}
                        </h2>
                        
                        <p class="text-slate-500 text-sm mb-8 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags(__t($article->content)), 120) }}
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-slate-50">
                            <a href="{{ route('blog.show', $article->slug) }}" aria-label="{{ __('Baca Artikel') }}: {{ __t($article->title) }}" class="inline-flex items-center gap-2 text-slate-900 font-black text-[10px] uppercase tracking-[0.2em] group/btn">
                                {{ __('Baca Artikel') }} 
                                <span class="material-symbols-outlined notranslate text-[18px] group-hover/btn:translate-x-2 transition-transform" translate="no">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-24 text-center">
                    <div class="flex flex-col items-center gap-4 opacity-30">
                        <span class="material-symbols-outlined notranslate text-7xl" translate="no">history_edu</span>
                        <p class="text-xs font-black uppercase tracking-[0.3em]">{{ __('Belum ada artikel yang diterbitkan') }}</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
