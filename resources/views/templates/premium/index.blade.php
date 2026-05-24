@extends('templates.premium.layout')

@section('title', 'Rakira Digital | Solusi Digital Premium Masa Depan')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Swiper customized pagination and elements */
    .premium-swiper .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.2) !important;
        opacity: 1;
    }
    .premium-swiper .swiper-pagination-bullet-active {
        background: #3b82f6 !important; /* Blue-500 */
        width: 28px;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.6);
    }
    .premium-swiper .swiper-pagination {
        bottom: 0 !important;
    }
    /* Premium timeline */
    .timeline-item {
        position: relative;
        padding-left: 2.5rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: rgba(255, 255, 255, 0.05);
    }
    .timeline-item:last-child::before {
        display: none;
    }
    .timeline-dot {
        position: absolute;
        left: 0;
        top: 6px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #030712;
        border: 3px solid #3b82f6;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.8);
    }
    
    /* Direct style overrides for premium dark theme */
    body {
        background-color: #030712 !important;
        background: #030712 !important;
        color: #f3f4f6 !important;
    }
    
    /* Sections background force */
    section {
        background-color: transparent !important;
    }
    
    .premium-hero-section {
        background: radial-gradient(circle at 80% 20%, rgba(37, 99, 235, 0.15), transparent 50%), 
                    radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.1), transparent 50%),
                    #030712 !important;
    }
    
    /* Bento and standard cards styling override */
    .premium-glass-card {
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 1.5rem !important;
        color: #e2e8f0 !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .premium-glass-card:hover {
        background: rgba(30, 41, 59, 0.75) !important;
        border-color: rgba(59, 130, 246, 0.4) !important;
        box-shadow: 0 20px 40px -15px rgba(59, 130, 246, 0.3) !important;
        transform: translateY(-4px) !important;
    }

    /* Override tailwind default bg-white for cards */
    .surface-card, .interactive-card, .faq-item, .glass-panel {
        background: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: #e2e8f0 !important;
    }
    
    .interactive-card:hover {
        background: rgba(30, 41, 59, 0.85) !important;
        border-color: rgba(59, 130, 246, 0.4) !important;
        color: #ffffff !important;
    }
    
    /* Text overrides */
    h1, h2, h3, h4, h5, h6, .section-title {
        color: #ffffff !important;
    }
    
    .text-on-surface, .text-on-surface-variant, .text-slate-900, .text-slate-700 {
        color: #cbd5e1 !important;
    }
    
    .section-subtitle, .text-slate-400 {
        color: #94a3b8 !important;
    }
    
    /* Inputs overrides */
    input, select, textarea {
        background-color: rgba(15, 23, 42, 0.9) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
    }
    
    input:focus, select:focus, textarea:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2) !important;
        outline: none !important;
    }
    
    /* Swiper navigation buttons */
    .swiper-prev, .swiper-next {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #94a3b8 !important;
    }
    
    .swiper-prev:hover, .swiper-next:hover {
        color: #3b82f6 !important;
        border-color: #3b82f6 !important;
    }
</style>
@endpush

@section('content')
{{-- ═══════════════════════════════════════════════
    HERO SECTION
═══════════════════════════════════════════════ --}}
<section class="premium-hero-section relative min-h-[95vh] flex items-center overflow-hidden pt-28 pb-16 lg:pb-24">
    <!-- Cyberpunk grid & ambient light background -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[130px]"></div>
        <div class="absolute top-1/2 left-1/4 w-[400px] h-[400px] bg-purple-600/10 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-20 right-1/3 w-[500px] h-[500px] bg-cyan-600/5 rounded-full blur-[120px]"></div>
        <!-- Dot pattern -->
        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,0.015)_1px,transparent_1px)] [background-size:24px_24px]"></div>
    </div>
    
    <div class="mx-auto w-full max-w-7xl px-6 md:px-8 lg:px-20 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center relative z-10">
        {{-- Text Section --}}
        <div class="lg:col-span-7 flex flex-col gap-6 text-center lg:text-left"
             x-data="{ 
                text1: '', 
                fullText1: 'Solusi Digital Terpadu ',
                showPremium: false,
                text2: '',
                fullText2: ' untuk Bisnis Global Anda',
                init() {
                    let i = 0;
                    let timer1 = setInterval(() => {
                        this.text1 += this.fullText1.charAt(i);
                        i++;
                        if (i >= this.fullText1.length) {
                            clearInterval(timer1);
                            this.showPremium = true;
                            setTimeout(() => {
                                let j = 0;
                                let timer2 = setInterval(() => {
                                    this.text2 += this.fullText2.charAt(j);
                                    j++;
                                    if (j >= this.fullText2.length) clearInterval(timer2);
                                }, 40);
                            }, 400);
                        }
                    }, 60);
                }
             }">
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-1.5 text-xs font-black uppercase tracking-[0.2em] text-blue-400 self-center lg:self-start">
                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-ping"></span>
                Next-Gen Agency
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight text-white min-h-[3em]">
                <span x-text="text1"></span><template x-if="showPremium"><span class="bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent glow-text-indigo" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">Premium</span></template><span x-text="text2"></span><span class="animate-pulse text-blue-500" x-show="text2.length < fullText2.length">|</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed"
               x-show="text2.length === fullText2.length" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                Kami merancang produk digital kelas dunia. Menghadirkan kombinasi desain kelas tinggi, arsitektur software berkinerja tinggi, dan inovasi masa depan.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4"
                 x-show="text2.length === fullText2.length" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <a href="#kontak" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-[0_4px_20px_rgba(59,130,246,0.3)] hover:shadow-[0_4px_30px_rgba(59,130,246,0.5)] hover:-translate-y-0.5 transition-all duration-300 text-center">
                    Konsultasi Eksklusif
                </a>
                <a href="/portofolio?theme=premium" class="w-full sm:w-auto px-8 py-4 bg-white/5 border border-white/10 text-white font-bold rounded-xl hover:bg-white/10 transition-all duration-300 text-center flex items-center justify-center gap-2">
                    Eksplorasi Karya
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </div>
        
        {{-- Visual Section --}}
        <div class="lg:col-span-5 relative hidden lg:block h-[500px]" data-aos data-aos-delay="200">
            <!-- Glowing back panel -->
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-3xl opacity-20 blur-xl"></div>
            <!-- Mockup container -->
            <div class="absolute inset-0 rounded-3xl border border-white/10 shadow-[0_30px_60px_rgba(0,0,0,0.6)] p-3 overflow-hidden backdrop-blur-md bg-slate-900/50 glow-border">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&q=80&w=2070" alt="Rakira Dev Process" class="w-full h-full object-cover rounded-2xl opacity-75">
            </div>
            
            <!-- Float statistics 1 -->
            <div class="absolute -left-10 top-1/4 premium-glass p-4 rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.4)] border border-white/10" data-float>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                    </div>
                    <div>
                        <p class="text-slate-400 text-[10px] uppercase font-black tracking-wider">Keamanan</p>
                        <p class="text-white font-bold text-xs">Standar Enterprise</p>
                    </div>
                </div>
            </div>

            <!-- Float statistics 2 -->
            <div class="absolute -right-8 bottom-1/4 premium-glass p-4 rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.4)] border border-white/10" data-float style="animation-delay: 2.5s">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <span class="material-symbols-outlined text-[18px]">speed</span>
                    </div>
                    <div>
                        <p class="text-slate-400 text-[10px] uppercase font-black tracking-wider">Performa</p>
                        <p class="text-white font-bold text-xs">99+ Google Lighthouse</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    CLIENT LOGOS SECTION (Premium Clean Marquee)
═══════════════════════════════════════════════ --}}
@if($client_logos->isNotEmpty())
<section class="py-16 border-y border-white/5 bg-[#020617] overflow-hidden relative" data-aos>
    <div class="mx-auto max-w-7xl px-6 md:px-8 lg:px-20 mb-8">
        <p class="text-center text-slate-500 text-[10px] font-black uppercase tracking-[0.4em]">Dipercaya Oleh Partner Internasional</p>
    </div>

    @php
        $totalLogos = $client_logos->count();
    @endphp

    @if($totalLogos <= 4)
        <div class="flex flex-wrap justify-center items-center gap-16 md:gap-24 px-6">
            @foreach ($client_logos as $client)
                <div class="group relative h-12 flex-shrink-0 flex items-center cursor-pointer">
                    @if($client->company_logo)
                        <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                             class="h-full w-auto object-contain opacity-40 hover:opacity-100 transition-opacity duration-300">
                    @else
                        <span class="text-slate-500 font-bold text-lg hover:text-white transition-colors">{{ $client->company_name }}</span>
                    @endif
                    
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-slate-900 border border-white/10 text-white text-[9px] font-black uppercase tracking-widest rounded-lg opacity-0 scale-90 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 pointer-events-none whitespace-nowrap z-50">
                        {{ $client->company_name }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="marquee-wrapper relative flex">
            <div class="marquee-track flex gap-20 items-center">
                @php 
                    $displayRow = $client_logos->concat($client_logos)->concat($client_logos)->concat($client_logos); 
                @endphp
                @foreach ($displayRow as $client)
                    <div class="group relative h-10 flex-shrink-0 flex items-center cursor-pointer px-4">
                        @if($client->company_logo)
                            <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                                 class="h-full w-auto object-contain opacity-40 group-hover:opacity-100 transition-all duration-300">
                        @else
                            <span class="text-slate-500 font-black tracking-tight text-lg group-hover:text-white transition-all">{{ $client->company_name }}</span>
                        @endif
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-3 py-1.5 bg-slate-900 border border-white/10 text-white text-[9px] font-black uppercase tracking-widest rounded-lg opacity-0 scale-90 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 pointer-events-none whitespace-nowrap z-50">
                            {{ $client->company_name }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-[#020617] to-transparent z-20 pointer-events-none"></div>
    <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-[#020617] to-transparent z-20 pointer-events-none"></div>
</section>
@endif

<style>
    .marquee-wrapper {
        width: 100%;
    }
    .marquee-track {
        display: flex;
        width: max-content;
        animation: scroll-left-premium 50s linear infinite;
    }
    @keyframes scroll-left-premium {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-wrapper:hover .marquee-track {
        animation-play-state: paused;
    }
</style>

{{-- ═══════════════════════════════════════════════
    TENTANG KAMI (Bento Grid Style)
═══════════════════════════════════════════════ --}}
<section class="py-24 md:py-32">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-8 lg:px-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            {{-- Text & Kicker --}}
            <div class="lg:col-span-5 flex flex-col justify-center space-y-6" data-aos>
                <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/20 bg-blue-500/5 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-blue-400 self-start">
                    {{ __('Mengenal Kami') }}
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-white leading-tight">
                    {{ __('Arsitek di Balik Lanskap Digital Modern') }}
                </h2>
                <p class="text-slate-400 text-sm md:text-base leading-relaxed">
                    {{ __t($settings->about_us ?? 'Rakira Digital Nusantara adalah software house butik yang mendesain solusi digital berskala global. Kami membantu startup dan korporasi meluncurkan platform modern dengan teknologi terbaru.') }}
                </p>
                <div class="pt-4">
                    <a href="/tentang-kami?theme=premium" aria-label="{{ __('Pelajari Selengkapnya tentang Rakira Digital') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 font-bold text-xs uppercase tracking-widest transition-colors">
                        {{ __('Pelajari Selengkapnya') }}
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
            
            {{-- Bento Grid Items --}}
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Card 1: Visi -->
                <div class="premium-glass-card p-8 rounded-3xl flex flex-col justify-between" data-aos data-aos-delay="100">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 mb-6">
                            <span class="material-symbols-outlined text-2xl">visibility</span>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">{{ __('Visi Kami') }}</h4>
                        <p class="text-slate-400 text-xs md:text-sm leading-relaxed">
                            {!! nl2br(e(__t($settings->vision ?? 'Menjadi mitra teknologi utama untuk transformasi digital global yang aman, inovatif, dan berkinerja tinggi.'))) !!}
                        </p>
                    </div>
                </div>

                <!-- Card 2: Misi -->
                <div class="premium-glass-card p-8 rounded-3xl flex flex-col justify-between" data-aos data-aos-delay="200">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 mb-6">
                            <span class="material-symbols-outlined text-2xl">flag</span>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">{{ __('Misi Kami') }}</h4>
                        <p class="text-slate-400 text-xs md:text-sm leading-relaxed">
                            {!! nl2br(e(__t($settings->mission ?? 'Menyediakan arsitektur software modular, antarmuka premium, serta efisiensi proses digital bisnis.'))) !!}
                        </p>
                    </div>
                </div>

                <!-- Card 3: Big Stat (Full Width on Mobile) -->
                <div class="premium-glass-card p-8 rounded-3xl sm:col-span-2 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6" data-aos data-aos-delay="300">
                    <div>
                        <h3 class="text-4xl font-black bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">50+ Proyek Sukses</h3>
                        <p class="text-slate-400 text-sm mt-1">Solusi digital berkinerja tinggi yang diselesaikan secara presisi.</p>
                    </div>
                    <div class="flex items-center -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Client avatar">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Client avatar">
                        <img class="w-10 h-10 rounded-full border-2 border-slate-900 object-cover" src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=100&q=80" alt="Client avatar">
                        <div class="w-10 h-10 rounded-full bg-blue-600 border-2 border-slate-900 flex items-center justify-center text-white font-bold text-xs">+12</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    LAYANAN (Interactive Modern Grid)
═══════════════════════════════════════════════ --}}
<section class="py-24 bg-slate-950/40 relative">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-1/2 right-1/4 w-[300px] h-[300px] bg-blue-500/5 rounded-full blur-[90px]"></div>
    </div>
    
    <div class="mx-auto w-full max-w-7xl px-6 md:px-8 lg:px-20 relative z-10">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16" data-aos>
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/20 bg-blue-500/5 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-blue-400">
                {{ __('Layanan Kami') }}
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-white">{{ __('Layanan Rekayasa Digital') }}</h2>
            <p class="text-slate-400 text-sm md:text-base mx-auto">{{ __('Kami menghadirkan keunggulan teknis terbaik untuk melayani impian bisnis Anda.') }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $index => $service)
            <a href="/layanan/{{ $service->slug }}?theme=premium" 
               aria-label="{{ __('Detail Layanan') }}: {{ __t($service->title) }}"
               class="premium-glass-card p-8 rounded-[2rem] flex flex-col justify-between min-h-[300px] group"
               data-aos data-aos-delay="{{ $index * 80 }}">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                        <span class="material-symbols-outlined text-3xl">{{ $service->icon_image ?: 'terminal' }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">{{ __t($service->title) }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed line-clamp-3">{{ __t($service->short_description) }}</p>
                </div>
                
                <div class="mt-8 flex items-center text-blue-400 font-bold text-xs uppercase tracking-widest gap-2">
                    {{ __('Selengkapnya') }}
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </div>
            </a>
            @empty
            <div class="col-span-full py-16 text-center text-slate-500">
                <span class="material-symbols-outlined text-5xl mb-3">cloud_off</span>
                <p class="text-sm">Layanan tidak dapat dimuat saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    TESTIMONI (Ultra Premium swiper)
═══════════════════════════════════════════════ --}}
<section class="py-24">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-8 lg:px-20">
        @if($clients->isNotEmpty())
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-16" data-aos>
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/20 bg-blue-500/5 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-blue-400">
                {{ __('Ulasan Klien') }}
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-white">{{ __('Apa yang Mitra Kami Katakan') }}</h2>
        </div>

        <div class="relative px-2 md:px-8">
            <div class="swiper premium-swiper pb-16">
                <div class="swiper-wrapper">
                    @foreach($clients as $index => $client)
                    <div class="swiper-slide h-auto">
                        <div class="premium-glass-card p-8 rounded-[2rem] flex flex-col justify-between h-full relative overflow-hidden group">
                            <!-- Glowing overlay -->
                            <div class="absolute inset-0 bg-gradient-to-b from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div>
                                <div class="flex items-center gap-4 mb-6 relative z-10">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center font-bold text-lg shadow-lg">
                                        {{ $client['initial'] }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ __t($client['name']) }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest">{{ __t($client['company']) }}</p>
                                    </div>
                                </div>

                                <div class="flex text-amber-400 mb-4">
                                    @for($i=0; $i<($client['rating'] ?? 5); $i++)
                                        <span class="material-symbols-outlined text-[16px] fill-1">star</span>
                                    @endfor
                                </div>

                                <p class="text-slate-300 text-sm leading-relaxed italic relative z-10">"{{ __t($client['testimonial']) }}"</p>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-white/5 flex items-center justify-between relative z-10">
                                <span class="text-[9px] font-black uppercase tracking-widest text-blue-400">{{ __('Mitra Terverifikasi') }}</span>
                                <span class="material-symbols-outlined text-slate-700 text-2xl">format_quote</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- swiper arrows -->
            <button class="swiper-prev absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-slate-900 border border-white/10 text-slate-400 hover:text-white transition-all active:scale-95 z-20 flex items-center justify-center" aria-label="Slide Testimoni Sebelumnya">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
            </button>
            <button class="swiper-next absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-slate-900 border border-white/10 text-slate-400 hover:text-white transition-all active:scale-95 z-20 flex items-center justify-center" aria-label="Slide Testimoni Selanjutnya">
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </button>
        </div>
        @endif

        {{-- Add Testimonial Form --}}
        <div class="mt-20 max-w-4xl mx-auto">
            <div class="premium-glass p-8 md:p-12 rounded-[2.5rem] shadow-2xl relative overflow-hidden glow-border" data-aos="fade-up">
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-center">
                    <div class="lg:col-span-2 space-y-4">
                        <h3 class="text-2xl font-black text-white">Bagikan Cerita Anda</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Kami menghargai kolaborasi bersama Anda. Tuliskan ulasan Anda untuk meningkatkan layanan eksklusif kami.
                        </p>
                        <div class="flex items-center gap-2 text-blue-400 font-bold text-xs uppercase tracking-wider pt-4">
                            <span class="material-symbols-outlined text-base">verified</span>
                            Moderasi Aktif
                        </div>
                    </div>

                    <div class="lg:col-span-3">
                        @if(session('success_review'))
                        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-semibold flex items-center gap-3">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('success_review') }}
                        </div>
                        @endif

                        <form action="{{ route('review.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="text" name="name" required placeholder="Nama Lengkap *" 
                                    class="w-full rounded-xl border border-white/10 bg-slate-900/50 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-500">
                                <input type="text" name="company" placeholder="Instansi/Perusahaan" 
                                    class="w-full rounded-xl border border-white/10 bg-slate-900/50 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-500">
                            </div>
                            
                            <div x-data="{ rating: 5, hover: 0 }">
                                <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 pl-1">Penilaian Anda</span>
                                <div class="flex gap-2">
                                    <input type="hidden" name="rating" :value="rating">
                                    @for($i=1; $i<=5; $i++)
                                    <button type="button" 
                                        @click="rating = {{ $i }}" 
                                        @mouseenter="hover = {{ $i }}" 
                                        @mouseleave="hover = 0"
                                        aria-label="Bintang {{ $i }}"
                                        class="cursor-pointer transition-transform hover:scale-110 active:scale-95">
                                        <span class="material-symbols-outlined text-3xl transition-colors duration-200"
                                            :class="(hover || rating) >= {{ $i }} ? 'text-amber-400 fill-1' : 'text-slate-700'">
                                            star
                                        </span>
                                    </button>
                                    @endfor
                                </div>
                            </div>

                            <textarea name="comment" required rows="3" placeholder="Tulis testimoni kolaborasi Anda di sini... *"
                                class="w-full rounded-xl border border-white/10 bg-slate-900/50 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all resize-none placeholder:text-slate-500"></textarea>

                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 rounded-xl hover:opacity-90 shadow-lg flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">send</span>
                                Kirim Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    FAQS
═══════════════════════════════════════════════ --}}
@if($faqs->isNotEmpty())
<section class="py-24 bg-slate-950/30">
    <div class="mx-auto w-full max-w-4xl px-6 md:px-8 lg:px-20">
        <div class="text-center space-y-3 mb-16" data-aos>
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/20 bg-blue-500/5 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-blue-400">
                {{ __('Tanya Jawab') }}
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-white">{{ __('Pertanyaan Umum') }}</h2>
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
            <details class="premium-glass-card overflow-hidden rounded-2xl transition-all duration-300 group" data-aos data-aos-delay="{{ (int) $index * 60 }}">
                <summary class="flex items-center justify-between cursor-pointer px-6 py-5 md:px-8 md:py-6 select-none list-none outline-none">
                    <span class="font-bold text-slate-200 group-hover:text-white pr-4 transition-colors">{{ $faqQuestion }}</span>
                    <span class="material-symbols-outlined text-slate-500 group-open:rotate-45 group-open:text-blue-400 transition-all duration-300 flex-shrink-0">add</span>
                </summary>
                <div class="px-6 pb-6 md:px-8 md:pb-8 text-slate-400 text-sm leading-relaxed border-t border-white/5 pt-4">
                    {{ $faqAnswer }}
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════
    FORM KONSULTASI EKSKLUSIF
═══════════════════════════════════════════════ --}}
<section class="py-24" id="kontak">
    <div class="mx-auto w-full max-w-7xl px-6 md:px-8 lg:px-20 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
        
        {{-- Info --}}
        <div class="space-y-6" data-aos>
            <div class="inline-flex items-center gap-2 rounded-full border border-blue-500/20 bg-blue-500/5 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-blue-400">
                Mulai Proyek
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-white">Mari Diskusikan Proyek Hebat Anda</h2>
            <p class="text-slate-400 text-sm md:text-base leading-relaxed">
                Kirim pesan Anda dan tim Strategic Consultant kami akan merespons dalam waktu 1x24 jam kerja dengan proposal awal gratis.
            </p>
            
            <div class="space-y-6 pt-4">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 flex-shrink-0">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm">Respon Eksklusif</p>
                        <p class="text-slate-400 text-xs mt-1">Kami menghargai waktu Anda. Estimasi feedback dalam 12-24 jam.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 flex-shrink-0">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <div>
                        <p class="font-bold text-white text-sm">Jaminan NDA (Kerahasiaan)</p>
                        <p class="text-slate-400 text-xs mt-1">Semua data konsep dan bisnis Anda dienkripsi serta dijaga secara aman.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div data-aos data-aos-delay="150" class="w-full">
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-semibold flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('konsultasi.store') }}" method="POST" class="premium-glass rounded-[2rem] p-8 space-y-6 glow-border">
                @csrf
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2" for="sender_name">Nama Lengkap *</label>
                    <input type="text" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" required
                        class="w-full rounded-xl border border-white/10 bg-slate-900/50 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-500"
                        placeholder="Masukkan nama lengkap">
                    @error('sender_name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2" for="sender_email">Email Aktif *</label>
                    <input type="email" id="sender_email" name="sender_email" value="{{ old('sender_email') }}" required
                        class="w-full rounded-xl border border-white/10 bg-slate-900/50 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-500"
                        placeholder="email@bisnis.com">
                    @error('sender_email') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2" for="phone">No. WhatsApp *</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full rounded-xl border border-white/10 bg-slate-900/50 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-500"
                        placeholder="Contoh: 081234567890">
                    @error('phone') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2" for="service">Layanan Utama *</label>
                    <select id="service" name="service" required
                        class="w-full rounded-xl border border-white/10 bg-slate-900/80 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all">
                        <option value="" class="bg-slate-950">-- {{ __('Pilih Layanan Premium') }} --</option>
                        @foreach($services as $srv)
                            @php
                                $srvTitle = __t(is_array($srv) ? ($srv['title'] ?? '') : ($srv->title ?? ''));
                            @endphp
                            @if($srvTitle)
                                <option value="{{ $srvTitle }}" class="bg-slate-950" {{ old('service') == $srvTitle ? 'selected' : '' }}>{{ $srvTitle }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('service') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2" for="message_body">Deskripsi Proyek Singkat</label>
                    <textarea id="message_body" name="message_body" rows="3"
                        class="w-full rounded-xl border border-white/10 bg-slate-900/50 px-4 py-3.5 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all resize-none placeholder:text-slate-500"
                        placeholder="Tuliskan tujuan proyek digital Anda...">{{ old('message_body') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-4 rounded-xl shadow-[0_4px_25px_rgba(59,130,246,0.3)] transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span>
                    Kirim Penawaran
                </button>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.premium-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
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
