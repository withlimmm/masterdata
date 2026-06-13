<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rakira CMS - Management')</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        [v-cloak] { display: none !important; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
            vertical-align: middle;
        }
        .fill-1 {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9; /* Soft grey background matching the Shadcn theme */
        }
        /* Custom Scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen overflow-x-hidden text-slate-800" 
      x-data="{ 
          isDesktop: window.innerWidth >= 1024, 
          sidebarOpen: window.innerWidth >= 1024 
      }"
      @resize.window="isDesktop = window.innerWidth >= 1024; if(!isDesktop) sidebarOpen = false;">

    <!-- Mobile Overlay -->
    <div x-cloak x-show="sidebarOpen && !isDesktop" x-transition.opacity class="fixed inset-0 bg-slate-900/50 z-40 backdrop-blur-sm" @click="sidebarOpen = false"></div>

    <style>
        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
    </style>
    <!-- SideNavBar -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed left-0 top-0 bottom-0 z-50 flex w-64 flex-col transition-transform duration-300 ease-in-out bg-slate-50 border-r border-slate-200 shadow-sm p-4 overflow-y-auto">
        
        <!-- Header / Brand -->
        <div class="flex-shrink-0 mb-8 flex items-center gap-3 px-2">
            <h2 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-800 fill-1">diamond</span>
                Rakira Admin
            </h2>
            <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-slate-500 hover:text-slate-800">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 space-y-4 pr-2">
            
            <!-- Dashboard -->
            <div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.dashboard') ? 'fill-1' : '' }}">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Pages Group -->
            <div x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between pb-2 px-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 hover:text-slate-600 transition-colors">
                    <span>Pages</span>
                    <span class="material-symbols-outlined text-[16px] transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition.opacity class="space-y-1 mt-1">
                    <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.articles.*') ? 'fill-1' : '' }}">article</span>
                        <span class="text-sm font-medium">Blog & Articles</span>
                    </a>

                    <a href="{{ route('admin.portfolios.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.portfolios.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.portfolios.*') ? 'fill-1' : '' }}">work</span>
                        <span class="text-sm font-medium">Portfolios</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.categories.*') ? 'fill-1' : '' }}">category</span>
                        <span class="text-sm font-medium">Categories</span>
                    </a>

                    <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.services.*') ? 'fill-1' : '' }}">business_center</span>
                        <span class="text-sm font-medium">Services</span>
                    </a>

                    <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.banners.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.banners.*') ? 'fill-1' : '' }}">view_carousel</span>
                        <span class="text-sm font-medium">Banners</span>
                    </a>

                    <a href="{{ route('admin.teams.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.teams.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.teams.*') ? 'fill-1' : '' }}">groups</span>
                        <span class="text-sm font-medium">Team Members</span>
                    </a>
                </div>
            </div>

            <!-- Interactions Group -->
            <div x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between pt-4 pb-2 px-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 hover:text-slate-600 transition-colors border-t border-slate-200/60">
                    <span>Interactions</span>
                    <span class="material-symbols-outlined text-[16px] transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition.opacity class="space-y-1 mt-1">
                    <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.messages.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.messages.*') ? 'fill-1' : '' }}">mail</span>
                            <span class="text-sm font-medium">Messages</span>
                        </div>
                        @if(isset($unread_messages_count) && $unread_messages_count > 0)
                            <span class="flex h-5 w-5 items-center justify-center rounded bg-emerald-500 text-[10px] font-bold text-white shadow-sm">{{ $unread_messages_count }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.reviews.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.reviews.*') ? 'fill-1' : '' }}">rate_review</span>
                            <span class="text-sm font-medium">Reviews</span>
                        </div>
                        @if(isset($pending_reviews_count) && $pending_reviews_count > 0)
                            <span class="flex h-5 w-5 items-center justify-center rounded bg-amber-500 text-[10px] font-bold text-white shadow-sm">{{ $pending_reviews_count }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.faqs.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.faqs.*') ? 'fill-1' : '' }}">help</span>
                        <span class="text-sm font-medium">FAQs</span>
                    </a>
                </div>
            </div>

            <!-- System & Admin Group -->
            <div x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between pt-4 pb-2 px-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 hover:text-slate-600 transition-colors border-t border-slate-200/60">
                    <span>System & Admin</span>
                    <span class="material-symbols-outlined text-[16px] transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition.opacity class="space-y-1 mt-1">
                    <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.clients.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.clients.*') ? 'fill-1' : '' }}">person</span>
                        <span class="text-sm font-medium">Client Data</span>
                    </a>

                    @if(Auth::user()->role === 'super_admin')
                    <a href="{{ route('admin.systems.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.systems.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.systems.*') ? 'fill-1' : '' }}">category</span>
                        <span class="text-sm font-medium">Systems</span>
                    </a>

                    <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.packages.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.packages.*') ? 'fill-1' : '' }}">inventory_2</span>
                        <span class="text-sm font-medium">Packages</span>
                    </a>

                    <a href="{{ route('admin.companies.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.companies.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.companies.*') ? 'fill-1' : '' }}">apartment</span>
                        <span class="text-sm font-medium">Tenant Companies</span>
                    </a>
                    @endif

                    @if(app()->bound('tenant'))
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.users.*') ? 'fill-1' : '' }}">manage_accounts</span>
                        <span class="text-sm font-medium">Staff Members</span>
                    </a>
                    @endif

                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('admin.settings.*') ? 'fill-1' : '' }}">settings</span>
                        <span class="text-sm font-medium">Settings</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Footer Action -->
        <div class="flex-shrink-0 mt-8 pt-4 px-2 border-t border-slate-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-slate-600 transition-all duration-200 hover:bg-slate-200 hover:text-slate-900">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main :style="sidebarOpen && isDesktop ? 'margin-left: 256px' : 'margin-left: 0'" class="flex min-h-screen flex-1 flex-col p-4 lg:p-6 transition-all duration-300">
        
        <!-- Header -->
        <header class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <!-- Hamburger Menu Button (Always Visible) -->
                <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-slate-500 hover:bg-white shadow-sm transition-all border border-transparent hover:border-slate-200 flex-shrink-0 relative z-10">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                
                <!-- Breadcrumb / Title -->
                <div>
                    <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800 transition-colors flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">home</span>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">chevron_right</span>
                                    <span class="ml-1 text-slate-700 font-medium">@yield('page_title', 'Overview')</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('page_title', 'Dashboard')</h1>
                </div>
            </div>

            <!-- Header Right: Actions & Profile -->
            <div class="flex items-center gap-3 lg:gap-4">
                <!-- Search (Mock) -->
                <div class="hidden md:flex relative group text-slate-500 focus-within:text-slate-800">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                    </div>
                    <input type="text" placeholder="Type here..." style="padding-left: 2.25rem;" class="block w-56 pr-4 py-2 rounded-full border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-800/20 focus:border-slate-800 transition-all shadow-sm">
                </div>

                <a href="{{ route('admin.articles.create') }}" class="hidden sm:flex text-slate-500 hover:text-slate-800 hover:bg-white p-2 rounded-full transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">edit_square</span>
                </a>

                <button class="relative text-slate-500 hover:text-slate-800 hover:bg-white p-2 rounded-full transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                    @if(isset($notif_count) && $notif_count > 0)
                        <span class="absolute top-1 right-1 flex h-3 w-3 items-center justify-center rounded-full bg-red-500 text-[0px] font-bold text-white border-2 border-slate-100"></span>
                    @endif
                </button>
                
                <div class="h-6 w-px bg-slate-200 mx-1"></div>
                
                <!-- Profile Menu -->
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="hidden text-right md:block">
                        <p class="text-sm font-bold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 mt-1 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center text-sm font-bold shadow-md border-2 border-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Slot -->
        <div class="flex-1 w-full mx-auto">
            @if(request()->is('admin/faqs*') || request()->is('admin/services*') || request()->is('admin/portfolios*') || request()->is('admin/articles*') || request()->is('admin/settings*'))
                <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3 text-sm text-blue-800 shadow-sm backdrop-blur-sm">
                    <span class="material-symbols-outlined text-blue-500 mt-0.5 fill-1">info</span>
                    <div>
                        <p class="font-bold tracking-tight">Tips Konten Langsung</p>
                        <p class="text-blue-600/80 mt-0.5">Perubahan di admin akan langsung diaplikasikan ke halaman publik.</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
        
        <!-- Footer -->
        <footer class="mt-auto pt-8 pb-4 text-center text-xs text-slate-400">
            <p>&copy; {{ date('Y') }}, made with <span class="text-red-400">&hearts;</span> by Rakira Digital. All rights reserved.</p>
        </footer>
    </main>

</body>
</html>
