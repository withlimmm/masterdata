@extends('layouts.main')

@section('title', ($settings->company_name ?? 'Rakira Digital Nusantara') . ' | Software House & Jasa Pembuatan Website Indonesia')
@section('meta_description', Str::limit(strip_tags($settings->about_us ?? 'Rakira Digital Nusantara adalah software house terpercaya di Tangerang. Jasa pembuatan website company profile, aplikasi mobile Android iOS, web app kustom, dan konsultasi IT profesional untuk bisnis di seluruh Indonesia.'), 160))
@section('meta_keywords', 'software house indonesia, jasa pembuatan website murah profesional, jasa pembuatan aplikasi android ios, web developer indonesia, it consultant tangerang, company profile website, rakira digital, jasa digital agency, aplikasi mobile kustom, transformasi digital UMKM')
@section('og_type', 'website')

@push('og_tags')
<meta property="og:image" content="{{ asset('images/og-rakira.png') }}">
@endpush

@push('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ProfessionalService",
  "name": "{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}",
  "description": "Software house profesional di Indonesia menyediakan jasa website, aplikasi mobile, dan solusi IT kustom.",
  "url": "{{ url('/') }}",
  "telephone": "+{{ $settings->phone ?? '6287868184742' }}",
  "priceRange": "Rp Rp Rp",
  "address": {
    "@@type": "PostalAddress",
    "addressLocality": "Tangerang",
    "addressRegion": "Banten",
    "addressCountry": "ID"
  },
  "hasOfferCatalog": {
    "@@type": "OfferCatalog",
    "name": "Layanan Digital",
    "itemListElement": [
      { "@@type": "Offer", "itemOffered": { "@@type": "Service", "name": "Pembuatan Website" } },
      { "@@type": "Offer", "itemOffered": { "@@type": "Service", "name": "Aplikasi Mobile Android iOS" } },
      { "@@type": "Offer", "itemOffered": { "@@type": "Service", "name": "Web App Kustom" } },
      { "@@type": "Offer", "itemOffered": { "@@type": "Service", "name": "UI/UX Design" } },
      { "@@type": "Offer", "itemOffered": { "@@type": "Service", "name": "IT Consulting" } }
    ]
  },
  "aggregateRating": {
    "@@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "{{ \App\Models\Review::where('status','approved')->count() ?: 47 }}",
    "bestRating": "5"
  }
}
</script>
@if($faqs->isNotEmpty())
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $i => $faq)
    {
      "@@type": "Question",
      "name": "{{ addslashes(strip_tags(data_get($faq, 'question', ''))) }}",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "{{ addslashes(strip_tags(data_get($faq, 'answer', ''))) }}"
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
</script>
@endif

@if(isset($systems) && collect($systems)->isNotEmpty())
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "SoftwareApplication",
  "name": "{{ $settings->company_name ?? 'Rakira Digital' }} SaaS Solutions",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Web, iOS, Android",
  "offers": [
    @php $isFirstOffer = true; @endphp
    @foreach($systems as $system)
        @foreach($system->packages as $package)
            {!! $isFirstOffer ? '' : ',' !!}
            {
              "@@type": "Offer",
              "name": "{{ $system->system_name }} - {{ $package->package_name }}",
              "price": "{{ $package->package_price }}",
              "priceCurrency": "IDR",
              "billingIncrement": "{{ $package->billing_cycle }}",
              "description": "{{ str_replace(["\r", "\n"], ' ', strip_tags($package->package_benefits)) }}"
            }
            @php $isFirstOffer = false; @endphp
        @endforeach
    @endforeach
  ]
}
</script>
@endif
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* ========================================
       PREMIUM COLOR VARIABLES
    ======================================== */
    :root {
        --primary: #009fe3;
        --primary-dark: #0077b3;
        --primary-light: #4bb8f0;
        --primary-soft: #e0f4ff;
        --primary-glow: rgba(0, 159, 227, 0.2);
        --dark: #0f172a;
        --dark-soft: #1e293b;
        --gray-light: #f8fafc;
        --gray: #64748b;
        --gradient-primary: linear-gradient(135deg, #009fe3 0%, #0077b3 100%);
        --gradient-hero: linear-gradient(135deg, #001a2a 0%, #003d5c 50%, #009fe3 100%);
        --gradient-cta: linear-gradient(135deg, #009fe3, #006491);
        --gradient-gold: linear-gradient(135deg, #fbbf24, #f59e0b);
        --shadow-sm: 0 4px 20px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    /* ========================================
       RESET & BASE
    ======================================== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        overflow-x: hidden;
        background: white;
    }

    /* ========================================
       ANIMATIONS
    ======================================== */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    @keyframes floatSlow {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes glowPulse {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes borderGlow {
        0%, 100% { border-color: rgba(0, 159, 227, 0.2); box-shadow: 0 0 0 0 rgba(0, 159, 227, 0.1); }
        50% { border-color: rgba(0, 159, 227, 0.5); box-shadow: 0 0 20px rgba(0, 159, 227, 0.15); }
    }

    @keyframes scroll-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    @keyframes scroll-right {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }

    /* Animation Classes */
    .fade-up { animation: fadeUp 0.7s ease forwards; }
    .fade-in { animation: fadeIn 0.5s ease forwards; }
    .scale-in { animation: scaleIn 0.5s ease forwards; }
    .slide-left { animation: slideInLeft 0.6s ease forwards; }
    .slide-right { animation: slideInRight 0.6s ease forwards; }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-float-slow { animation: floatSlow 8s ease-in-out infinite; }
    .animate-glow { animation: glowPulse 4s ease-in-out infinite; }
    .border-glow { animation: borderGlow 3s ease-in-out infinite; }

    /* Delay Utilities */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }

    /* ========================================
       SECTION STYLES
    ======================================== */
    .page-section {
        padding: 100px 0;
        position: relative;
    }

    @media (max-width: 768px) {
        .page-section {
            padding: 70px 0;
        }
    }

    .content-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 32px;
    }

    @media (max-width: 640px) {
        .content-container {
            padding: 0 20px;
        }
    }

    /* Section Kicker Premium */
    .section-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        padding: 6px 16px;
        border-radius: 50px;
        background: linear-gradient(135deg, var(--primary-soft), rgba(0, 159, 227, 0.05));
        color: var(--primary);
        margin-bottom: 20px;
        border: 1px solid rgba(0, 159, 227, 0.15);
    }

    .section-kicker::before {
        content: '';
        width: 6px;
        height: 6px;
        background: var(--primary);
        border-radius: 50%;
        display: inline-block;
        animation: glowPulse 1.5s ease-in-out infinite;
    }

    /* Section Title Premium */
    .section-title {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
        color: var(--dark);
        letter-spacing: -0.02em;
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }
    }

    .section-subtitle {
        font-size: 1rem;
        color: var(--gray);
        line-height: 1.7;
        max-width: 600px;
    }

    /* Gradient Text Premium */
    .gradient-text {
        background: var(--gradient-primary);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: shimmer 3s linear infinite;
    }

    .gradient-text-gold {
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* ========================================
       HERO SECTION PREMIUM
    ======================================== */
    .page-hero {
        position: relative;
        min-height: 90vh;
        display: flex;
        align-items: center;
        background: var(--gradient-hero);
        overflow: hidden;
    }

    .bg-grid-pattern {
        background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    /* ========================================
       GLASS PANEL PREMIUM
    ======================================== */
    .glass-panel {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 20px;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 159, 227, 0.1);
        border-radius: 24px;
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(0, 159, 227, 0.2);
    }

    /* Surface Card */
    .surface-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2f6;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        overflow: hidden;
    }

    .surface-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(0, 159, 227, 0.15);
    }

    /* ========================================
       INTERACTIVE CARDS (LAYANAN) PREMIUM
    ======================================== */
    .interactive-card {
        background: white;
        border-radius: 28px;
        padding: 32px;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        border: 1px solid rgba(0, 159, 227, 0.08);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: block;
        height: 100%;
    }

    .interactive-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: transform 0.5s ease;
        transform-origin: left;
    }

    .interactive-card:hover::before {
        transform: scaleX(1);
    }

    .interactive-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(0, 159, 227, 0.2);
    }

    .interactive-card-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary-soft), rgba(0, 159, 227, 0.08));
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        transition: all 0.4s ease;
    }

    .interactive-card:hover .interactive-card-icon {
        background: var(--gradient-primary);
        transform: scale(1.05);
    }

    .interactive-card:hover .interactive-card-icon span {
        color: white !important;
    }

    .interactive-card-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--dark);
        transition: color 0.3s ease;
    }

    .interactive-card:hover .interactive-card-title {
        color: var(--primary);
    }

    .interactive-card-description {
        font-size: 0.9rem;
        color: var(--gray);
        line-height: 1.6;
    }

    /* ========================================
       TESTIMONIAL CARD PREMIUM
    ======================================== */
    .testimonial-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 24px;
        overflow: hidden;
    }

    .testimonial-card:hover {
        background: var(--gradient-primary) !important;
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .testimonial-card:hover p, 
    .testimonial-card:hover span:not(.material-symbols-outlined) {
        color: rgba(255, 255, 255, 0.95) !important;
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

    /* Testimonial Swiper */
    .testimonial-swiper .swiper-pagination-bullet-active {
        background: var(--primary) !important;
        width: 28px;
        border-radius: 8px;
    }

    .testimonial-swiper .swiper-pagination {
        bottom: 0 !important;
    }

    /* ========================================
       FAQ ITEM PREMIUM
    ======================================== */
    .faq-item {
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2f6;
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .faq-item[open] {
        background: var(--gradient-primary);
        border-color: transparent;
        box-shadow: var(--shadow-lg);
    }

    .faq-item[open] summary span {
        color: white;
    }

    .faq-item[open] .faq-icon {
        color: white;
        transform: rotate(45deg);
        background: rgba(255, 255, 255, 0.2);
    }

    .faq-item[open] .faq-answer {
        color: rgba(255, 255, 255, 0.9);
    }

    .faq-item summary {
        list-style: none;
        cursor: pointer;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .faq-item summary::-webkit-details-marker {
        display: none;
    }

    .faq-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    /* ========================================
       BUTTONS PREMIUM
    ======================================== */
    .btn-primary {
        background: var(--gradient-primary);
        color: white;
        padding: 14px 36px;
        border-radius: 60px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
        letter-spacing: 0.02em;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover::after {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 159, 227, 0.35);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 12px 32px;
        border-radius: 60px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        backdrop-filter: blur(10px);
    }

    .btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
        transform: translateY(-2px);
    }

    /* ========================================
       MARQUEE PREMIUM
    ======================================== */
    .marquee-wrapper {
        width: 100%;
        overflow: hidden;
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }

    .marquee-track {
        display: flex;
        width: max-content;
        animation: scroll-left 45s linear infinite;
    }

    .marquee-track-reverse {
        display: flex;
        width: max-content;
        animation: scroll-right 45s linear infinite;
    }

    .marquee-wrapper:hover .marquee-track,
    .marquee-wrapper:hover .marquee-track-reverse {
        animation-play-state: paused;
    }

    /* ========================================
       FORM STYLES
    ======================================== */
    .form-input {
        width: 100%;
        padding: 14px 18px;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 159, 227, 0.1);
    }

    /* ========================================
       RESPONSIVE UTILITIES
    ======================================== */
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.8rem;
        }
        .interactive-card {
            padding: 24px;
        }
        .interactive-card-icon {
            width: 52px;
            height: 52px;
        }
        .interactive-card-title {
            font-size: 1.2rem;
        }
    }

    /* Color Utilities */
    .text-primary { color: var(--primary); }
    .bg-primary-soft { background: var(--primary-soft); }
    .border-primary-light { border-color: rgba(0, 159, 227, 0.15); }
</style>
@endpush

@section('content')
@php
    $whatsAppText = __('Halo, saya ingin konsultasi layanan digital untuk website dan company profile.');
    $whatsAppUrl = 'https://wa.me/' . ($whatsAppNumber ?? '6287868184742') . '?text=' . urlencode($whatsAppText);
@endphp

{{-- HERO SECTION --}}
<section class="page-hero">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl animate-glow"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-glow" style="animation-delay: 3s"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
    </div>
    
    <div class="content-container grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center relative z-10">
        <div class="flex flex-col gap-6 text-white text-center lg:text-left" 
             x-data="{ 
                text1: '', 
                fullText1: '{{ __('welcome.hero_prefix') }} ',
                showInovatif: false,
                text2: '',
                fullText2: '{{ __('welcome.hero_suffix') }}',
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
            <span class="hero-badge self-center lg:self-start w-fit"
                  x-show="text1.length > 0" x-transition>
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                Rakira Digital Nusantara
            </span>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight">
                <span x-text="text1"></span>
                <template x-if="showInovatif">
                    <span class="text-[#8aceff]" x-transition>{{ __('welcome.hero_highlight') }}</span>
                </template>
                <span x-text="text2"></span>
                <span class="animate-pulse text-[#8aceff]" x-show="text2.length < fullText2.length">|</span>
            </h1>

            <p class="text-base md:text-lg text-white/80 leading-relaxed max-w-xl mx-auto lg:mx-0"
               x-show="text2.length === fullText2.length" x-transition>
                {{ __('Transformasi digital bukan lagi pilihan, tapi keharusan. Rakira Digital Nusantara hadir sebagai mitra strategis untuk membangun ekosistem digital yang scalable.') }}
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                <a href="#kontak" class="btn-primary">
                    {{ __('Konsultasi Gratis') }}
                    <span class="material-symbols-outlined notranslate text-lg" translate="no">arrow_forward</span>
                </a>
                <a href="/portofolio" class="btn-outline">
                    {{ __('Lihat Portofolio') }}
                    <span class="material-symbols-outlined notranslate text-lg" translate="no">folder_open</span>
                </a>
            </div>
        </div>
        
        <div class="relative hidden lg:block h-[480px] w-full">
            <div class="absolute inset-0 rounded-3xl border border-white/15 shadow-2xl p-4 overflow-hidden backdrop-blur-sm bg-white/5 animate-float">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=2426" 
                     alt="Dashboard Preview" 
                     class="w-full h-full object-cover rounded-2xl opacity-80">
            </div>
            <div class="absolute -left-8 bottom-16 glass-panel p-4 rounded-xl shadow-2xl animate-float-slow">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-400/20 flex items-center justify-center">
                        <span class="material-symbols-outlined notranslate text-emerald-400 text-xl" translate="no">trending_up</span>
                    </div>
                    <div>
                        <p class="text-white/60 text-xs font-semibold">{{ __('Kinerja Sistem') }}</p>
                        <p class="text-white font-bold text-sm">+99.9% Uptime</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BANNERS SECTION --}}
@if(isset($banners) && collect($banners)->isNotEmpty())
<section class="page-section bg-slate-50 !py-12 border-b border-slate-100">
    <div class="content-container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($banners as $index => $banner)
                <a href="{{ $banner->link_url ?? '#' }}" 
                   class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 {{ $index === 0 && $banners->count() === 3 ? 'md:col-span-2 md:row-span-2 h-[200px] md:h-[424px]' : 'h-[200px]' }}">
                    <img src="{{ asset('storage/' . $banner->image_path) }}" 
                         alt="{{ $banner->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CLIENT TRUST STRIP --}}
@if(($client_logos ?? collect())->isNotEmpty())
<section class="page-section !py-16 bg-white border-b border-slate-100 overflow-hidden">
    <div class="content-container">
        <p class="text-center text-[#009fe3] text-[11px] font-bold uppercase tracking-[0.3em] mb-10">
            {{ __('Dipercaya Oleh Perusahaan Terkemuka') }}
        </p>
    </div>

    @php $totalLogos = $client_logos->count(); @endphp

    @if($totalLogos <= 4)
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 px-4">
            @foreach ($client_logos as $client)
                <div class="group relative h-20 md:h-20 flex-shrink-0 flex items-center transition-all duration-300 hover:scale-110">
                    @if($client->company_logo)
                        <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                             class="h-full w-auto object-contain grayscale hover:grayscale-0 opacity-60 hover:opacity-100 transition-all duration-300">
                    @else
                        <span class="text-slate-400 font-bold text-lg transition-all duration-300 group-hover:text-slate-800">{{ $client->company_name }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="marquee-wrapper">
            <div class="marquee-track gap-16">
                @foreach($client_logos->concat($client_logos)->concat($client_logos) as $client)
                    <div class="flex-shrink-0 transition-all duration-300 hover:scale-110">
                        @if($client->company_logo)
                            <img src="{{ asset('storage/' . $client->company_logo) }}" alt="{{ $client->company_name }}" 
                                 class="h-10 md:h-12 w-auto object-contain grayscale hover:grayscale-0 opacity-50 hover:opacity-100 transition-all duration-300">
                        @else
                            <span class="text-slate-400 font-semibold">{{ $client->company_name }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endif

{{-- TENTANG KAMI --}}
<section class="page-section bg-white">
    <div class="content-container grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-center">
        <div class="space-y-7">
            <span class="section-kicker">{{ __('Tentang Rakira Digital') }}</span>
            <h2 class="section-title">{{ __('Arsitek Ekosistem') }}<br><span class="gradient-text">Digital Masa Depan</span></h2>
            <p class="text-slate-500 leading-relaxed text-base">
                {{ __t($settings->about_us) ?: __('Rakira Digital Nusantara adalah software house premium yang berdedikasi untuk memberikan solusi teknologi end-to-end. Kami menggabungkan keahlian teknis mendalam dengan pemahaman bisnis strategis.') }}
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                <div class="surface-card p-7 rounded-xl">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#e0f4ff] to-[#e0f4ff]/50 flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined notranslate text-[#009fe3] text-2xl" translate="no">visibility</span>
                    </div>
                    <h4 class="text-lg font-bold mb-2 text-slate-800">{{ __('Visi') }}</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        {!! nl2br(e(__t($settings->vision) ?: __('Menjadi katalisator utama transformasi digital bagi perusahaan.'))) !!}
                    </p>
                </div>
                <div class="surface-card p-7 rounded-xl">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#e0f4ff] to-[#e0f4ff]/50 flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined notranslate text-[#009fe3] text-2xl" translate="no">flag</span>
                    </div>
                    <h4 class="text-lg font-bold mb-2 text-slate-800">{{ __('Misi') }}</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        {!! nl2br(e(__t($settings->mission) ?: __('Memberikan solusi software yang scalable dan aman.'))) !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="relative h-[420px] md:h-[480px] rounded-2xl overflow-hidden shadow-xl">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2070" 
                 alt="Tim Rakira Digital" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <div class="glass-panel p-5 rounded-xl bg-white/10 backdrop-blur border border-white/20">
                    <p class="text-xl font-bold text-white">{{ __('50+ Proyek Sukses') }}</p>
                    <p class="text-white/70 text-sm">{{ __('Diselesaikan dengan tingkat kepuasan tinggi.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="page-section bg-slate-50">
    <div class="content-container">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="section-kicker mx-auto w-fit">{{ __('Layanan Rakira Digital') }}</span>
            <h2 class="section-title">{{ __('Solusi Digital') }}<br><span class="gradient-text">Untuk Bisnis Anda</span></h2>
            <p class="text-slate-500">{{ __('Klik layanan untuk melihat detail dan konsultasikan kebutuhan Anda.') }}</p>
        </div>
        
        <div class="relative px-4 md:px-10">
            <div class="swiper layanan-swiper pb-16">
                <div class="swiper-wrapper">
                    @forelse($services as $index => $service)
                    <div class="swiper-slide h-auto">
                        <a href="{{ route('services.show', $service->slug) }}" 
                           class="interactive-card flex flex-col h-full group">
                            <div class="interactive-card-icon">
                                <span class="material-symbols-outlined notranslate text-2xl text-[#009fe3] transition-colors" translate="no">{{ $service->icon_image ?: 'settings' }}</span>
                            </div>
                            <h3 class="interactive-card-title">{{ __t($service->title) }}</h3>
                            <p class="interactive-card-description flex-grow">{{ __t($service->short_description) }}</p>
                            <div class="mt-5 flex items-center text-[#009fe3] font-semibold text-sm opacity-0 group-hover:opacity-100 transition-all group-hover:translate-x-1">
                                {{ __('Lihat Detail') }}
                                <span class="material-symbols-outlined notranslate ml-1 text-sm" translate="no">arrow_forward</span>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="swiper-slide w-full text-center py-16 text-slate-500 bg-white rounded-2xl">
                        <p>{{ __('Layanan akan segera hadir.') }}</p>
                    </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>

            @if(count($services ?? []) > 0)
            <button class="layanan-prev absolute left-0 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white border border-slate-200 shadow-md flex items-center justify-center text-slate-400 hover:text-[#009fe3] hover:border-[#009fe3] transition-all z-10 hidden md:flex">
                <span class="material-symbols-outlined notranslate" translate="no">chevron_left</span>
            </button>
            <button class="layanan-next absolute right-0 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white border border-slate-200 shadow-md flex items-center justify-center text-slate-400 hover:text-[#009fe3] hover:border-[#009fe3] transition-all z-10 hidden md:flex">
                <span class="material-symbols-outlined notranslate" translate="no">chevron_right</span>
            </button>
            @endif
        </div>
    </div>
</section>

{{-- PAKET LANGGANAN --}}
@if(isset($systems) && collect($systems)->isNotEmpty())
<section class="page-section bg-white" id="paket">
    <div class="content-container">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="section-kicker mx-auto w-fit">{{ __('Paket Langganan') }}</span>
            <h2 class="section-title">{{ __('Pilih Paket') }}<br><span class="gradient-text">Yang Tepat Untuk Anda</span></h2>
            <p class="text-slate-500">{{ __('Tersedia berbagai pilihan paket yang dapat disesuaikan dengan skala dan kebutuhan bisnis Anda.') }}</p>
        </div>

        <div x-data="{ activeTab: '{{ $systems->first()->id ?? '' }}' }">
            {{-- Tabs --}}
            <div class="flex flex-wrap justify-center gap-2 mb-12 bg-[#009fe3]/10 w-fit mx-auto p-1.5 rounded-full border border-[#009fe3]/20">
                @foreach($systems as $system)
                <button @click="activeTab = '{{ $system->id }}'" 
                        :class="activeTab === '{{ $system->id }}' ? 'bg-white text-[#009fe3] shadow-sm font-bold' : 'bg-transparent text-slate-600 hover:text-[#009fe3] font-medium'"
                        class="px-6 py-2.5 rounded-full text-[15px] transition-all duration-300 flex items-center gap-2">
                    {{ $system->system_name }}
                </button>
                @endforeach
            </div>

            {{-- Packages Content --}}
            <div class="relative min-h-[400px]">
                @foreach($systems as $system)
                <div x-show="activeTab === '{{ $system->id }}'" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;"
                     class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start pt-8 pb-4">
                    
                    @forelse($system->packages as $package)
                    <div x-data="{ showFeatures: {{ $package->is_popular ? 'true' : 'false' }} }" 
                         class="bg-white rounded-[2rem] p-6 md:p-8 relative flex flex-col h-fit transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 will-change-transform {{ $package->is_popular ? 'border-[3px] border-[#009fe3]/50 shadow-xl z-10 scale-[1.02]' : 'border border-slate-200 shadow-md' }}">
                        @if($package->is_popular)
                            <div class="absolute top-0 right-0 bg-[#e6f6fd] text-[#009fe3] px-4 py-2 rounded-bl-2xl rounded-tr-[1.8rem] text-[11px] font-black uppercase tracking-wider shadow-sm z-20 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">star</span>
                                {{ __('Paling Populer') }}
                            </div>
                        @endif
                        
                        <div class="mb-5 mt-2 text-center md:text-left">
                            <h3 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">{{ $package->package_name }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed min-h-[44px]">{{ $package->package_description ?? __('Solusi andalan untuk manajemen bisnis yang efisien dan modern.') }}</p>
                        </div>
                        
                        <div class="mb-8 flex flex-col items-center md:items-start border-b border-slate-100 pb-6">
                            @if($package->package_price > 0)
                                <div class="text-3xl font-extrabold text-[#009fe3] tracking-tight">Rp {{ number_format($package->package_price, 0, ',', '.') }}</div>
                                <div class="mt-2 text-[11px] font-bold text-slate-500 bg-slate-50 px-4 py-1.5 rounded-full border border-slate-200">per outlet / {{ $package->billing_cycle }}</div>
                            @else
                                <div class="text-2xl font-extrabold text-[#009fe3] tracking-tight mt-2">{{ __('Konsultasi Harga') }}</div>
                                <div class="mt-2 text-[11px] font-bold text-slate-500 bg-slate-50 px-4 py-1.5 rounded-full border border-slate-200">{{ __('Dapatkan Penawaran Khusus') }}</div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-3 mt-auto w-full mb-6">
                            <a href="#kontak" class="w-full py-3.5 rounded-xl font-bold text-sm text-center transition-all duration-300 bg-gradient-to-r from-[#009fe3] to-[#0077b3] text-white shadow-md hover:shadow-lg hover:-translate-y-0.5 will-change-transform">
                                @if($package->package_price > 0)
                                    {{ __('Pilih Paket') }}
                                @else
                                    {{ __('Hubungi Kami') }}
                                @endif
                            </a>
                            <a href="#kontak" class="w-full py-3.5 rounded-xl font-bold text-sm text-center transition-all duration-300 border-2 border-[#009fe3]/20 text-[#009fe3] hover:border-[#009fe3] hover:bg-[#009fe3]/5 will-change-transform">
                                {{ __('Konsultasi Gratis') }}
                            </a>
                        </div>
                        
                        {{-- Collapsible Trigger --}}
                        <div class="text-center w-full mb-2">
                            <button @click="showFeatures = !showFeatures" class="text-xs font-bold text-[#009fe3] hover:text-[#0077b3] flex items-center justify-center w-full gap-1 transition-all">
                                <span x-text="showFeatures ? 'Tutup' : 'Lihat Fitur {{ $package->package_name }}'"></span>
                                <span class="material-symbols-outlined notranslate text-sm transition-transform duration-300" 
                                      :class="showFeatures ? 'rotate-180' : ''" translate="no">expand_more</span>
                            </button>
                        </div>

                        {{-- Collapsible Content --}}
                        <div x-show="showFeatures" 
                             x-collapse 
                             class="pt-5 border-t border-slate-100 w-full overflow-hidden mt-2">
                            <ul class="space-y-4">
                                @php
                                    $benefits = explode("\n", $package->package_benefits);
                                @endphp
                                @foreach($benefits as $benefit)
                                    @if(trim($benefit) !== '')
                                    <li class="flex items-start gap-3">
                                        <div class="mt-0.5 rounded-full bg-[#009fe3]/10 p-0.5 flex-shrink-0">
                                            <span class="material-symbols-outlined notranslate text-[#009fe3] text-[16px]" translate="no">check</span>
                                        </div>
                                        <span class="text-slate-600 text-sm leading-relaxed font-medium">{{ trim($benefit) }}</span>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-slate-500">{{ __('Belum ada paket untuk sistem ini.') }}</p>
                    </div>
                    @endforelse

                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- TESTIMONIAL CLIENTS --}}
@if(collect($clients ?? [])->isNotEmpty())
<section class="page-section bg-white">
    <div class="content-container">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="section-kicker mx-auto w-fit">{{ __('Kata Mereka') }}</span>
            <h2 class="section-title">{{ __('Testimoni') }}<br><span class="gradient-text">Klien Rakira Digital</span></h2>
        </div>
        
        <div class="relative px-4 md:px-10">
            <div class="swiper testimonial-swiper pb-16">
                <div class="swiper-wrapper">
                    @foreach($clients as $client)
                    <div class="swiper-slide h-auto">
                        <div class="surface-card p-7 rounded-2xl testimonial-card group">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-r from-[#009fe3] to-[#0077b3] text-white flex items-center justify-center font-bold text-xl shadow-md">
                                    {{ $client['initial'] }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-base">{{ __t($client['name']) }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">{{ __t($client['company']) }}</p>
                                </div>
                            </div>
                            <div class="flex gap-1 mb-4">
                                @for($i=0; $i<($client['rating'] ?? 5); $i++)
                                    <span class="material-symbols-outlined notranslate text-amber-400 text-base fill-1" translate="no">star</span>
                                @endfor
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed italic flex-1">"{{ __t($client['testimonial']) }}"</p>
                            <div class="mt-6 pt-5 border-t border-slate-100">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-[#009fe3]">{{ __('Verified Client') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <button class="swiper-prev absolute left-0 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white border border-slate-200 shadow-md flex items-center justify-center text-slate-400 hover:text-[#009fe3] hover:border-[#009fe3] transition-all z-10">
                <span class="material-symbols-outlined notranslate" translate="no">chevron_left</span>
            </button>
            <button class="swiper-next absolute right-0 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white border border-slate-200 shadow-md flex items-center justify-center text-slate-400 hover:text-[#009fe3] hover:border-[#009fe3] transition-all z-10">
                <span class="material-symbols-outlined notranslate" translate="no">chevron_right</span>
            </button>
        </div>

        {{-- Review Form --}}
        <div class="mt-24 max-w-4xl mx-auto">
            <div class="glass-card p-8 md:p-12 rounded-3xl shadow-xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#009fe3] to-[#0077b3]"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-center">
                    <div class="lg:col-span-2 space-y-4">
                        <h3 class="text-2xl font-bold text-slate-800">{{ __('Berikan Ulasan Anda') }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            {{ __('Punya pengalaman dengan kami? Bagikan ulasan Anda untuk membantu kami berkembang.') }}
                        </p>
                        <div class="flex items-center gap-2 text-[#009fe3] font-semibold text-sm pt-3">
                            <span class="material-symbols-outlined notranslate" translate="no">verified</span>
                            {{ __('Moderasi Aktif') }}
                        </div>
                    </div>

                    <div class="lg:col-span-3">
                        @if(session('success_review'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-3">
                            <span class="material-symbols-outlined notranslate text-green-600" translate="no">check_circle</span>
                            {{ __(session('success_review')) }}
                        </div>
                        @endif

                        <form action="{{ route('review.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="text" name="name" required placeholder="{{ __('Nama Lengkap *') }}" 
                                    class="form-input">
                                <input type="text" name="company" placeholder="{{ __('Instansi/Perusahaan') }}" 
                                    class="form-input">
                            </div>
                            
                            <div x-data="{ rating: 5, hover: 0 }">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">{{ __('Penilaian Anda') }}</label>
                                <div class="flex gap-2">
                                    <input type="hidden" name="rating" :value="rating">
                                    @for($i=1; $i<=5; $i++)
                                    <button type="button" 
                                        @click="rating = {{ $i }}" 
                                        @mouseenter="hover = {{ $i }}" 
                                        @mouseleave="hover = 0"
                                        class="cursor-pointer transition-all hover:scale-110 focus:outline-none">
                                        <span class="material-symbols-outlined notranslate text-4xl transition-all duration-200"
                                            :class="(hover || rating) >= {{ $i }} ? 'text-amber-400 scale-110' : 'text-slate-300'"
                                            translate="no">star</span>
                                    </button>
                                    @endfor
                                </div>
                            </div>

                            <textarea name="comment" required rows="3" placeholder="{{ __('Tulis ulasan Anda di sini... *') }}"
                                class="form-input resize-none"></textarea>

                            <button type="submit" class="btn-primary w-full justify-center py-3.5">
                                <span class="material-symbols-outlined notranslate text-sm" translate="no">send</span>
                                {{ __('Kirim Ulasan') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- FAQ SECTION --}}
@if(collect($faqs ?? [])->isNotEmpty())
<section class="page-section bg-slate-50">
    <div class="content-container max-w-3xl">
        <div class="text-center mb-14">
            <span class="section-kicker mx-auto w-fit">F.A.Q</span>
            <h2 class="section-title">{{ __('Pertanyaan') }}<br><span class="gradient-text">Yang Sering Diajukan</span></h2>
            <p class="text-slate-500">{{ __('Pertanyaan umum tentang layanan Rakira Digital.') }}</p>
        </div>

        <div class="space-y-4">
            @foreach($faqs as $index => $faq)
            @php
                $faqQuestion = __t(is_array($faq) ? ($faq['question'] ?? $faq['title'] ?? '') : (is_object($faq) ? ($faq->question ?? $faq->title ?? '') : ''));
                $faqAnswer = __t(is_array($faq) ? ($faq['answer'] ?? '') : (is_object($faq) ? ($faq->answer ?? '') : ''));
            @endphp
            <details class="faq-item group">
                <summary>
                    <span class="font-semibold text-slate-800 group-open:text-white transition-colors pr-3 text-sm md:text-base">{{ $faqQuestion }}</span>
                    <span class="faq-icon material-symbols-outlined notranslate text-slate-400 group-open:text-white transition-all" translate="no">add</span>
                </summary>
                <div class="faq-answer px-6 pb-6 text-slate-500 text-sm leading-relaxed transition-colors">
                    {{ $faqAnswer }}
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FORM KONSULTASI --}}
<section class="page-section bg-white" id="kontak">
    <div class="content-container grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-start">
        <div class="space-y-6">
            <span class="section-kicker">{{ __('Konsultasi Gratis') }}</span>
            <h2 class="section-title">{{ __('Mulai Proyek') }}<br><span class="gradient-text">Digital Anda Sekarang</span></h2>
            <p class="text-slate-500 leading-relaxed">
                {{ __('Isi formulir dan tim Rakira Digital akan menghubungi Anda dalam 1×24 jam untuk membahas kebutuhan proyek Anda.') }}
            </p>
            <div class="space-y-5 pt-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#e0f4ff] to-[#e0f4ff]/50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined notranslate text-[#009fe3] text-xl" translate="no">schedule</span>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">{{ __('Respons Cepat') }}</p>
                        <p class="text-slate-400 text-sm">{{ __('Balasan dalam 1×24 jam kerja') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#e0f4ff] to-[#e0f4ff]/50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined notranslate text-[#009fe3] text-xl" translate="no">verified</span>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">{{ __('Konsultasi Gratis') }}</p>
                        <p class="text-slate-400 text-sm">{{ __('Diskusi awal 100% gratis') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#e0f4ff] to-[#e0f4ff]/50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined notranslate text-[#009fe3] text-xl" translate="no">lock</span>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">{{ __('Data Aman') }}</p>
                        <p class="text-slate-400 text-sm">{{ __('Informasi Anda terjaga kerahasiaannya') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-700">
                <span class="material-symbols-outlined notranslate text-green-600" translate="no">check_circle</span>
                {{ __(session('success')) }}
            </div>
            @endif

            <form action="{{ route('konsultasi.store') }}" method="POST" class="surface-card rounded-2xl p-7 md:p-8 space-y-5">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Nama Lengkap *') }}</label>
                    <input type="text" name="sender_name" value="{{ old('sender_name') }}" required
                        class="form-input" placeholder="{{ __('Nama lengkap Anda') }}">
                    @error('sender_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Email Aktif *') }}</label>
                    <input type="email" name="sender_email" value="{{ old('sender_email') }}" required
                        class="form-input" placeholder="{{ __('email@anda.com') }}">
                    @error('sender_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('No. WhatsApp *') }}</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="form-input" placeholder="08xx-xxxx-xxxx">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Layanan yang Dibutuhkan *') }}</label>
                    <select name="service" required class="form-input bg-white">
                        <option value="">-- {{ __('Pilih Layanan') }} --</option>
                        @foreach($services as $srv)
                            @php $srvTitle = __t(is_array($srv) ? ($srv['title'] ?? '') : ($srv->title ?? '')); @endphp
                            @if($srvTitle)
                                <option value="{{ $srvTitle }}" {{ old('service') == $srvTitle ? 'selected' : '' }}>{{ $srvTitle }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('service') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">{{ __('Pesan Tambahan') }}</label>
                    <textarea name="message_body" rows="3" class="form-input resize-none"
                        placeholder="{{ __('Ceritakan tentang proyek Anda...') }}">{{ old('message_body') }}</textarea>
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-3.5">
                    <span class="material-symbols-outlined notranslate text-sm" translate="no">send</span>
                    {{ __('Kirim Konsultasi') }}
                </button>
            </form>
        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="page-section bg-slate-50">
    <div class="content-container max-w-5xl">
        <div class="bg-gradient-to-br from-[#006491] to-[#009fe3] rounded-2xl p-12 md:p-16 text-center text-white shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 bg-white/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4 animate-pulse" style="animation-delay: 2s"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-5">{{ __('Siap Mewujudkan Ide Digital Anda?') }}</h2>
                <p class="text-white/85 max-w-2xl mx-auto mb-8 leading-relaxed">
                    {{ __('Jadwalkan konsultasi gratis dengan tim expert Rakira Digital hari ini.') }}
                </p>
                <a href="{{ $whatsAppUrl ?? '#kontak' }}" target="_blank" class="inline-flex items-center gap-3 bg-white text-[#009fe3] font-bold px-10 py-4 rounded-xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    {{ __('Mulai Proyek Sekarang') }}
                    <span class="material-symbols-outlined notranslate" translate="no">arrow_forward</span>
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
        // Initialize Swiper
        new Swiper('.testimonial-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.testimonial-swiper .swiper-pagination', clickable: true, dynamicBullets: true },
            navigation: { nextEl: '.swiper-next', prevEl: '.swiper-prev' },
            breakpoints: { 
                640: { slidesPerView: 1.2 }, 
                768: { slidesPerView: 2 }, 
                1024: { slidesPerView: 3 } 
            }
        });

        // Initialize Layanan Swiper
        new Swiper('.layanan-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: false,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.layanan-swiper .swiper-pagination', clickable: true, dynamicBullets: true },
            navigation: { nextEl: '.layanan-next', prevEl: '.layanan-prev' },
            breakpoints: { 
                640: { slidesPerView: 1.5 }, 
                768: { slidesPerView: 2 }, 
                1024: { slidesPerView: 3 } 
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        
        // Fade-up animation on scroll
        const fadeElements = document.querySelectorAll('.interactive-card, .surface-card, .faq-item, .testimonial-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        
        fadeElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1)';
            observer.observe(el);
        });
    });
</script>
@endpush