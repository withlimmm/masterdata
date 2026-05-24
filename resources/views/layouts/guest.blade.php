<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts & Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="site-shell min-h-screen">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6 lg:px-8">
            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
            <div class="absolute -top-32 left-[-5rem] h-72 w-72 rounded-full bg-primary/10 blur-3xl"></div>
            <div class="absolute bottom-0 right-[-4rem] h-80 w-80 rounded-full bg-primary-container/20 blur-3xl"></div>

            <div class="relative z-10 w-full max-w-6xl">
                <div class="mb-8 flex items-center justify-between text-sm text-on-surface-variant">
                    <a href="/" class="inline-flex items-center gap-2 font-bold text-on-surface">
                        <img src="/images/logo-rakira.png" alt="Rakira Digital" class="h-10 w-10 object-contain">
                        Rakira Digital Nusantara
                    </a>
                    @if(!request()->routeIs('login'))
                    <a href="{{ route('login') }}" class="hidden rounded-full border border-primary/15 bg-white px-4 py-2 font-bold text-primary shadow-sm hover:bg-primary hover:text-white sm:inline-flex">Login Admin</a>
                    @endif
                </div>

                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>
        </div>
    </body>
</html>
