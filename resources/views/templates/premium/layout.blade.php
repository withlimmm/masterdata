<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Rakira Premium - Solusi Digital Terdepan')</title>
    <meta name="description" content="@yield('meta_description', $settings->about_us ?? 'Solusi teknologi premium untuk bisnis modern. Pengembangan web, aplikasi kustom, dan transformasi digital yang scalable.')">
    <meta name="keywords" content="@yield('meta_keywords', 'jasa pembuatan website company profile, jasa pembuatan aplikasi android ios, jasa pembuatan web app kustom, developer aplikasi mobile indonesia, software house indonesia, software house jakarta, software house tangerang, it consultant jakarta, konsultan teknologi informasi, jasa desain ui ux profesional, rakira digital')">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}",
      "alternateName": "Rakira Digital",
      "url": "{{ url('/') }}",
      "logo": "{{ isset($settings) && $settings->logo_path ? asset('storage/' . $settings->logo_path) : asset('images/logo-rakira.png') }}",
      "description": "{{ $settings->about_us ?? 'Solusi teknologi premium untuk bisnis modern. Pengembangan web, aplikasi kustom, dan transformasi digital yang scalable.' }}",
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+{{ $settings->phone ?? '6287868184742' }}",
        "contactType": "customer service",
        "areaServed": "ID",
        "availableLanguage": ["id", "en"]
      },
      "sameAs": [
        "https://www.instagram.com/rakiradigital"
      ]
    }
    </script>

    <!-- Google Fonts: Outfit & Sora -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Sora:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #030712; /* Tailwind gray-950 */
            color: #f3f4f6; /* Tailwind gray-100 */
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Sora', sans-serif;
        }
        /* Custom scrollbar for premium theme */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #030712;
        }
        ::-webkit-scrollbar-thumb {
            background: #1f2937;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }
        /* Glassmorphism utility */
        .premium-glass {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .premium-glass-card {
            background: rgba(30, 41, 59, 0.45);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-glass-card:hover {
            background: rgba(30, 41, 59, 0.7);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 20px 40px -15px rgba(59, 130, 246, 0.3);
            transform: translateY(-4px);
        }
        .glow-text-cyan {
            text-shadow: 0 0 20px rgba(6, 182, 212, 0.4);
        }
        .glow-text-indigo {
            text-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }
        .glow-border {
            position: relative;
        }
        .glow-border::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(to bottom right, rgba(59, 130, 246, 0.4), transparent, rgba(168, 85, 247, 0.4));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
    </style>
</head>

<body class="site-shell selection:bg-blue-600 selection:text-white">

    <!-- Floating Top Navigation Bar -->
    <div class="fixed top-4 left-0 z-50 w-full px-4 md:px-8">
        <nav class="mx-auto max-w-7xl premium-glass rounded-2xl shadow-2xl transition-all duration-300">
            <div class="flex h-20 items-center justify-between px-6 md:px-10">
                <a href="/?theme=premium" class="flex items-center gap-3 group">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 shadow-[0_0_20px_rgba(59,130,246,0.5)]">
                        <img src="/images/logo-rakira.png" alt="Rakira Premium" class="h-6 w-6">
                    </div>
                    <span class="text-xl font-black tracking-tight bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">Rakira <span class="text-blue-500 font-normal">Premium</span></span>
                </a>

                <div class="hidden items-center space-x-8 md:flex">
                    <a href="/?theme=premium"
                        class="{{ request()->is('/') ? 'text-blue-400 font-bold border-b border-blue-400' : 'text-slate-300 hover:text-white' }} transition-colors duration-300 py-1 text-sm font-medium">{{ __('Beranda') }}</a>
                    <a href="/layanan?theme=premium"
                        class="{{ request()->is('layanan*') ? 'text-blue-400 font-bold border-b border-blue-400' : 'text-slate-300 hover:text-white' }} transition-colors duration-300 py-1 text-sm font-medium">{{ __('Layanan') }}</a>
                    <a href="/portofolio?theme=premium"
                        class="{{ request()->is('portofolio*') ? 'text-blue-400 font-bold border-b border-blue-400' : 'text-slate-300 hover:text-white' }} transition-colors duration-300 py-1 text-sm font-medium">{{ __('Portofolio') }}</a>
                    <a href="/tentang-kami?theme=premium"
                        class="{{ request()->is('tentang-kami*') ? 'text-blue-400 font-bold border-b border-blue-400' : 'text-slate-300 hover:text-white' }} transition-colors duration-300 py-1 text-sm font-medium">{{ __('Tentang Kami') }}</a>
                    <a href="/blog?theme=premium"
                        class="{{ request()->is('blog*') ? 'text-blue-400 font-bold border-b border-blue-400' : 'text-slate-300 hover:text-white' }} transition-colors duration-300 py-1 text-sm font-medium">{{ __('Blog') }}</a>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <div class="flex items-center gap-2 border border-white/10 rounded-xl px-3 py-1.5 bg-white/5 backdrop-blur-md text-xs font-bold text-white">
                        <a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'text-blue-400' : 'text-slate-400 hover:text-white' }} transition-colors">ID</a>
                        <span class="text-white/20">|</span>
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-blue-400' : 'text-slate-400 hover:text-white' }} transition-colors">EN</a>
                    </div>
                    <a href="#kontak" class="relative group overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_0_25px_rgba(59,130,246,0.4)]">
                        <span class="relative z-10">{{ __('Mulai Konsultasi') }}</span>
                        <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    </a>
                </div>

                <button type="button" data-mobile-nav-toggle aria-expanded="false" aria-label="Buka Menu Navigasi"
                    class="md:hidden rounded-lg p-2 text-slate-300 hover:bg-white/10">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div data-mobile-nav-panel class="mobile-nav-panel hidden !top-24 !left-4 !right-4 !inset-x-auto premium-glass !border-white/10 rounded-2xl p-6 shadow-2xl">
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-400">{{ __('Navigasi Premium') }}</p>
                        <p class="text-sm text-slate-400">{{ __('Jelajahi halaman dengan mudah') }}</p>
                    </div>
                    <button type="button" data-mobile-nav-close aria-label="Tutup Menu Navigasi"
                        class="rounded-lg p-2 text-slate-400 hover:bg-white/5 hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="mt-6 grid gap-3">
                    <div class="flex gap-2 text-xs font-bold px-4 mb-4 text-white">
                        <a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'text-blue-400' : 'text-slate-400' }}">ID</a>
                        <span class="text-white/20">|</span>
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-blue-400' : 'text-slate-400' }}">EN</a>
                    </div>
                    <a href="/?theme=premium"
                        class="rounded-xl px-4 py-3 font-semibold text-slate-300 hover:bg-white/5 hover:text-white">{{ __('Beranda') }}</a>
                    <a href="/layanan?theme=premium"
                        class="rounded-xl px-4 py-3 font-semibold text-slate-300 hover:bg-white/5 hover:text-white">{{ __('Layanan') }}</a>
                    <a href="/portofolio?theme=premium"
                        class="rounded-xl px-4 py-3 font-semibold text-slate-300 hover:bg-white/5 hover:text-white">{{ __('Portofolio') }}</a>
                    <a href="/tentang-kami?theme=premium"
                        class="rounded-xl px-4 py-3 font-semibold text-slate-300 hover:bg-white/5 hover:text-white">{{ __('Tentang Kami') }}</a>
                    <a href="/blog?theme=premium"
                        class="rounded-xl px-4 py-3 font-semibold text-slate-300 hover:bg-white/5 hover:text-white">{{ __('Blog') }}</a>

                    <a href="#kontak" class="mt-3 flex items-center justify-center rounded-xl bg-blue-600 py-3.5 font-bold text-white shadow-lg hover:bg-blue-500">{{ __('Mulai Konsultasi') }}</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content Area -->
    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    <!-- Premium Footer -->
    <footer class="w-full border-t border-white/5 bg-[#030712] py-20 text-slate-400 relative overflow-hidden">
        <!-- Background glows -->
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/4 w-[400px] h-[400px] bg-purple-900/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-12 px-6 md:grid-cols-4 md:px-8 lg:px-20 relative z-10">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500">
                        <img src="/images/logo-rakira.png" alt="Rakira Premium" class="h-6 w-6">
                    </div>
                    <h3 class="text-2xl font-black text-white tracking-tight">{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}</h3>
                </div>
                @if($settings->motto)
                    <p class="text-blue-400 max-w-md mb-4 italic font-medium">"{{ $settings->motto }}"</p>
                @endif
                <p class="text-slate-400 max-w-md leading-relaxed">
                    {{ $settings->about_us ?? 'Membangun ekosistem teknologi premium yang scalable untuk mendukung transformasi digital masa depan bisnis Anda.' }}
                </p>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-wider text-white text-sm">Layanan Utama</h4>
                <ul class="space-y-3 text-slate-400">
                    <li><a href="/layanan?theme=premium" class="hover:text-blue-400 transition-colors">Web Development</a></li>
                    <li><a href="/layanan?theme=premium" class="hover:text-blue-400 transition-colors">Mobile App Development</a></li>
                    <li><a href="/layanan?theme=premium" class="hover:text-blue-400 transition-colors">UI/UX Design</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-wider text-white text-sm">Navigasi</h4>
                <ul class="space-y-3 text-slate-400">
                    <li><a href="/tentang-kami?theme=premium" class="hover:text-blue-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="/portofolio?theme=premium" class="hover:text-blue-400 transition-colors">Portofolio</a></li>
                    <li><a href="/blog?theme=premium" class="hover:text-blue-400 transition-colors">Blog & Update</a></li>
                </ul>
            </div>
        </div>
        <div class="mx-auto max-w-7xl mt-16 pt-8 border-t border-white/5 text-center text-slate-600 text-sm px-6 md:px-8">
            &copy; {{ date('Y') }} {{ $settings->company_name ?? 'Rakira Digital Nusantara' }}. Semua Hak Dilindungi.
        </div>
    </footer>

    <!-- Premium Chat Widget -->
    <div x-data="{ 
            open: false, 
            showWidget: false,
            showTooltip: false,
            init() {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 300) {
                        if (!this.showWidget) {
                            this.showWidget = true;
                            setTimeout(() => {
                                if (!this.open) this.showTooltip = true;
                                setTimeout(() => this.showTooltip = false, 8000);
                            }, 1000);
                        }
                    }
                });
            }
         }" 
         x-show="showWidget"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-10 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         class="fixed bottom-6 right-6 z-[60] md:bottom-8 md:right-8">
        
        <!-- Welcome Tooltip -->
        <div x-show="showTooltip && !open" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-300"
             class="absolute bottom-20 right-0 w-64 bg-slate-900 border border-white/10 p-4 rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.5)] mb-2">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></span>
                <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Premium Assistant</span>
            </div>
            <p class="text-xs text-slate-200 leading-relaxed font-semibold">Ada ide proyek digital? Mari diskusikan bersama tim ahli kami.</p>
            <div class="absolute bottom-[-6px] right-6 w-3 h-3 bg-slate-900 rotate-45 border-r border-b border-white/10"></div>
        </div>

        <!-- Chat Panel -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             class="absolute bottom-20 right-0 w-[320px] md:w-[360px] bg-slate-950/95 border border-white/10 rounded-[2rem] shadow-[0_30px_70px_rgba(0,0,0,0.8)] backdrop-blur-xl overflow-hidden flex flex-col">
            
            <!-- Header -->
            <div class="p-6 border-b border-white/5 bg-slate-900/50">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                        <span class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">Live Consultation</span>
                    </div>
                    <button @click="open = false" aria-label="Tutup Panel Chat" class="text-slate-500 hover:text-slate-200 transition-colors">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <h4 class="text-base font-bold text-white leading-snug">
                    Hubungi kami kapan saja untuk konsultasi gratis.
                </h4>
            </div>

            <!-- Body (Form) -->
            <div class="p-6 bg-slate-950/30">
                <form action="{{ route('konsultasi.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="sender_email" value="premium-chat@rakira.com">
                    <input type="hidden" name="service" value="Premium Hub Consultation">

                    <input type="text" name="sender_name" required placeholder="Nama Anda" 
                           class="w-full rounded-xl border border-white/10 bg-slate-900/80 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-500">

                    <input type="text" name="phone" required placeholder="WhatsApp (0812...)" 
                           class="w-full rounded-xl border border-white/10 bg-slate-900/80 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-500">

                    <textarea name="message_body" required placeholder="Tulis rencana proyek Anda di sini..." rows="3"
                              class="w-full rounded-xl border border-white/10 bg-slate-900/80 px-4 py-3 text-sm text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all resize-none placeholder:text-slate-500"></textarea>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-[0_0_20px_rgba(59,130,246,0.3)] transition-all flex items-center justify-center gap-2 group">
                        <span class="text-sm">Mulai Konsultasi</span>
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-0.5 transition-transform">send</span>
                    </button>
                </form>

                <div class="mt-6 flex flex-col items-center gap-3">
                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-[0.2em]">Atau Hubungi Langsung</p>
                    <div class="grid grid-cols-2 gap-2 w-full">
                        <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}" target="_blank" class="flex items-center justify-center gap-2 py-2.5 bg-slate-900/50 border border-white/5 rounded-lg text-[11px] font-bold text-slate-300 hover:border-emerald-500 hover:text-emerald-400 transition-all shadow-sm">
                            <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" class="w-3.5 h-3.5" alt="WA"> WhatsApp
                        </a>
                        <a href="https://www.instagram.com/rakiradigital?igsh=MWRpdnR3Ym8wazMxbQ%3D%3D&utm_source=qr" target="_blank" class="flex items-center justify-center gap-2 py-2.5 bg-slate-900/50 border border-white/5 rounded-lg text-[11px] font-bold text-slate-300 hover:border-pink-500 hover:text-pink-400 transition-all shadow-sm">
                            <img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" class="w-3.5 h-3.5" alt="IG"> Instagram
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toggle Button -->
        <button @click="open = !open; showTooltip = false" aria-label="Buka Chat Layanan"
                class="w-16 h-16 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 text-white shadow-[0_0_20px_rgba(59,130,246,0.4)] flex items-center justify-center hover:scale-105 active:scale-95 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
            <span class="material-symbols-outlined text-2xl relative z-10" x-show="!open">chat</span>
            <span class="material-symbols-outlined text-2xl relative z-10" x-show="open">close</span>
        </button>
    </div>

    @stack('scripts')
</body>

</html>
