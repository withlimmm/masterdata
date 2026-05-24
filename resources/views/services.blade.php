@extends('layouts.main')

@section('title', __('Layanan Profesional - Rakira Digital Nusantara'))
@section('meta_description', __('Layanan pengembangan software kustom, pembuatan website premium, pengembangan aplikasi mobile, dan optimasi digital lengkap dari Rakira Digital.'))

@section('content')
<div class="pt-24 pb-16">
    {{-- Hero Section --}}
    <section class="page-hero bg-white overflow-hidden relative">
        <div class="absolute inset-0 bg-grid-pattern -z-10 opacity-30"></div>
        <div class="content-container grid grid-cols-1 items-center gap-12 lg:grid-cols-2 py-16">
            <div class="space-y-6 z-10" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
                <div class="section-kicker">
                    <span class="material-symbols-outlined notranslate text-sm" translate="no">rocket_launch</span>
                    <span class="font-bold text-sm">{{ __('Our Services') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-7xl font-black leading-[1.05] tracking-tight text-on-surface transition-all duration-1000"
                    :class="shown ? 'opacity-100 blur-0 translate-y-0' : 'opacity-0 blur-xl translate-y-4'">
                    {!! __('Solusi Digital <br>') !!}
                    <span class="text-gradient">{{ __('Terintegrasi') }}</span>
                </h1>
                <p class="section-subtitle max-w-xl transition-all duration-1000 delay-500"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    {{ __('Kami menyediakan layanan pengembangan software dan konsultasi IT premium untuk membantu transformasi digital bisnis Anda secara menyeluruh.') }}
                </p>
                <div class="pt-4 flex flex-wrap gap-4">
                    <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Halo Rakira Digital, saya ingin konsultasi layanan digital. Bisa bantu?') }}" target="_blank" class="btn-primary px-8 py-3.5 shadow-lg hover:-translate-y-1">
                        {{ __('Mulai Konsultasi Gratis') }}
                        <span class="material-symbols-outlined notranslate ml-2 text-lg" translate="no">chat</span>
                    </a>
                </div>
            </div>
            <div class="relative z-10 hidden lg:block" data-aos="zoom-in" data-aos-delay="200">
                <div class="relative w-full aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl border border-glass-border bg-surface-container">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=2070" alt="Team Working" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- Services Grid (Dynamic) --}}
    <section class="page-section bg-[#f6faff]">
        <div class="content-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $index => $service)
                <a 
                    href="{{ route('services.show', $service->slug) }}" 
                    aria-label="{{ __('Detail Layanan') }}: {{ __t($service->title) }}"
                    class="interactive-card group {{ $loop->iteration % 3 == 1 ? 'lg:col-span-2' : '' }}" 
                    data-aos="fade-up" 
                    data-aos-delay="{{ $index * 100 }}"
                >
                    <div class="interactive-card-icon w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mb-6 transition-all group-hover:scale-110">
                        <span class="material-symbols-outlined notranslate text-4xl" translate="no">{{ $service->icon_image ?: 'settings' }}</span>
                    </div>
                    <h3 class="interactive-card-title text-2xl font-bold text-on-surface mb-3 transition-colors">{{ __t($service->title) }}</h3>
                    <p class="interactive-card-description text-on-surface-variant leading-relaxed transition-colors">
                        {{ __t($service->short_description) }}
                    </p>
                    
                    <div class="mt-8 flex items-center text-primary font-bold transition-all group-hover:text-white">
                        <span>{{ __('Lihat Detail Layanan') }}</span>
                        <span class="material-symbols-outlined notranslate ml-2 text-sm" translate="no">arrow_forward</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="page-section">
        <div class="content-container max-w-4xl">
            <div class="surface-card p-10 md:p-16 rounded-[2.5rem] text-center space-y-6 relative overflow-hidden" data-aos="fade-up">
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-black text-on-surface">{{ __('Punya Kebutuhan Kustom?') }}</h2>
                    <p class="text-on-surface-variant max-w-xl mx-auto text-lg">
                        {{ __('Sampaikan ide Anda dan kami akan menyusun solusi teknologi yang paling pas untuk skala bisnis Anda.') }}
                    </p>
                    <div class="pt-6">
                        <a href="{{ url('/#kontak') }}" class="btn-primary !px-10 !py-4 shadow-xl">
                            {{ __('Isi Form Konsultasi') }}
                        </a>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            </div>
        </div>
    </section>
</div>
@endsection
