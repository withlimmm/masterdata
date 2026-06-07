<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rakira CMS - Management')</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        [v-cloak] { display: none !important; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell flex min-h-screen overflow-x-hidden font-sans" x-data="{ sidebarOpen: false }">

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black/50 z-40 lg:hidden" @click="sidebarOpen = false"></div>

    <!-- SideNavBar -->
    <nav 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed left-0 z-50 flex h-full w-72 flex-col space-y-2 border-r border-outline-variant/30 bg-surface-container-lowest p-4 shadow-xl transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        <!-- Close Button (Mobile) -->
        <button @click="sidebarOpen = false" class="lg:hidden absolute top-4 right-4 text-on-surface-variant">
            <span class="material-symbols-outlined">close</span>
        </button>

        <!-- Header / Brand -->
        <div class="mb-6 flex items-center gap-3 p-4 bg-primary/5 rounded-2xl border border-primary/10 mx-2">
            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center p-1.5">
                <img src="/images/logo-rakira.png" alt="Rakira Digital" class="w-full h-full object-contain">
            </div>
            <div>
                <h2 class="text-sm font-black text-on-surface leading-tight">Rakira Admin</h2>
                <p class="text-[10px] text-primary font-bold uppercase tracking-widest">Dashboard v1.0</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="px-2 pb-4">
            <a href="{{ route('admin.articles.create') }}" class="group flex w-full items-center justify-center space-x-2 rounded-xl bg-primary px-4 py-3 text-white shadow-md transition-all hover:bg-primary/90 active:scale-95">
                <span class="material-symbols-outlined group-hover:rotate-90 transition-transform" style="font-variation-settings: 'FILL' 1;">add</span>
                <span class="text-sm font-bold">New Content</span>
            </a>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex-1 flex flex-col space-y-1 overflow-y-auto px-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'fill-1' : 'group-hover:text-primary' }}">dashboard</span>
                <span class="text-sm font-bold tracking-tight">Dashboard</span>
            </a>
            
            <div class="pt-4 pb-2 px-4 text-[10px] font-black uppercase tracking-[0.2em] text-outline-variant">Konten & Media</div>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.articles.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.articles.*') ? 'fill-1' : 'group-hover:text-primary' }}">article</span>
                <span class="text-sm font-bold tracking-tight">Blog Artikel</span>
            </a>

            <a href="{{ route('admin.portfolios.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.portfolios.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.portfolios.*') ? 'fill-1' : 'group-hover:text-primary' }}">work</span>
                <span class="text-sm font-bold tracking-tight">Portofolio</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.categories.*') ? 'fill-1' : 'group-hover:text-primary' }}">category</span>
                <span class="text-sm font-bold tracking-tight">Kategori</span>
            </a>

            <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.services.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.services.*') ? 'fill-1' : 'group-hover:text-primary' }}">business_center</span>
                <span class="text-sm font-bold tracking-tight">Layanan</span>
            </a>

            <a href="{{ route('admin.teams.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.teams.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.teams.*') ? 'fill-1' : 'group-hover:text-primary' }}">badge</span>
                <span class="text-sm font-bold tracking-tight">Tim Kami</span>
            </a>

            <div class="pt-4 pb-2 px-4 text-[10px] font-black uppercase tracking-[0.2em] text-outline-variant">Interaksi</div>

            <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.faqs.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.faqs.*') ? 'fill-1' : 'group-hover:text-primary' }}">quiz</span>
                <span class="text-sm font-bold tracking-tight">Tanya Jawab (FAQ)</span>
            </a>

            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.messages.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.messages.*') ? 'fill-1' : 'group-hover:text-primary' }}">mail</span>
                    <span class="text-sm font-bold tracking-tight">Pesan Masuk</span>
                </div>
                @if($unread_messages_count > 0)
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white shadow-sm">{{ $unread_messages_count }}</span>
                @endif
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.reviews.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.reviews.*') ? 'fill-1' : 'group-hover:text-primary' }}">rate_review</span>
                    <span class="text-sm font-bold tracking-tight">Ulasan Klien</span>
                </div>
                @if($pending_reviews_count > 0)
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-amber-500 text-[10px] font-black text-white shadow-sm">{{ $pending_reviews_count }}</span>
                @endif
            </a>

            <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.clients.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.clients.*') ? 'fill-1' : 'group-hover:text-primary' }}">groups</span>
                <span class="text-sm font-bold tracking-tight">Data Klien</span>
            </a>

            <div class="pt-4 pb-2 px-4 text-[10px] font-black uppercase tracking-[0.2em] text-outline-variant">Sistem</div>

            @if(Auth::user()->role === 'super_admin')
            <a href="{{ route('admin.packages.index') }}" class="flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.packages.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.packages.*') ? 'fill-1' : 'group-hover:text-primary' }}">inventory_2</span>
                    <span class="text-sm font-bold tracking-tight">Master Paket</span>
                </div>
            </a>

            <a href="{{ route('admin.companies.index') }}" class="flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.companies.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.companies.*') ? 'fill-1' : 'group-hover:text-primary' }}">apartment</span>
                    <span class="text-sm font-bold tracking-tight">Data Klien Tenant</span>
                </div>
            </a>
            @endif

            @if(app()->bound('tenant'))
            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.users.*') ? 'fill-1' : 'group-hover:text-primary' }}">manage_accounts</span>
                    <span class="text-sm font-bold tracking-tight">Kelola Staf / Tim</span>
                </div>
            </a>
            @endif

            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 transition-all duration-300 group {{ request()->routeIs('admin.settings.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.settings.*') ? 'fill-1' : 'group-hover:text-primary' }}">settings</span>
                <span class="text-sm font-bold tracking-tight">Pengaturan</span>
            </a>
        </div>

        <!-- Footer Tab -->
        <div class="mt-auto pt-4 border-t border-outline-variant/30">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-on-surface-variant hover:bg-red-50 hover:text-error rounded-xl transition-all w-full text-left group">
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-error group-hover:rotate-180 transition-transform duration-500">logout</span>
                    <span class="text-sm font-bold">Logout Securely</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content Canvas -->
    <main class="flex min-h-screen flex-1 flex-col overflow-hidden lg:ml-72">
        <!-- Sticky Header -->
        <header class="sticky top-0 z-40 flex items-center justify-between border-b border-outline-variant/30 bg-white/80 px-4 py-4 shadow-sm backdrop-blur-lg lg:px-8">
            <div class="flex items-center gap-4">
                <!-- Hamburger Button (Mobile) -->
                <button @click="sidebarOpen = true" class="rounded-lg p-2 text-on-surface-variant transition-colors hover:bg-surface-container-low lg:hidden">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="hidden sm:block">
                    <h1 class="text-xl font-bold text-on-surface font-headline">@yield('page_title')</h1>
                    <p class="text-xs text-on-surface-variant font-semibold">@yield('page_subtitle')</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 lg:gap-6">
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors relative group">
                    <span class="material-symbols-outlined">notifications</span>
                    @if($notif_count > 0)
                        <span class="absolute top-2 right-2 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[8px] font-black text-white border-2 border-white ring-1 ring-red-200">
                            {{ $notif_count }}
                        </span>
                    @endif
                </button>
                <div class="h-6 w-px bg-outline-variant/30"></div>
                <div class="flex items-center gap-3 bg-surface-container-low px-3 py-1.5 rounded-full border border-outline-variant/20">
                    <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold shadow-inner">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <p class="hidden md:block text-xs font-bold text-on-surface">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </header>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto p-4 lg:p-8 space-y-6">
            @if(request()->is('admin/faqs*') || request()->is('admin/services*') || request()->is('admin/portfolios*') || request()->is('admin/articles*') || request()->is('admin/settings*'))
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3 text-sm text-blue-800 animate-in fade-in duration-500">
                    <span class="material-symbols-outlined text-blue-600 mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
                    <div>
                        <p class="font-bold">💡 Tips Konten Langsung</p>
                        <p class="text-blue-700/90 text-xs mt-1 leading-relaxed">
                            Setiap perubahan dari admin akan langsung dipakai di public tanpa menunggu cache lama. Jika ada teks bilingual, sistem juga bisa membaca format JSON atau format lama untuk kompatibilitas.
                        </p>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
