@extends('layouts.main')

@section('title', 'Portofolio Proyek Digital - ' . ($settings->company_name ?? 'Rakira Digital') . ' | Karya Terbaik Software House Indonesia')
@section('meta_description', 'Galeri portofolio proyek digital terbaik Rakira Digital: website company profile, aplikasi mobile, sistem informasi, dan UI/UX design. Lihat hasil nyata yang telah kami wujudkan untuk klien.')
@section('meta_keywords', 'portofolio software house indonesia, contoh website company profile, contoh aplikasi android ios, proyek web development, karya digital agency, rakira digital portofolio, hasil kerja developer indonesia')

@push('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "CollectionPage",
  "name": "Portofolio Digital Rakira",
  "description": "Galeri karya dan proyek digital terbaik dari Rakira Digital.",
  "url": "{{ url('/portofolio') }}",
  "hasPart": [
    @foreach($portfolios->take(10) as $i => $portfolio)
    {
      "@@type": "CreativeWork",
      "name": "{{ addslashes(strip_tags(__t($portfolio->project_name))) }}",
      "description": "{{ addslashes(Str::limit(strip_tags(__t($portfolio->description ?? '')), 120)) }}",
      "url": "{{ url('/portofolio/' . $portfolio->slug) }}",
      "creator": { "@id": "{{ url('/') }}/#organization" }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endpush

@section('content')
<div class="pt-24 min-h-screen bg-surface">
    {{-- Page Header --}}
    <header class="py-24 px-4 md:px-20 text-center relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-20 pointer-events-none" style="background: radial-gradient(circle at 50% 50%, rgba(0, 159, 227, 0.15) 0%, transparent 70%);"></div>
        <div class="max-w-4xl mx-auto relative z-10" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
            <h1 class="text-4xl md:text-7xl font-black text-on-surface mb-6 tracking-tight leading-tight">
                <span class="inline-block overflow-hidden">
                    <span class="inline-block" x-show="shown" 
                          x-transition:enter="transition ease-out duration-1000" 
                          x-transition:enter-start="translate-y-full opacity-0" 
                          x-transition:enter-end="translate-y-0 opacity-100">{{ __('portfolio.hero_prefix') }}&nbsp;</span>
                </span>
                <span class="inline-block overflow-hidden">
                    <span class="inline-block text-primary" x-show="shown" 
                          x-transition:enter="transition ease-out duration-1000" 
                          x-transition:enter-start="translate-y-full opacity-0" 
                          x-transition:enter-end="translate-y-0 opacity-100"
                          style="transition-delay: 200ms">{{ __('portfolio.hero_highlight') }}&nbsp;</span>
                </span>
                <span class="inline-block overflow-hidden">
                    <span class="inline-block" x-show="shown" 
                          x-transition:enter="transition ease-out duration-1000" 
                          x-transition:enter-start="translate-y-full opacity-0" 
                          x-transition:enter-end="translate-y-0 opacity-100"
                          style="transition-delay: 400ms">{{ __('portfolio.hero_suffix') }}</span>
                </span>
            </h1>
            <p class="text-lg md:text-xl text-on-surface-variant max-w-2xl mx-auto leading-relaxed" 
               x-show="shown" 
               x-transition:enter="transition ease-out duration-1000" 
               x-transition:enter-start="opacity-0 translate-y-4" 
               x-transition:enter-end="opacity-100 translate-y-0"
               style="transition-delay: 800ms">
                {{ __('Mengeksplorasi solusi digital yang inovatif. Berikut adalah portofolio proyek yang telah kami selesaikan dengan teknologi terkini.') }}
            </p>
        </div>
    </header>

    {{-- Portfolio Filter & Grid --}}
    <main class="px-4 md:px-20 pb-32 max-w-7xl mx-auto">
        {{-- Dynamic Category Filters --}}
        <div class="flex flex-wrap justify-center gap-3 mb-16" data-aos="fade-up">
            <button class="filter-btn px-8 py-3 rounded-full bg-primary text-white font-bold shadow-xl shadow-primary/20 transition-all hover:scale-105 active:scale-95" data-filter="all">
                {{ __('Semua Karya') }}
            </button>
            @foreach($categories as $category)
                <button class="filter-btn px-8 py-3 rounded-full bg-white text-on-surface-variant border border-outline-variant/30 font-bold transition-all hover:bg-primary/5 hover:text-primary hover:border-primary/20 active:scale-95" data-filter="{{ __t($category->name) }}">
                    {{ __t($category->name) }}
                </button>
            @endforeach
        </div>

        {{-- Dynamic Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($portfolios as $index => $portfolio)
                <div class="portfolio-item group surface-card overflow-hidden rounded-[2.5rem] bg-white border border-outline-variant/10 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 100 }}"
                     data-category="{{ __t($portfolio->category->name ?? 'Uncategorized') }}">
                    
                    <div class="relative h-72 overflow-hidden">
                        {{-- Memanggil thumbnail_image dari database --}}
                        <img src="{{ $portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800' }}" 
                             alt="{{ __t($portfolio->project_name) }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                            <a href="{{ route('portfolio.show', $portfolio->slug) }}" aria-label="{{ __('Lihat Detail Proyek') }}: {{ __t($portfolio->project_name) }}" class="w-full bg-white text-black py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                {{ __('Lihat Detail Proyek') }}
                                <span class="material-symbols-outlined notranslate text-lg" translate="no">arrow_outward</span>
                            </a>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-primary/5 text-primary text-[10px] uppercase font-black tracking-widest px-3 py-1.5 rounded-lg border border-primary/10">
                                {{ __t($portfolio->category->name ?? 'Uncategorized') }}
                            </span>
                            {{-- Client Name --}}
                            @if($portfolio->client_name)
                                <span class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-black tracking-widest px-3 py-1.5 rounded-lg">
                                    {{ __t($portfolio->client_name) }}
                                </span>
                            @endif
                        </div>
                        {{-- Memanggil project_name --}}
                        <h3 class="text-2xl font-bold text-on-surface mb-3 group-hover:text-primary transition-colors leading-snug">
                            {{ __t($portfolio->project_name) }}
                        </h3>
                        <p class="text-on-surface-variant text-sm line-clamp-2 leading-relaxed italic">
                            {{ __t($portfolio->description) }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center" data-aos="zoom-in">
                    <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-6 text-outline-variant">
                        <span class="material-symbols-outlined notranslate text-5xl" translate="no">folder_open</span>
                    </div>
                    <h3 class="text-2xl font-bold text-on-surface mb-2">{{ __('Belum ada portofolio') }}</h3>
                    <p class="text-on-surface-variant max-w-sm mx-auto">{{ __('Kami sedang mempersiapkan daftar karya terbaik untuk ditampilkan di sini.') }}</p>
                </div>
            @endforelse
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.portfolio-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => {
                    b.classList.remove('bg-primary', 'text-white', 'shadow-xl', 'shadow-primary/20');
                    b.classList.add('bg-white', 'text-on-surface-variant', 'border', 'border-outline-variant/30');
                });
                this.classList.remove('bg-white', 'text-on-surface-variant', 'border', 'border-outline-variant/30');
                this.classList.add('bg-primary', 'text-white', 'shadow-xl', 'shadow-primary/20');

                const filter = this.getAttribute('data-filter');

                items.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.classList.remove('hidden');
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            item.classList.add('hidden');
                        }, 300);
                    }
                });
            });
        });
    });
</script>
@endsection