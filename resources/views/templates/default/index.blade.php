@extends('templates.default.layout')

@section('title', 'Rakira Digital Nusantara | Solusi Digital Inovatif')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .testimonial-swiper .swiper-pagination-bullet-active {
        background: #009fe3 !important;
        width: 24px;
        border-radius: 4px;
    }
    .testimonial-swiper .swiper-pagination {
        bottom: 0 !important;
    }
    .testimonial-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .testimonial-card:hover {
        background-color: #009fe3 !important;
        transform: translateY(-8px);
    }
    .testimonial-card:hover p, 
    .testimonial-card:hover span:not(.material-symbols-outlined) {
        color: rgba(255, 255, 255, 0.9) !important;
    }
    .testimonial-card:hover .text-on-surface,
    .testimonial-card:hover .font-bold {
        color: #ffffff !important;
    }
    .testimonial-card:hover .text-primary {
        color: #ffffff !important;
    }
    .testimonial-card:hover .material-symbols-outlined {
        color: #ffffff !important;
    }
    .testimonial-card:hover .border-t {
        border-color: rgba(255, 255, 255, 0.2) !important;
    }
    .default-hero {
        background: linear-gradient(135deg, #00324b 0%, #006491 50%, #009fe3 100%) !important;
    }
</style>
@endpush

@section('content')
{{-- ═══════════════════════════════════════════════
    HERO SECTION
═══════════════════════════════════════════════ --}}
<section class="page-hero default-hero relative min-h-[90vh] flex items-center bg-animated-gradient overflow-hidden" data-hero-parallax>
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl" data-float></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-white/5 rounded-full blur-3xl" data-float style="animation-delay: 3s"></div>
        <div class="bg-grid-pattern absolute inset-0 opacity-[0.04]"></div>
    </div>
    
    <div class="content-container grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center relative z-10">
        {{-- Text --}}
        <div class="flex flex-col gap-6 text-white text-center lg:text-left" 
             x-data="{ 
                text1: '', 
                fullText1: 'Solusi Digital ',
                showInovatif: false,
                text2: '',
                fullText2: ' untuk Pertumbuhan Bisnis Anda',
                init() {
                    let i = 0;
                    let timer1 = setInterval(() => {
                        this.text1 += this.fullText1.charAt(i);
                        i++;
                        if (i >= this.fullText1.length) {
                            clearInterval(timer1);
                            this.showInovatif = true;
                            setTimeout(() => {
                                let j = 0;
                                let timer2 = setInterval(() => {
                                    this.text2 += this.fullText2.charAt(j);
                                    j++;
                                    if (j >= this.fullText2.length) clearInterval(timer2);
                                }, 50);
                            }, 500);
                        }
                    }, 80);
                }
             }">
            <span class="section-kicker !border-white/20 !bg-white/10 !text-white self-center lg:self-start transition-all duration-700"
                  x-show="text1.length > 0" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                Rakira Digital Nusantara
            </span>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.1] tracking-tight min-h-[2.2em]">
                <span x-text="text1"></span><template x-if="showInovatif"><span class="text-[#8aceff]" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">Inovatif</span></template><span x-text="text2"></span><span class="animate-pulse text-[#8aceff]" x-show="text2.length < fullText2.length">|</span>
            </h1>

            <p class="text-base md:text-lg text-white/85 max-w-xl mx-auto lg:mx-0 leading-relaxed transition-all duration-1000"
               x-show="text2.length === fullText2.length" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                Transformasi digital bukan lagi pilihan, tapi keharusan. Rakira Digital Nusantara hadir sebagai mitra strategis untuk membangun ekosistem digital yang scalable.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                <a href="#kontak" class="w-full sm:w-auto px-8 py-4 bg-white text-primary font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center">
                    Konsultasi Gratis
                </a>
                <a href="/portofolio" class="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-white/25 text-white font-bold rounded-xl hover:bg-white/10 hover:border-white/50 transition-all duration-300 text-center flex items-center justify-center gap-2">
                    Lihat Portofolio
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>
        
        {{-- Visual --}}
        <div class="relative hidden lg:block h-[480px] w-full" data-aos data-aos-delay="200">
            <div class="absolute inset-0 rounded-3xl border border-white/10 shadow-2xl p-4 overflow-hidden backdrop-blur-sm bg-white/5">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=2426" alt="Dashboard Preview" class="w-full h-full object-cover rounded-2xl opacity-80">
            </div>
            {{-- Floating stat --}}
            <div class="absolute -left-8 bottom-16 glass-panel !bg-white/10 !border-white/20 p-4 rounded-xl shadow-2xl" data-float>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-success/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-success text-[20px]">trending_up</span>
                    </div>
                    <div>
                        <p class="text-white/60 text-xs font-semibold">Kinerja Sistem</p>
                        <p class="text-white font-bold text-sm">+99.9% Uptime</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    CLIENT TRUST STRIP (Dual-Layer Infinite Marquee)
═══════════════════════════════════════════════ --}}
@if($client_logos->isNotEmpty())
<section class="page-section !py-20 bg-white border-b border-slate-50 overflow-hidden relative" data-aos>
    <div class="content-container mb-8">
        <p class="text-center text-slate-400 text-[10px] font-black uppercase tracking-[0.4em]">Dipercaya Oleh Berbagai Industri</p>
    </div>

    @php
        $totalLogos = $client_logos->count();
    @endphp

    @if($totalLogos <= 4)
        {{-- Statis di tengah jika logo sedikit --}}
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 pt-8 pb-4 px-4">
            @foreach ($client_logos as $client)
                <div class="group relative h-12 md:h-16 flex-shrink-0 flex items-center cursor-pointer">
                    @if($client->company_logo)
                        <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                             class="h-full w-auto object-contain transition-all duration-500 group-hover:scale-110 grayscale hover:grayscale-0">
                    @else
                        <span class="text-slate-400 font-black text-xl tracking-tighter transition-all duration-500 group-hover:text-slate-900">{{ $client->company_name }}</span>
                    @endif
                    
                    {{-- Tooltip Nama --}}
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-2xl z-50">
                        {{ $client->company_name }}
                        <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-slate-900 rotate-45"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif($totalLogos <= 8)
        {{-- Satu Baris Marquee jika logo sedang --}}
        <div class="marquee-wrapper relative flex pt-16 pb-4">
            <div class="marquee-track flex gap-16 items-center">
                @php 
                    $displayRow = $client_logos->concat($client_logos)->concat($client_logos)->concat($client_logos); 
                @endphp
                @foreach ($displayRow as $client)
                    <div class="marquee-item group relative h-12 md:h-16 flex-shrink-0 flex items-center px-4 cursor-pointer">
                        @if($client->company_logo)
                            <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                                 class="h-full w-auto object-contain transition-all duration-500 group-hover:scale-110">
                        @else
                            <span class="text-slate-900 font-black text-xl tracking-tighter">{{ $client->company_name }}</span>
                        @endif
                        
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-2xl z-50">
                            {{ $client->company_name }}
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-slate-900 rotate-45"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        {{-- Dua Baris Marquee jika logo sangat banyak --}}
        <div class="marquee-wrapper relative flex pt-16 pb-4">
            <div class="marquee-track flex gap-16 items-center">
                @php 
                    $row1 = $client_logos->split(2)->first() ?? collect(); 
                    $displayRow1 = $row1->concat($row1)->concat($row1)->concat($row1); 
                @endphp
                @foreach ($displayRow1 as $client)
                    <div class="marquee-item group relative h-12 md:h-16 flex-shrink-0 flex items-center px-4 cursor-pointer">
                        @if($client->company_logo)
                            <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                                 class="h-full w-auto object-contain transition-all duration-500 group-hover:scale-110">
                        @else
                            <span class="text-slate-900 font-black text-xl tracking-tighter">{{ $client->company_name }}</span>
                        @endif
                        
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-2xl z-50">
                            {{ $client->company_name }}
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-slate-900 rotate-45"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="marquee-wrapper relative flex pt-16 pb-4">
            <div class="marquee-track-reverse flex gap-16 items-center">
                @php 
                    $row2 = $client_logos->split(2)[1] ?? collect(); 
                    $displayRow2 = $row2->concat($row2)->concat($row2)->concat($row2);
                @endphp
                @foreach ($displayRow2 as $client)
                    <div class="marquee-item group relative h-12 md:h-16 flex-shrink-0 flex items-center px-4 cursor-pointer">
                        @if($client->company_logo)
                            <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                                 class="h-full w-auto object-contain transition-all duration-500 group-hover:scale-110">
                        @else
                            <span class="text-slate-900 font-black text-xl tracking-tighter">{{ $client->company_name }}</span>
                        @endif

                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 scale-50 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-2xl z-50">
                            {{ $client->company_name }}
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-slate-900 rotate-45"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Gradient Overlays --}}
    <div class="absolute inset-y-0 left-0 w-40 bg-gradient-to-r from-white via-white/80 to-transparent z-20 pointer-events-none"></div>
    <div class="absolute inset-y-0 right-0 w-40 bg-gradient-to-l from-white via-white/80 to-transparent z-20 pointer-events-none"></div>
</section>
@endif

<style>
    .marquee-wrapper {
        width: 100%;
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }

    .marquee-track {
        display: flex;
        width: max-content;
        animation: scroll-left 60s linear infinite;
    }

    .marquee-track-reverse {
        display: flex;
        width: max-content;
        animation: scroll-right 60s linear infinite;
    }

    @keyframes scroll-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    @keyframes scroll-right {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }

    .marquee-wrapper:hover .marquee-track,
    .marquee-wrapper:hover .marquee-track-reverse {
        animation-play-state: paused;
    }
</style>

{{-- ═══════════════════════════════════════════════
    TENTANG KAMI
═══════════════════════════════════════════════ --}}
<section class="page-section bg-white">
    <div class="content-container grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        <div class="space-y-6" data-aos>
            <span class="section-kicker">Tentang Rakira Digital</span>
            <h2 class="section-title">Arsitek Ekosistem Digital Masa Depan</h2>
            <p class="section-subtitle">
                {{ $settings->about_us ?? 'Rakira Digital Nusantara adalah software house premium yang berdedikasi untuk memberikan solusi teknologi end-to-end. Kami menggabungkan keahlian teknis mendalam dengan pemahaman bisnis strategis.' }}
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div class="surface-card p-6 rounded-2xl hover:shadow-2xl transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center mb-4 text-primary">
                        <span class="material-symbols-outlined">visibility</span>
                    </div>
                    <h4 class="text-lg font-bold mb-1">Visi</h4>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        {!! nl2br(e($settings->vision ?? 'Menjadi katalisator utama transformasi digital bagi perusahaan.')) !!}
                    </p>
                </div>
                <div class="surface-card p-6 rounded-2xl hover:shadow-2xl transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-primary-container/10 flex items-center justify-center mb-4 text-primary-container">
                        <span class="material-symbols-outlined">flag</span>
                    </div>
                    <h4 class="text-lg font-bold mb-1">Misi</h4>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        {!! nl2br(e($settings->mission ?? 'Memberikan solusi software yang scalable dan aman.')) !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="relative h-[420px] md:h-[500px] rounded-3xl overflow-hidden shadow-2xl" data-aos data-aos-delay="150">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2070" alt="Tim Rakira Digital" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#171c20]/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <div class="glass-panel p-5 rounded-xl">
                    <p class="text-xl font-bold text-on-surface">50+ Proyek Sukses</p>
                    <p class="text-on-surface-variant text-sm">Diselesaikan dengan tingkat kepuasan tinggi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    LAYANAN — INTERACTIVE CARDS (bento grid + selectable → ubah warna)
═══════════════════════════════════════════════ --}}
<section class="page-section bg-background">
    <div class="content-container">
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-14" data-aos>
            <span class="section-kicker">{{ __('Layanan Rakira Digital') }}</span>
            <h2 class="section-title">{{ __('Solusi Bisnis untuk Anda') }}</h2>
            <p class="section-subtitle mx-auto">{{ __('Klik layanan untuk melihat detail dan langsung chat via WhatsApp.') }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $index => $service)
            <a 
                href="{{ route('services.show', $service->slug) }}"
                aria-label="{{ __('Detail Layanan') }}: {{ __t($service->title) }}"
                class="interactive-card {{ $loop->first ? 'lg:col-span-2' : '' }} group"
                data-aos data-aos-delay="{{ $index * 100 }}"
            >
                <div class="interactive-card-icon w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-5 transition-colors">
                    <span class="material-symbols-outlined text-3xl">{{ $service->icon_image ?: 'settings' }}</span>
                </div>
                <h3 class="interactive-card-title text-xl font-bold text-on-surface mb-2 transition-colors">{{ __t($service->title) }}</h3>
                <p class="interactive-card-description text-on-surface-variant text-sm transition-colors">{{ __t($service->short_description) }}</p>
                
                <div class="mt-6 flex items-center text-primary font-bold text-sm group-hover:text-white transition-colors">
                    {{ __('Lihat Detail') }}
                    <span class="material-symbols-outlined ml-2 text-sm">arrow_forward</span>
                </div>
            </a>
            @empty
            <div class="col-span-full py-12 text-center text-on-surface-variant">
                <p>{{ __('Layanan belum tersedia.') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    TESTIMONIAL CLIENTS (Dinamis dari Admin)
═══════════════════════════════════════════════ --}}
<section class="page-section bg-white">
    <div class="content-container">
        @if($clients->isNotEmpty())
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-14" data-aos>
            <span class="section-kicker">{{ __('Kata Mereka') }}</span>
            <h2 class="section-title">{{ __('Testimoni Klien Rakira Digital') }}</h2>
        </div>
        {{-- Testimonial Slider --}}
        <div class="relative px-4 md:px-10">
            <div class="swiper testimonial-swiper pb-16">
                <div class="swiper-wrapper">
                    @foreach($clients as $index => $client)
                    <div class="swiper-slide h-auto">
                        <div class="surface-card p-8 rounded-[2.5rem] border border-slate-100 shadow-sm testimonial-card group">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-bold text-lg shadow-lg group-hover:bg-white group-hover:text-primary transition-colors">
                                    {{ $client['initial'] }}
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface transition-colors">{{ __t($client['name']) }}</p>
                                    <p class="text-[10px] text-on-surface-variant uppercase font-black tracking-widest transition-colors">{{ __t($client['company']) }}</p>
                                </div>
                            </div>

                            <div class="flex text-amber-400 mb-4 transition-colors">
                                @for($i=0; $i<($client['rating'] ?? 5); $i++)
                                    <span class="material-symbols-outlined text-[16px] fill-1 transition-colors">star</span>
                                @endfor
                            </div>

                            <p class="text-on-surface-variant text-sm leading-relaxed italic flex-1 transition-colors">"{{ __t($client['testimonial']) }}"</p>
                            
                            <div class="mt-6 pt-6 border-t border-slate-50 transition-colors">
                                <span class="text-[10px] font-black uppercase tracking-widest text-primary transition-colors">{{ __('Verified Client') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="swiper-pagination"></div>
            </div>

            {{-- Custom Navigation --}}
            <button aria-label="Slide Testimoni Sebelumnya" class="swiper-prev absolute left-0 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border border-slate-100 shadow-xl z-20 flex items-center justify-center text-slate-400 hover:text-primary transition-all active:scale-90">
                <span class="material-symbols-outlined">arrow_back</span>
            </button>
            <button aria-label="Slide Testimoni Selanjutnya" class="swiper-next absolute right-0 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white border border-slate-100 shadow-xl z-20 flex items-center justify-center text-slate-400 hover:text-primary transition-all active:scale-90">
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>

        @endif

        {{-- Review Form (Integrated) --}}
        <div class="{{ $clients->isNotEmpty() ? 'mt-20' : '' }} max-w-4xl mx-auto">
            <div class="glass-panel p-8 md:p-12 rounded-[2.5rem] shadow-2xl relative overflow-hidden" data-aos="fade-up">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-secondary"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-center">
                    <div class="lg:col-span-2 space-y-4">
                        <h3 class="text-2xl font-black text-on-surface">{{ __('Berikan Ulasan Anda') }}</h3>
                        <p class="text-on-surface-variant text-sm leading-relaxed">
                            {{ __('Punya pengalaman bekerja dengan kami? Bagikan ulasan Anda di sini untuk membantu kami terus berkembang.') }}
                        </p>
                        <div class="flex items-center gap-2 text-primary font-bold text-sm pt-4">
                            <span class="material-symbols-outlined">verified</span>
                            {{ __('Moderasi Admin Aktif') }}
                        </div>
                    </div>

                    <div class="lg:col-span-3">
                        @if(session('success_review'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl text-sm font-semibold flex items-center gap-3 animate-bounce">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('success_review') }}
                        </div>
                        @endif

                        <form action="{{ route('review.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="text" name="name" required placeholder="{{ __('Nama Lengkap *') }}" 
                                    class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">
                                <input type="text" name="company" placeholder="{{ __('Instansi/Perusahaan') }}" 
                                    class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">
                            </div>
                            
                            <div x-data="{ rating: 5, hover: 0 }">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-on-surface-variant mb-2 pl-1">{{ __('Penilaian Anda') }}</label>
                                <div class="flex gap-2">
                                    <input type="hidden" name="rating" :value="rating">
                                    @for($i=1; $i<=5; $i++)
                                    <button type="button" 
                                        @click="rating = {{ $i }}" 
                                        @mouseenter="hover = {{ $i }}" 
                                        @mouseleave="hover = 0"
                                        aria-label="Bintang {{ $i }}"
                                        class="cursor-pointer transition-transform hover:scale-110 active:scale-95 outline-none focus:outline-none">
                                        <span class="material-symbols-outlined text-4xl transition-colors duration-200"
                                            :class="(hover || rating) >= {{ $i }} ? 'text-amber-400 fill-1' : 'text-slate-300'">
                                            star
                                        </span>
                                    </button>
                                    @endfor
                                </div>
                            </div>

                            <textarea name="comment" required rows="3" placeholder="{{ __('Tuliskan ulasan Anda di sini... *') }}"
                                class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all resize-none"></textarea>

                            <button type="submit" class="btn-primary w-full !py-4 shadow-xl">
                                <span class="material-symbols-outlined">send</span>
                                {{ __('Kirim Ulasan') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($faqs->isNotEmpty())
{{-- ═══════════════════════════════════════════════
    FAQ (Dinamis dari Admin)
|--------------------------------------------------------------------------
--}}
<section class="page-section bg-background">
    <div class="content-container max-w-3xl">
        <div class="text-center space-y-3 mb-14" data-aos>
            <span class="section-kicker">F.A.Q</span>
            <h2 class="section-title">{{ __('Pertanyaan Umum') }}</h2>
            <p class="section-subtitle mx-auto">{{ __('Pertanyaan yang sering ditanyakan tentang layanan Rakira Digital.') }}</p>
        </div>

        <div class="space-y-4">
            @foreach($faqs as $index => $faq)
            @php
                $faqQuestion = __t(is_array($faq)
                    ? ($faq['question'] ?? $faq['title'] ?? '')
                    : (is_object($faq)
                        ? ($faq->question ?? $faq->title ?? '')
                        : ''));

                $faqAnswer = __t(is_array($faq)
                    ? ($faq['answer'] ?? '')
                    : (is_object($faq)
                        ? ($faq->answer ?? '')
                        : ''));
            @endphp
            <details class="faq-item group" data-aos data-aos-delay="{{ (int) $index * 80 }}">
                <summary class="flex items-center justify-between cursor-pointer px-6 py-5 md:px-8 md:py-6 select-none list-none">
                    <span class="font-bold text-on-surface group-open:text-white transition-colors pr-4">{{ $faqQuestion }}</span>
                    <span class="material-symbols-outlined faq-icon text-on-surface-variant group-open:text-white transition-all duration-300 flex-shrink-0">add</span>
                </summary>
                <div class="faq-answer px-6 pb-6 md:px-8 md:pb-8 text-on-surface-variant text-sm leading-relaxed transition-colors">
                    {{ $faqAnswer }}
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>
@endif



{{-- ═══════════════════════════════════════════════
    FORM KONSULTASI
═══════════════════════════════════════════════ --}}
<section class="page-section bg-white" id="kontak">
    <div class="content-container grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
        {{-- Info --}}
        <div class="space-y-6" data-aos>
            <span class="section-kicker">Konsultasi Gratis</span>
            <h2 class="section-title">Mulai Proyek Digital Anda Sekarang</h2>
            <p class="section-subtitle">
                Isi formulir di samping dan tim Rakira Digital akan menghubungi Anda dalam waktu 1×24 jam untuk membahas kebutuhan proyek Anda.
            </p>
            <div class="space-y-5 pt-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">Respons Cepat</p>
                        <p class="text-on-surface-variant text-sm">Balasan dalam 1×24 jam kerja</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-success/10 flex items-center justify-center text-success flex-shrink-0">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">Konsultasi Tanpa Biaya</p>
                        <p class="text-on-surface-variant text-sm">Diskusi awal 100% gratis</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-container/10 flex items-center justify-center text-primary-container flex-shrink-0">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">Data Aman</p>
                        <p class="text-on-surface-variant text-sm">Informasi Anda dijaga kerahasiaannya</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div data-aos data-aos-delay="150">
            {{-- Success message --}}
            @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-sm font-semibold text-green-700">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('konsultasi.store') }}" method="POST" class="surface-card rounded-3xl p-6 md:p-8 space-y-5">
                @csrf
                {{-- Nama --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-2" for="sender_name">Nama Lengkap *</label>
                    <input type="text" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" required
                        class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm transition-all focus:border-primary focus:ring-4 focus:ring-primary/10"
                        placeholder="Nama lengkap Anda">
                    @error('sender_name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-2" for="sender_email">Email Aktif *</label>
                    <input type="email" id="sender_email" name="sender_email" value="{{ old('sender_email') }}" required
                        class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm transition-all focus:border-primary focus:ring-4 focus:ring-primary/10"
                        placeholder="email@anda.com">
                    @error('sender_email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-2" for="phone">No. WhatsApp *</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm transition-all focus:border-primary focus:ring-4 focus:ring-primary/10"
                        placeholder="08xx-xxxx-xxxx">
                    @error('phone') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Layanan --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-2" for="service">Layanan yang Dibutuhkan *</label>
                    <select id="service" name="service" required
                        class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm transition-all focus:border-primary focus:ring-4 focus:ring-primary/10 bg-white">
                        <option value="">-- {{ __('Pilih Layanan') }} --</option>
                        @foreach($services as $srv)
                            @php
                                $srvTitle = __t(is_array($srv) ? ($srv['title'] ?? '') : ($srv->title ?? ''));
                            @endphp
                            @if($srvTitle)
                                <option value="{{ $srvTitle }}" {{ old('service') == $srvTitle ? 'selected' : '' }}>{{ $srvTitle }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('service') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Pesan --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface mb-2" for="message_body">Pesan Tambahan <span class="font-normal text-on-surface-variant">(opsional)</span></label>
                    <textarea id="message_body" name="message_body" rows="3"
                        class="w-full rounded-xl border border-outline-variant/50 px-4 py-3 text-sm transition-all focus:border-primary focus:ring-4 focus:ring-primary/10 resize-none"
                        placeholder="Ceritakan sedikit tentang proyek Anda...">{{ old('message_body') }}</textarea>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full !py-4 !text-base shadow-lg">
                    <span class="material-symbols-outlined">send</span>
                    Kirim Konsultasi
                </button>
            </form>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    CTA
═══════════════════════════════════════════════ --}}
<section class="page-section bg-background">
    <div class="content-container max-w-5xl">
        <div class="bg-gradient-to-br from-[#006491] to-[#009fe3] rounded-3xl p-10 md:p-16 text-center text-white shadow-2xl relative overflow-hidden" data-aos>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-bold mb-5">Siap Mewujudkan Ide Digital Anda?</h2>
                <p class="text-base md:text-lg text-white/85 max-w-2xl mx-auto mb-8 leading-relaxed">
                    Jangan biarkan bisnis Anda tertinggal. Jadwalkan sesi konsultasi gratis dengan tim expert Rakira Digital hari ini.
                </p>
                <a href="{{ $whatsAppUrl ?? '#kontak' }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-primary font-bold px-8 py-4 rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300">
                    Mulai Proyek Sekarang
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.testimonial-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    });
</script>
@endpush
