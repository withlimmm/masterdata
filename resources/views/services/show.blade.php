@extends('layouts.main')

@section('title', __t($service->title) . ' - Rakira Digital Nusantara')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags(__t($service->full_description)), 150))
@section('meta_keywords', __t($service->title) . ', ' . __('layanan rakira digital, digital agency'))

@section('content')
<div class="pt-24 pb-16 min-h-screen bg-background">
    <div class="content-container">
        {{-- Breadcrumb --}}
        <nav class="flex mb-8 text-sm font-semibold text-on-surface-variant" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="hover:text-primary transition-colors">{{ __('Beranda') }}</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined notranslate text-sm mx-2" translate="no">chevron_right</span>
                        <a href="{{ route('services') }}" class="hover:text-primary transition-colors">{{ __('Layanan') }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined notranslate text-sm mx-2" translate="no">chevron_right</span>
                        <span class="text-on-surface">{{ __t($service->title) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="surface-card p-8 md:p-12 rounded-3xl" data-aos="fade-up">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined notranslate text-4xl" translate="no">{{ $service->icon_image ?: 'settings' }}</span>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black text-on-surface">{{ __t($service->title) }}</h1>
                    </div>

                    <div class="prose prose-lg max-w-none text-on-surface-variant leading-relaxed">
                        {!! nl2br(e(__t($service->full_description))) !!}
                    </div>
                </div>

                {{-- Related Projects or CTA --}}
                <div class="surface-card p-8 rounded-3xl bg-primary text-white overflow-hidden relative" data-aos="fade-up">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-4">{{ __('Siap Memulai dengan') }} {{ __t($service->title) }}?</h3>
                        <p class="text-white/80 mb-6 max-w-xl">
                            {{ __('Konsultasikan kebutuhan bisnis Anda dengan tim ahli kami dan dapatkan solusi terbaik yang scalable dan efisien.') }}
                        </p>
                        <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Halo Rakira Digital, saya ingin bertanya lebih lanjut tentang ' . __t($service->title)) }}" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 bg-white text-primary font-bold px-8 py-3.5 rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300">
                            {{ __('Hubungi via WhatsApp') }}
                            <span class="material-symbols-outlined notranslate" translate="no">chat</span>
                        </a>
                    </div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Quick Contact --}}
                <div class="surface-card p-6 rounded-2xl" data-aos="fade-left">
                    <h4 class="text-lg font-bold text-on-surface mb-4">{{ __('Layanan Lainnya') }}</h4>
                    <div class="space-y-3">
                        @foreach(\App\Models\Service::where('id', '!=', $service->id)->where('status', 'active')->get() as $other)
                        <a href="{{ route('services.show', $other->slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary/5 transition-colors group">
                            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-on-surface-variant group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined notranslate text-xl" translate="no">{{ $other->icon_image ?: 'settings' }}</span>
                            </div>
                            <span class="font-bold text-sm text-on-surface group-hover:text-primary transition-colors">{{ __t($other->title) }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Feature Card --}}
                <div class="surface-card p-6 rounded-2xl border-l-4 border-primary" data-aos="fade-left" data-aos-delay="100">
                    <h4 class="font-bold text-on-surface mb-2">{{ __('Mengapa Rakira Digital?') }}</h4>
                    <ul class="space-y-3 text-sm text-on-surface-variant">
                        <li class="flex gap-2">
                            <span class="material-symbols-outlined notranslate text-primary text-sm" translate="no">check_circle</span>
                            <span>{{ __('Tim Ahli & Berpengalaman') }}</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="material-symbols-outlined notranslate text-primary text-sm" translate="no">check_circle</span>
                            <span>{{ __('Teknologi Modern & Aman') }}</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="material-symbols-outlined notranslate text-primary text-sm" translate="no">check_circle</span>
                            <span>{{ __('Dukungan Maintenance 24/7') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
