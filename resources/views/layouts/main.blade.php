<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth{{ app()->getLocale() === 'en' ? ' notranslate' : '' }}"{!! app()->getLocale() === 'en' ? ' translate="no"' : '' !!}>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- ============================================================ --}}
    {{-- SEO: Title & Primary Meta Tags --}}
    {{-- ============================================================ --}}
    @php
        $pageTitle       = trim(strip_tags(View::yieldContent('title', ($settings->company_name ?? 'Rakira Digital Nusantara') . ' - Solusi Digital Inovatif')));
        $pageDesc        = trim(strip_tags(View::yieldContent('meta_description', $settings->about_us ?? 'Jasa pembuatan website, aplikasi mobile, dan solusi digital profesional untuk bisnis modern di Indonesia. Dipercaya oleh 100+ klien.')));
        $pageKeywords    = trim(strip_tags(View::yieldContent('meta_keywords', 'jasa pembuatan website, software house indonesia, jasa pembuatan aplikasi android ios, developer aplikasi mobile indonesia, website company profile profesional, jasa desain ui ux, it consultant jakarta, software house tangerang, rakira digital, transformasi digital')));
        $pageImage       = View::yieldContent('og_image', (isset($settings) && $settings->og_image ? asset('storage/' . $settings->og_image) : asset('images/og-rakira.png')));
        $pageType        = View::yieldContent('og_type', 'website');
        $pageUrl         = url()->current();
        $siteName        = $settings->company_name ?? 'Rakira Digital Nusantara';
        $twitterHandle   = '@rakiradigital';
        $pageLocale      = app()->getLocale() === 'en' ? 'en_US' : 'id_ID';
        $pageLocaleAlt   = app()->getLocale() === 'en' ? 'id_ID' : 'en_US';
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ Str::limit($pageDesc, 160) }}">
    <meta name="keywords" content="{{ $pageKeywords }}">
    <meta name="author" content="{{ $siteName }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="google" content="notranslate">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="{{ app()->getLocale() === 'en' ? 'English' : 'Indonesian' }}">
    <meta name="rating" content="general">

    {{-- Canonical & Alternate --}}
    @php
        $basePageUrl = url()->current();
        $canonicalUrl = app()->getLocale() === 'en' ? $basePageUrl . '?lang=en' : $basePageUrl;
    @endphp
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="id" href="{{ $basePageUrl }}">
    <link rel="alternate" hreflang="en" href="{{ $basePageUrl }}?lang=en">
    <link rel="alternate" hreflang="x-default" href="{{ $basePageUrl }}">

    {{-- ============================================================ --}}
    {{-- GEO: Geographic Meta Tags (for local SEO & GEO AI) --}}
    {{-- ============================================================ --}}
    <meta name="geo.region" content="ID-BT">
    <meta name="geo.placename" content="Tangerang, Banten, Indonesia">
    <meta name="geo.position" content="-6.1781;106.6298">
    <meta name="ICBM" content="-6.1781, 106.6298">
    <meta name="DC.title" content="{{ $pageTitle }}">
    <meta name="DC.description" content="{{ Str::limit($pageDesc, 160) }}">
    <meta name="DC.language" content="{{ app()->getLocale() }}">
    <meta name="DC.coverage" content="Indonesia">

    {{-- ============================================================ --}}
    {{-- GEO: AI Generative Engine Optimization (GEO) Hints --}}
    {{-- ============================================================ --}}
    <meta name="classification" content="Business, Technology, Software Development">
    <meta name="category" content="Software House, IT Services, Digital Agency">
    <meta name="coverage" content="Indonesia, Southeast Asia">
    <meta name="target" content="Bisnis, UMKM, Startup, Enterprise">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    {{-- ============================================================ --}}
    {{-- Open Graph (Facebook, LinkedIn, WhatsApp) --}}
    {{-- ============================================================ --}}
    <meta property="og:type" content="{{ $pageType }}">
    <meta property="og:url" content="{{ $pageUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ Str::limit($pageDesc, 200) }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $pageTitle }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="{{ $pageLocale }}">
    <meta property="og:locale:alternate" content="{{ $pageLocaleAlt }}">
    @stack('og_tags')

    {{-- ============================================================ --}}
    {{-- Twitter Card --}}
    {{-- ============================================================ --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $twitterHandle }}">
    <meta name="twitter:creator" content="{{ $twitterHandle }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ Str::limit($pageDesc, 200) }}">
    <meta name="twitter:image" content="{{ $pageImage }}">
    <meta name="twitter:image:alt" content="{{ $pageTitle }}">

    {{-- ============================================================ --}}
    {{-- Google Search Console Verification --}}
    {{-- Replace YOUR_VERIFICATION_CODE with your actual code from GSC --}}
    {{-- ============================================================ --}}
    @if(config('seo.google_site_verification'))
        <meta name="google-site-verification" content="{{ config('seo.google_site_verification') }}">
    @endif
    @if(config('seo.bing_site_verification'))
        <meta name="msvalidate.01" content="{{ config('seo.bing_site_verification') }}">
    @endif

    {{-- ============================================================ --}}
    {{-- Structured Data JSON-LD (Organization + WebSite + LocalBusiness) --}}
    {{-- ============================================================ --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "Organization",
          "@@id": "{{ url('/') }}/#organization",
          "name": "{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}",
          "alternateName": ["Rakira Digital", "Rakira"],
          "url": "{{ url('/') }}",
          "logo": {
            "@@type": "ImageObject",
            "url": "{{ isset($settings) && $settings->logo_path ? asset('storage/' . $settings->logo_path) : asset('images/logo-rakira.png') }}",
            "width": 200,
            "height": 60
          },
          "description": "{{ Str::limit($settings->about_us ?? 'Jasa pembuatan website profesional, aplikasi mobile, dan solusi IT untuk bisnis Indonesia.', 200) }}",
          "foundingDate": "2020",
          "numberOfEmployees": { "@@type": "QuantitativeValue", "value": 15 },
          "areaServed": ["Indonesia", "Southeast Asia"],
          "serviceArea": {
            "@@type": "GeoCircle",
            "geoMidpoint": { "@@type": "GeoCoordinates", "latitude": -6.1781, "longitude": 106.6298 },
            "geoRadius": "500000"
          },
          "contactPoint": [
            {
              "@@type": "ContactPoint",
              "telephone": "+{{ $settings->phone ?? '6287868184742' }}",
              "contactType": "customer service",
              "areaServed": "ID",
              "availableLanguage": ["id", "en"],
              "hoursAvailable": {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "opens": "09:00",
                "closes": "17:00"
              }
            }
          ],
          "address": {
            "@@type": "PostalAddress",
            "streetAddress": "{{ $settings->address ?? 'Tangerang' }}",
            "addressLocality": "Tangerang",
            "addressRegion": "Banten",
            "postalCode": "15111",
            "addressCountry": "ID"
          },
          "email": "{{ $settings->email ?? 'info@rakiradigital.com' }}",
          "sameAs": [
            "https://www.instagram.com/rakiradigital",
            "https://wa.me/{{ $settings->phone ?? '6287868184742' }}"
          ]
        },
        {
          "@@type": "LocalBusiness",
          "@@id": "{{ url('/') }}/#localbusiness",
          "name": "{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}",
          "image": "{{ isset($settings) && $settings->logo_path ? asset('storage/' . $settings->logo_path) : asset('images/logo-rakira.png') }}",
          "url": "{{ url('/') }}",
          "telephone": "+{{ $settings->phone ?? '6287868184742' }}",
          "email": "{{ $settings->email ?? 'info@rakiradigital.com' }}",
          "priceRange": "Rp Rp Rp",
          "openingHours": "Mo-Fr 09:00-17:00",
          "address": {
            "@@type": "PostalAddress",
            "streetAddress": "{{ $settings->address ?? 'Tangerang' }}",
            "addressLocality": "Tangerang",
            "addressRegion": "Banten",
            "addressCountry": "ID"
          },
          "geo": {
            "@@type": "GeoCoordinates",
            "latitude": -6.1781,
            "longitude": 106.6298
          },
          "hasMap": "https://maps.google.com/?q=Tangerang,Banten,Indonesia",
          "paymentAccepted": "Transfer Bank, Dana, OVO, GoPay",
          "currenciesAccepted": "IDR"
        },
        {
          "@@type": "WebSite",
          "@@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "{{ $siteName }}",
          "description": "{{ Str::limit($pageDesc, 160) }}",
          "publisher": { "@@id": "{{ url('/') }}/#organization" },
          "inLanguage": ["id-ID", "en-US"],
          "potentialAction": {
            "@@type": "SearchAction",
            "target": {
              "@@type": "EntryPoint",
              "urlTemplate": "{{ url('/blog') }}?q={search_term_string}"
            },
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@@type": "WebPage",
          "@@id": "{{ $pageUrl }}/#webpage",
          "url": "{{ $pageUrl }}",
          "name": "{{ $pageTitle }}",
          "description": "{{ Str::limit($pageDesc, 160) }}",
          "isPartOf": { "@@id": "{{ url('/') }}/#website" },
          "about": { "@@id": "{{ url('/') }}/#organization" },
          "inLanguage": "{{ $pageLocale }}",
          "dateModified": "{{ now()->toIso8601String() }}"
        }
      ]
    }
    </script>
    @stack('structured_data')

    {{-- ============================================================ --}}
    {{-- Google Tag Manager (GTM) - loads GA4 + other tags --}}
    {{-- Replace GTM-XXXXXXX with your actual GTM container ID --}}
    {{-- ============================================================ --}}
    @php
        $ga4_id = (isset($settings) && $settings->google_analytics_id) ? $settings->google_analytics_id : config('seo.ga4_id');
        $fb_pixel_id = (isset($settings) && $settings->facebook_pixel_id) ? $settings->facebook_pixel_id : null;
    @endphp

    @if(config('seo.gtm_id'))
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ config("seo.gtm_id") }}');</script>
    @elseif($ga4_id)
    {{-- Direct GA4 (if not using GTM) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4_id }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $ga4_id }}', {
        page_title: '{{ $pageTitle }}',
        page_location: '{{ $pageUrl }}',
        send_page_view: true
      });
    </script>
    @endif

    {{-- Facebook Pixel --}}
    @if($fb_pixel_id)
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $fb_pixel_id }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $fb_pixel_id }}&ev=PageView&noscript=1"/></noscript>
    @endif

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-rakira.png') }}">
    <meta name="theme-color" content="#0a88b2">
    <meta name="msapplication-TileColor" content="#0a88b2">

    {{-- Fonts (preload for performance) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* ========================================
           BRAND COLOR VARIABLES
        ======================================== */
        :root {
            --primary: #0a88b2;
            --primary-dark: #086d8f;
            --primary-light: #2ba0cc;
            --primary-soft: #cceef7;
            --primary-gradient: linear-gradient(135deg, #0a88b2, #2ba0cc);
            --primary-gradient-hover: linear-gradient(135deg, #086d8f, #0a88b2);
            --bg-radial: radial-gradient(circle at 10% 20%, rgba(10,136,178,0.03) 0%, transparent 80%);
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Smooth Scroll & scroll padding for fixed header */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }
        
        body {
            background: #ffffff;
            position: relative;
        }
        
        /* Subtle background pattern for depth */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-radial);
            pointer-events: none;
            z-index: 0;
        }
        
        main {
            position: relative;
            z-index: 1;
        }
        
        /* ========================================
           FLOATING NAVBAR (Premium)
        ======================================== */
        .floating-navbar {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 48px);
            max-width: 1280px;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(24px);
            box-shadow: 0 8px 28px -6px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(10, 136, 178, 0.2);
        }
        
        .floating-navbar.scrolled {
            top: 12px;
            width: calc(100% - 32px);
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 12px 32px -8px rgba(0, 0, 0, 0.12);
            border-color: rgba(10, 136, 178, 0.3);
        }
        
        .navbar-container {
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        @media (max-width: 768px) {
            .floating-navbar {
                top: 16px;
                width: calc(100% - 24px);
                border-radius: 60px;
            }
            .navbar-container {
                padding: 10px 20px;
            }
        }
        
        /* Logo Styling with hover effect */
        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .logo-wrapper:hover {
            transform: scale(1.02);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .logo-text {
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        
        .logo-text span {
            background: var(--primary-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        
        /* Nav Link Styling - Elegant underline */
        .nav-link {
            position: relative;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding: 6px 0;
            color: #334155;
            text-decoration: none;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2.5px;
            background: var(--primary-gradient);
            transition: width 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border-radius: 2px;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .nav-link.active {
            color: var(--primary);
            font-weight: 600;
        }
        
        /* Button Styling - gradient, smooth */
        .btn-floating {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 10px 26px;
            border-radius: 60px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 6px 14px rgba(10, 136, 178, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        
        .btn-floating:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(10, 136, 178, 0.35);
            background: var(--primary-gradient-hover);
        }
        
        /* Language Switcher */
        .lang-switch-floating {
            background: #f0f4f9;
            border-radius: 60px;
            padding: 4px;
            display: flex;
            gap: 4px;
            backdrop-filter: blur(4px);
        }
        
        .lang-option-floating {
            padding: 6px 18px;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.2s ease;
            cursor: pointer;
            color: #475569;
            text-decoration: none;
        }
        
        .lang-option-floating.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 8px rgba(10, 136, 178, 0.3);
        }
        
        .lang-option-floating:not(.active):hover {
            background: rgba(10, 136, 178, 0.1);
            color: var(--primary);
        }
        
        /* Mobile Menu Toggle */
        .menu-toggle-floating {
            width: 44px;
            height: 44px;
            background: #f0f4f9;
            border-radius: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .menu-toggle-floating span {
            width: 20px;
            height: 2px;
            background: #1e293b;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .menu-toggle-floating.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
            background: var(--primary);
        }
        
        .menu-toggle-floating.active span:nth-child(2) {
            opacity: 0;
        }
        
        .menu-toggle-floating.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
            background: var(--primary);
        }
        
        /* Mobile Overlay */
        .mobile-overlay-floating {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .mobile-overlay-floating.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Mobile Panel - Premium Redesign */
        .mobile-panel-floating {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 380px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            z-index: 1002;
            transition: right 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            padding: 0;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
            border-left: 1px solid rgba(10, 136, 178, 0.2);
            display: flex;
            flex-direction: column;
        }

        .mobile-panel-floating.active {
            right: 0;
        }

        /* Header Panel */
        .mobile-panel-header {
            padding: 24px 24px 16px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.8);
        }

        .mobile-panel-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-panel-logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .mobile-panel-logo h3 {
            font-weight: 800;
            font-size: 1.2rem;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .mobile-panel-logo span {
            background: var(--primary-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .close-panel-btn {
            width: 36px;
            height: 36px;
            background: #f1f5f9;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #475569;
        }

        .close-panel-btn:hover {
            background: var(--primary);
            color: white;
            transform: rotate(90deg);
        }

        /* Menu Items */
        .mobile-menu-items {
            flex: 1;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-link-floating {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 16px;
            border-radius: 16px;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .mobile-link-floating:hover {
            background: rgba(10, 136, 178, 0.08);
            color: var(--primary);
            transform: translateX(6px);
        }

        .mobile-link-floating .material-symbols-outlined {
            font-size: 24px;
            color: var(--primary);
        }

        /* Bottom Section */
        .mobile-panel-bottom {
            padding: 24px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background: rgba(255, 255, 255, 0.6);
        }

        /* Language Switcher inside panel */
        .mobile-lang-switch {
            display: flex;
            gap: 8px;
            background: #f1f5f9;
            border-radius: 50px;
            padding: 4px;
            margin-bottom: 20px;
        }

        .mobile-lang-option {
            flex: 1;
            text-align: center;
            padding: 8px 12px;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.2s;
            text-decoration: none;
            color: #475569;
        }

        .mobile-lang-option.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 8px rgba(10,136,178,0.3);
        }

        .mobile-lang-option:not(.active):hover {
            background: rgba(10,136,178,0.1);
            color: var(--primary);
        }

        /* Button in panel */
        .mobile-panel-bottom .btn-floating {
            width: 100%;
            justify-content: center;
            padding: 12px;
            font-size: 0.9rem;
        }
        
        /* Progress Bar - smooth */
        .progress-bar-floating {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: var(--primary-gradient);
            z-index: 1003;
            transition: width 0.12s ease-out;
            box-shadow: 0 0 8px rgba(10,136,178,0.5);
        }
        
        /* ========================================
           PREMIUM FOOTER with glass effect
        ======================================== */
        .footer-premium {
            background: linear-gradient(145deg, #0f172a 0%, #1e293b 100%);
            padding: 70px 0 35px;
            margin-top: 60px;
            position: relative;
            border-top-left-radius: 32px;
            border-top-right-radius: 32px;
        }
        
        .footer-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 40px;
            right: 40px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 3px;
        }
        
        .footer-link {
            color: #94a3b8;
            transition: all 0.25s ease;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        
        .footer-link:hover {
            color: var(--primary-light);
            transform: translateX(5px);
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-4px) scale(1.08);
            border-color: transparent;
        }
        
        .social-icon svg {
            transition: color 0.2s;
        }
        
        .social-icon:hover svg {
            color: white;
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 28px;
            left: 28px;
            width: 44px;
            height: 44px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 999;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            opacity: 0;
            visibility: hidden;
            border: 1px solid rgba(10,136,178,0.3);
        }
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            transform: translateY(-4px);
            background: var(--primary);
            border-color: transparent;
        }
        
        .back-to-top:hover span {
            color: white;
        }
        
        /* ========================================
           PROFESSIONAL CHAT WIDGET - Enhanced
        ======================================== */
        .chat-widget-premium {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 1000;
        }
        
        .chat-button-premium {
            width: 56px;
            height: 56px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 6px 20px rgba(10, 136, 178, 0.4);
            border: none;
        }
        
        .chat-button-premium:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 28px rgba(10, 136, 178, 0.5);
        }
        
        .chat-tooltip-premium {
            position: absolute;
            bottom: 70px;
            right: 8px;
            background: #1e293b;
            padding: 10px 18px;
            border-radius: 28px;
            font-size: 0.75rem;
            font-weight: 500;
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: all 0.25s ease;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.2px;
        }
        
        .chat-tooltip-premium::after {
            content: '';
            position: absolute;
            bottom: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: #1e293b;
            transform: rotate(45deg);
        }
        
        .chat-tooltip-premium.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .chat-panel-premium {
            position: absolute;
            bottom: 76px;
            right: 0;
            width: 400px;
            max-width: calc(100vw - 32px);
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(16px) scale(0.98);
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border: 1px solid #eef2f6;
        }
        
        .chat-panel-premium.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        
        .chat-header-premium {
            background: #0a88b2;
            padding: 1.25rem 1.25rem;
        }
        
        .chat-status {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse-subtle 1.5s infinite;
        }
        
        @keyframes pulse-subtle {
            0% { opacity: 0.6; transform: scale(0.95); }
            50% { opacity: 1; transform: scale(1.05); }
            100% { opacity: 0.6; transform: scale(0.95); }
        }
        
        .chat-header-title {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: rgba(255,255,255,0.85);
            text-transform: uppercase;
        }
        
        .close-chat-btn {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            padding: 6px;
            border-radius: 30px;
            transition: all 0.2s;
        }
        
        .close-chat-btn:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        
        .agent-avatar {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.2);
            border-radius: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .agent-avatar span {
            font-size: 1.4rem;
            font-weight: 600;
            color: white;
        }
        
        .chat-form-container {
            padding: 1.5rem;
            background: white;
        }
        
        .form-field {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            color: #5b6e7c;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-icon-simple {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
        }
        
        .textarea-icon-simple {
            position: absolute;
            left: 14px;
            top: 16px;
            color: #94a3b8;
            font-size: 1rem;
        }
        
        .chat-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            font-size: 0.85rem;
            background: #fefefe;
            transition: all 0.2s;
            outline: none;
            font-family: 'Inter', sans-serif;
        }
        
        .chat-input:focus {
            border-color: #0a88b2;
            box-shadow: 0 0 0 3px rgba(10,136,178,0.1);
            background: white;
        }
        
        textarea.chat-input {
            padding-top: 0.75rem;
            resize: vertical;
        }
        
        .submit-chat-btn {
            width: 100%;
            background: #0a88b2;
            border: none;
            border-radius: 50px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }
        
        .submit-chat-btn:hover {
            background: #086d8f;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(10,136,178,0.3);
        }
        
        .divider-custom {
            margin: 1.25rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #cbd5e1;
            font-size: 0.7rem;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background: #edf2f7;
        }
        
        .social-chat-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .social-chat-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.7rem;
            border: 1px solid #e2edf2;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            color: #385f6e;
            transition: all 0.2s;
            background: white;
        }
        
        .social-chat-btn:hover {
            border-color: #0a88b2;
            background: #f8fcff;
            color: #0a88b2;
        }
        
        @media (max-width: 480px) {
            .chat-panel-premium {
                width: calc(100vw - 32px);
                right: -8px;
                bottom: 76px;
            }
            .chat-tooltip-premium {
                display: none;
            }
        }
        
        .notification-toast {
            position: fixed;
            bottom: 100px;
            right: 28px;
            background: #1e293b;
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            z-index: 1100;
            opacity: 0;
            transform: translateY(12px);
            transition: all 0.2s;
            pointer-events: none;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }
        
        .notification-toast.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Utility Classes */
        .fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased bg-white">
    {{-- Google Tag Manager (noscript) --}}
    @if(config('seo.gtm_id'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('seo.gtm_id') }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <!-- Progress Bar -->
    <div class="progress-bar-floating" id="progressBar"></div>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay-floating" id="mobileOverlay"></div>

    <!-- Floating Navbar -->
    <nav class="floating-navbar" id="floatingNavbar">
        <div class="navbar-container">
            <a href="/" class="logo-wrapper">
                <div class="logo-icon">
                    <img src="/images/logo-rakira.png" alt="Rakira Digital">
                </div>
                <div class="logo-text">
                    Rakira <span>Digital</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Beranda') }}</a>
                <a href="/layanan" class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}">{{ __('Layanan') }}</a>
                <a href="/portofolio" class="nav-link {{ request()->is('portofolio*') ? 'active' : '' }}">{{ __('Portofolio') }}</a>
                <a href="/tentang-kami" class="nav-link {{ request()->is('tentang-kami*') ? 'active' : '' }}">{{ __('Tentang Kami') }}</a>
                <a href="/blog" class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">{{ __('Blog') }}</a>
            </div>

            <div class="hidden md:flex items-center gap-5">
                <div class="lang-switch-floating">
                    <a href="{{ route('lang.switch', 'id') }}" 
                       class="lang-option-floating {{ app()->getLocale() == 'id' ? 'active' : '' }} notranslate" translate="no">
                        ID
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" 
                       class="lang-option-floating {{ app()->getLocale() == 'en' ? 'active' : '' }} notranslate" translate="no">
                        EN
                    </a>
                </div>
                
                <a href="{{ url('/#kontak') }}" class="btn-floating">
                    <span>{{ __('Konsultasi Gratis') }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

            <div class="menu-toggle-floating md:hidden" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Mobile Panel - Improved -->
    <div class="mobile-panel-floating" id="mobilePanel">
        <div class="mobile-panel-header">
            <div class="mobile-panel-logo">
                <img src="/images/logo-rakira.png" alt="Rakira Digital">
                <h3>Rakira <span>Digital</span></h3>
            </div>
            <div class="close-panel-btn" id="closePanelBtn">
                <span class="material-symbols-outlined notranslate" translate="no">close</span>
            </div>
        </div>

        <div class="mobile-menu-items">
            <a href="/" class="mobile-link-floating">
                <span class="material-symbols-outlined notranslate" translate="no">home</span>
                <span>{{ __('Beranda') }}</span>
            </a>
            <a href="/layanan" class="mobile-link-floating">
                <span class="material-symbols-outlined notranslate" translate="no">design_services</span>
                <span>{{ __('Layanan') }}</span>
            </a>
            <a href="/portofolio" class="mobile-link-floating">
                <span class="material-symbols-outlined notranslate" translate="no">folder</span>
                <span>{{ __('Portofolio') }}</span>
            </a>
            <a href="/tentang-kami" class="mobile-link-floating">
                <span class="material-symbols-outlined notranslate" translate="no">info</span>
                <span>{{ __('Tentang Kami') }}</span>
            </a>
            <a href="/blog" class="mobile-link-floating">
                <span class="material-symbols-outlined notranslate" translate="no">article</span>
                <span>{{ __('Blog') }}</span>
            </a>
        </div>

        <div class="mobile-panel-bottom">
            <div class="mobile-lang-switch">
                <a href="{{ route('lang.switch', 'id') }}" 
                   class="mobile-lang-option {{ app()->getLocale() == 'id' ? 'active' : '' }} notranslate" translate="no">
                    ID
                </a>
                <a href="{{ route('lang.switch', 'en') }}" 
                   class="mobile-lang-option {{ app()->getLocale() == 'en' ? 'active' : '' }} notranslate" translate="no">
                    EN
                </a>
            </div>
            <a href="{{ url('/#kontak') }}" class="btn-floating">
                <span>{{ __('Konsultasi Gratis') }}</span>
                <span class="material-symbols-outlined notranslate" translate="no">arrow_forward</span>
            </a>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Premium Footer -->
    <footer class="footer-premium">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="{{ isset($settings) && $settings->logo_path ? asset('storage/' . $settings->logo_path) : asset('images/logo-rakira.png') }}" class="w-10 h-10 object-contain" alt="Logo">
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ $settings->company_name ?? 'Rakira Digital' }}</h3>
                            <span class="text-xs text-primary-light">Digital Solutions</span>
                        </div>
                    </div>
                    @if(isset($settings) && $settings->motto)
                        <p class="text-slate-400 text-sm mb-4 italic border-l-2 border-primary pl-4">"{{ $settings->motto }}"</p>
                    @endif
                    <p class="text-slate-400 text-sm leading-relaxed">
                        {{ Str::limit($settings->about_us ?? 'Solusi teknologi premium untuk bisnis modern. Pengembangan web, aplikasi kustom, dan transformasi digital yang scalable.', 120) }}
                    </p>
                    
                    <div class="flex gap-3 mt-6">
                        @if(isset($settings) && $settings->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank" class="social-icon">
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if(isset($settings) && $settings->facebook_url)
                        <a href="{{ $settings->facebook_url }}" target="_blank" class="social-icon">
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        @endif

                        @if(isset($settings) && $settings->linkedin_url)
                        <a href="{{ $settings->linkedin_url }}" target="_blank" class="social-icon">
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        @endif

                        <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}" target="_blank" class="social-icon">
                            <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.032 1.963c-5.524 0-10 4.476-10 10 0 1.783.476 3.46 1.308 4.918L1.99 21.01l4.184-1.318a9.954 9.954 0 004.858 1.278c5.524 0 10-4.476 10-10s-4.476-10-10-10zm0 18.5c-1.605 0-3.12-.43-4.441-1.238l-.318-.192-2.86.902.974-2.666-.226-.33a8.508 8.508 0 01-1.331-4.476c0-4.688 3.812-8.5 8.5-8.5s8.5 3.812 8.5 8.5-3.812 8.5-8.5 8.5zm4.849-6.824c-.266-.133-1.579-.779-1.825-.868-.246-.089-.425-.133-.604.133-.179.266-.697.868-.854 1.046-.157.178-.315.2-.58.067-.266-.133-1.12-.413-2.133-1.318-.789-.705-1.322-1.576-1.477-1.842-.155-.267-.016-.411.117-.544.119-.119.267-.311.4-.467.133-.156.178-.267.267-.445.089-.178.044-.334-.022-.467-.067-.133-.604-1.456-.828-1.993-.218-.523-.44-.452-.604-.46l-.52-.008c-.178 0-.467.066-.711.333-.244.267-.933.911-.933 2.222 0 1.311.955 2.578 1.088 2.756.133.178 1.88 2.869 4.553 4.022.636.274 1.133.437 1.52.56.639.2 1.22.171 1.68.103.514-.076 1.58-.646 1.802-1.27.222-.624.222-1.158.156-1.27-.067-.111-.244-.178-.51-.311z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold text-sm mb-5 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1 h-4 bg-primary rounded-full"></span>
                        Layanan
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="/layanan" class="footer-link">Web Development</a></li>
                        <li><a href="/layanan" class="footer-link">Mobile Apps</a></li>
                        <li><a href="/layanan" class="footer-link">UI/UX Design</a></li>
                        <li><a href="/layanan" class="footer-link">IT Consulting</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-sm mb-5 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1 h-4 bg-primary rounded-full"></span>
                        Perusahaan
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="/tentang-kami" class="footer-link">Tentang Kami</a></li>
                        <li><a href="/portofolio" class="footer-link">Portofolio</a></li>
                        <li><a href="/blog" class="footer-link">Blog</a></li>
                        <li><a href="#" class="footer-link">Karir</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-sm mb-5 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1 h-4 bg-primary rounded-full"></span>
                        Kontak
                    </h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3 text-slate-400 text-sm">
                            <span class="material-symbols-outlined text-primary text-base" translate="no">location_on</span>
                            <span>{{ $settings->address ?? 'Tangerang, Indonesia' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-base" translate="no">mail</span>
                            <a href="mailto:{{ $settings->email ?? 'info@rakira.com' }}" class="footer-link">{{ $settings->email ?? 'info@rakira.com' }}</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-base" translate="no">phone</span>
                            <a href="tel:{{ $settings->phone ?? '+6287868184742' }}" class="footer-link">{{ $settings->phone ?? '+62 878-6818-4742' }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-xs">
                <div>
                    &copy; {{ date('Y') }} {{ $settings->company_name ?? 'Rakira Digital Nusantara' }}. All rights reserved.
                </div>
                <div class="flex gap-6">
                    <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <div class="back-to-top" id="backToTop">
        <span class="material-symbols-outlined text-primary text-xl notranslate" translate="no">arrow_upward</span>
    </div>

    <!-- Professional Chat Widget -->
    <div class="chat-widget-premium" id="chatWidget">
        <div class="chat-button-premium" id="chatButton">
            <span class="material-symbols-outlined text-white text-2xl notranslate" translate="no" id="chatIcon">chat</span>
        </div>

        <div class="chat-tooltip-premium" id="chatTooltip">
            <div class="flex items-center gap-2">
                <div class="status-dot"></div>
                <span class="text-xs font-medium">Butuh bantuan? Konsultasi bisnis</span>
            </div>
        </div>

        <div class="chat-panel-premium" id="chatPanel">
            <div class="chat-header-premium">
                <div class="flex items-center justify-between mb-3">
                    <div class="chat-status">
                        <div class="status-dot"></div>
                        <span class="chat-header-title">ONLINE SUPPORT</span>
                    </div>
                    <button id="closeChatBtn" class="close-chat-btn">
                        <span class="material-symbols-outlined text-lg notranslate" translate="no">close</span>
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <div class="agent-avatar">
                        <span>RD</span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-base">Tim Rakira Digital</h4>
                        <p class="text-white/80 text-xs">Siap membantu kebutuhan digital Anda</p>
                    </div>
                </div>
            </div>

            <div class="chat-form-container">
                <form action="{{ route('konsultasi.store') }}" method="POST" id="consultationFormWidget">
                    @csrf
                    <input type="hidden" name="sender_email" value="chat-widget@rakira.com">
                    <input type="hidden" name="service" value="Live Chat Consultation">

                    <div class="form-field">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-with-icon">
                            <span class="input-icon-simple material-symbols-outlined notranslate" translate="no">person</span>
                            <input type="text" name="sender_name" required placeholder="Nama lengkap" class="chat-input" id="chatName">
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label">WhatsApp</label>
                        <div class="input-with-icon">
                            <span class="input-icon-simple material-symbols-outlined notranslate" translate="no">phone</span>
                            <input type="text" name="phone" required placeholder="0812-3456-7890" class="chat-input" id="chatPhone">
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label">Pesan</label>
                        <div class="input-with-icon">
                            <span class="textarea-icon-simple material-symbols-outlined notranslate" translate="no">chat</span>
                            <textarea name="message_body" required placeholder="Tulis pertanyaan Anda..." rows="3" class="chat-input" id="chatMessage"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="submit-chat-btn">
                        <span>Kirim Pesan</span>
                        <span class="material-symbols-outlined text-sm notranslate" translate="no">send</span>
                    </button>
                </form>

                <div class="divider-custom">
                    <div class="divider-line"></div>
                    <span>atau hubungi langsung</span>
                    <div class="divider-line"></div>
                </div>

                <div class="social-chat-links">
                    <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}" target="_blank" class="social-chat-btn">
                        <span class="material-symbols-outlined text-sm notranslate" translate="no">chat</span>
                        <span>WhatsApp</span>
                    </a>
                    <a href="https://www.instagram.com/rakiradigital" target="_blank" class="social-chat-btn">
                        <span class="material-symbols-outlined text-sm notranslate" translate="no">photo_camera</span>
                        <span>Instagram</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="notificationToast" class="notification-toast"></div>

    @stack('scripts')

    {{-- Google Tag Manager (noscript) fallback --}}
    @if(config('seo.gtm_id'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('seo.gtm_id') }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <script>
        // DOM Elements
        const floatingNavbar = document.getElementById('floatingNavbar');
        const progressBar = document.getElementById('progressBar');
        const backToTop = document.getElementById('backToTop');
        
        // Scroll handling: navbar, progress, back-to-top
        window.addEventListener('scroll', () => {
            // Navbar shrink
            if (window.scrollY > 30) {
                floatingNavbar?.classList.add('scrolled');
            } else {
                floatingNavbar?.classList.remove('scrolled');
            }
            
            // Progress bar
            const winScroll = document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            if (progressBar) progressBar.style.width = scrolled + '%';
            
            // Back to top button visibility
            if (window.scrollY > 400) {
                backToTop?.classList.add('show');
            } else {
                backToTop?.classList.remove('show');
            }
        });
        
        // Back to top click
        backToTop?.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        // Mobile Menu
        const menuToggle = document.getElementById('menuToggle');
        const mobilePanel = document.getElementById('mobilePanel');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const closePanelBtn = document.getElementById('closePanelBtn');
        
        function openMobileMenu() {
            menuToggle?.classList.add('active');
            mobilePanel?.classList.add('active');
            mobileOverlay?.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileMenu() {
            menuToggle?.classList.remove('active');
            mobilePanel?.classList.remove('active');
            mobileOverlay?.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        menuToggle?.addEventListener('click', openMobileMenu);
        mobileOverlay?.addEventListener('click', closeMobileMenu);
        if (closePanelBtn) closePanelBtn.addEventListener('click', closeMobileMenu);
        document.querySelectorAll('.mobile-link-floating').forEach(link => link.addEventListener('click', closeMobileMenu));
        
        // Chat Widget Logic
        const chatButton = document.getElementById('chatButton');
        const chatPanel = document.getElementById('chatPanel');
        const closeChatBtn = document.getElementById('closeChatBtn');
        const chatTooltip = document.getElementById('chatTooltip');
        const chatIconSpan = document.getElementById('chatIcon');
        const toastNotif = document.getElementById('notificationToast');
        
        function showToast(message, isError = false) {
            if (!toastNotif) return;
            toastNotif.textContent = message;
            toastNotif.classList.add('show');
            setTimeout(() => toastNotif.classList.remove('show'), 2800);
        }
        
        function toggleChat() {
            if (!chatPanel) return;
            chatPanel.classList.toggle('active');
            if (chatTooltip) chatTooltip.classList.remove('active');
            if (chatPanel.classList.contains('active')) {
                if (chatIconSpan) chatIconSpan.textContent = 'close';
            } else {
                if (chatIconSpan) chatIconSpan.textContent = 'chat';
            }
        }
        
        chatButton?.addEventListener('click', toggleChat);
        closeChatBtn?.addEventListener('click', toggleChat);
        
        // Show tooltip after 2 seconds if panel not open
        setTimeout(() => {
            if (chatTooltip && !chatPanel?.classList.contains('active')) {
                chatTooltip.classList.add('active');
                setTimeout(() => chatTooltip?.classList.remove('active'), 5000);
            }
        }, 2000);
        
        // Form validation
        const chatForm = document.getElementById('consultationFormWidget');
        if (chatForm) {
            chatForm.addEventListener('submit', function(e) {
                const name = document.getElementById('chatName')?.value.trim();
                const phone = document.getElementById('chatPhone')?.value.trim();
                const msg = document.getElementById('chatMessage')?.value.trim();
                if (!name || !phone || !msg) {
                    e.preventDefault();
                    showToast('Mohon lengkapi nama, WhatsApp, dan pesan', true);
                    return;
                }
                showToast('Pesan terkirim. Tim kami akan segera merespon.');
            });
        }
    </script>

    {{-- Google reCAPTCHA v3 Anti-Spam (Invisible) --}}
    @if(config('services.recaptcha.site_key'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const siteKey = '{{ config("services.recaptcha.site_key") }}';
            const forms = document.querySelectorAll('form[method="POST"]');
            
            forms.forEach(form => {
                // Jangan protect form logout/delete admin
                if(form.action.includes('logout') || form.querySelector('input[name="_method"]')) return;
                
                form.addEventListener('submit', function(e) {
                    if (!form.dataset.recaptchaProcessed) {
                        e.preventDefault();
                        grecaptcha.ready(function() {
                            grecaptcha.execute(siteKey, {action: 'submit'}).then(function(token) {
                                let input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'g-recaptcha-response';
                                input.value = token;
                                form.appendChild(input);
                                form.dataset.recaptchaProcessed = 'true';
                                form.submit();
                            });
                        });
                    }
                });
            });
        });
    </script>
    @endif
</body>

</html>