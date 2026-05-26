@extends('layouts.main')

@section('title', __t($service->title) . ' - Rakira Digital Nusantara')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags(__t($service->full_description)), 150))
@section('meta_keywords', __t($service->title) . ', ' . __('layanan rakira digital, digital agency'))

@section('content')
<div class="pt-20 pb-20 min-h-screen bg-gradient-to-b from-white to-[#0a88b2]/5">
    <div class="content-container">
        {{-- Breadcrumb dengan animasi fade-in --}}
        <nav class="flex mb-8 text-sm font-medium text-slate-500" aria-label="Breadcrumb" data-aos="fade-down" data-aos-duration="600">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="hover:text-[#0a88b2] transition-colors duration-300">{{ __('Beranda') }}</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="material-symbols-outlined notranslate text-sm mx-1" translate="no">chevron_right</span>
                        <a href="{{ route('services') }}" class="hover:text-[#0a88b2] transition-colors duration-300">{{ __('Layanan') }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined notranslate text-sm mx-1" translate="no">chevron_right</span>
                        <span class="text-[#0a88b2] font-semibold">{{ __t($service->title) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Card utama dengan efek glassmorphism halus --}}
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/50 overflow-hidden transition-all duration-500 hover:shadow-xl" data-aos="fade-up" data-aos-duration="800">
                    <div class="p-8 md:p-10">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#0a88b2]/20 to-[#0a88b2]/5 flex items-center justify-center text-[#0a88b2] shadow-md transition-transform duration-500 hover:scale-110 hover:rotate-3">
                                <span class="material-symbols-outlined notranslate text-5xl" translate="no">{{ $service->icon_image ?: 'settings' }}</span>
                            </div>
                            <h1 class="text-3xl md:text-5xl font-black text-slate-800 leading-tight">{{ __t($service->title) }}</h1>
                        </div>
                        
                        <div class="prose prose-lg max-w-none text-slate-600 leading-relaxed">
                            {!! nl2br(e(__t($service->full_description))) !!}
                        </div>
                    </div>
                </div>

                {{-- Bagian Fitur Unggulan (jika ada, bisa dinamis) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <span class="material-symbols-outlined notranslate text-3xl text-[#0a88b2]">speed</span>
                        <h3 class="font-bold text-lg mt-3 mb-1">{{ __('Kinerja Tinggi') }}</h3>
                        <p class="text-slate-500 text-sm">{{ __('Optimasi kecepatan dan efisiensi untuk hasil maksimal.') }}</p>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <span class="material-symbols-outlined notranslate text-3xl text-[#0a88b2]">security</span>
                        <h3 class="font-bold text-lg mt-3 mb-1">{{ __('Keamanan Terjamin') }}</h3>
                        <p class="text-slate-500 text-sm">{{ __('Protokol keamanan modern untuk data Anda.') }}</p>
                    </div>
                </div>

                {{-- CTA WhatsApp dengan animasi --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0a88b2] to-[#0a88b2]/80 text-white shadow-xl" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 animate-pulse-slow"></div>
                    <div class="relative z-10 p-8 md:p-10">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">{{ __('Siap Memulai dengan') }} {{ __t($service->title) }}?</h3>
                                <p class="text-white/80 max-w-md">
                                    {{ __('Konsultasikan kebutuhan bisnis Anda dengan tim ahli kami dan dapatkan solusi terbaik yang scalable dan efisien.') }}
                                </p>
                            </div>
                            <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Halo Rakira Digital, saya ingin bertanya lebih lanjut tentang ' . __t($service->title)) }}" 
                               target="_blank" 
                               class="group inline-flex items-center gap-2 bg-white text-[#0a88b2] font-bold px-6 py-3 rounded-full shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.032 2.004c-5.514 0-9.996 4.48-9.996 9.99 0 1.76.46 3.484 1.32 4.996L2 22l5.196-1.44c1.468.86 3.122 1.316 4.832 1.316 5.514 0 9.996-4.48 9.996-9.99 0-5.51-4.482-9.99-9.996-9.99zm0 18.38c-1.488 0-2.95-.4-4.21-1.16l-.3-.18-3.08.85.83-3.01-.2-.31c-.82-1.3-1.26-2.8-1.26-4.33 0-4.54 3.7-8.24 8.24-8.24 4.54 0 8.24 3.7 8.24 8.24 0 4.54-3.7 8.24-8.24 8.24z"/>
                                </svg>
                                <span>Hubungi via WhatsApp</span>
                                <span class="material-symbols-outlined notranslate text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar dengan animasi slide-in --}}
            <div class="space-y-6">
                {{-- Layanan Lainnya --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 transition-all duration-300 hover:shadow-lg" data-aos="fade-left" data-aos-duration="600">
                    <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined notranslate text-[#0a88b2]">apps</span>
                        {{ __('Layanan Lainnya') }}
                    </h4>
                    <div class="space-y-3">
                        @foreach(\App\Models\Service::where('id', '!=', $service->id)->where('status', 'active')->limit(4)->get() as $other)
                        <a href="{{ route('services.show', $other->slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-[#0a88b2]/5 transition-all duration-300 group">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 group-hover:bg-[#0a88b2] group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined notranslate text-xl" translate="no">{{ $other->icon_image ?: 'settings' }}</span>
                            </div>
                            <span class="font-semibold text-sm text-slate-700 group-hover:text-[#0a88b2] transition-colors">{{ __t($other->title) }}</span>
                        </a>
                        @endforeach
                    </div>
                    @if(\App\Models\Service::where('id', '!=', $service->id)->count() > 4)
                    <div class="mt-4 text-center">
                        <a href="{{ route('services') }}" class="text-sm text-[#0a88b2] font-medium hover:underline">Lihat semua layanan →</a>
                    </div>
                    @endif
                </div>

                {{-- Mengapa Kami --}}
                <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-l-[#0a88b2] transition-all duration-300 hover:shadow-lg" data-aos="fade-left" data-aos-delay="150">
                    <h4 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined notranslate text-[#0a88b2]">stars</span>
                        {{ __('Mengapa Rakira Digital?') }}
                    </h4>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex gap-2 items-start">
                            <span class="material-symbols-outlined notranslate text-[#0a88b2] text-base mt-0.5">check_circle</span>
                            <span>{{ __('Tim Ahli & Berpengalaman 5+ tahun') }}</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <span class="material-symbols-outlined notranslate text-[#0a88b2] text-base mt-0.5">check_circle</span>
                            <span>{{ __('Teknologi Modern & Keamanan Terjamin') }}</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <span class="material-symbols-outlined notranslate text-[#0a88b2] text-base mt-0.5">check_circle</span>
                            <span>{{ __('Dukungan Maintenance 24/7') }}</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <span class="material-symbols-outlined notranslate text-[#0a88b2] text-base mt-0.5">check_circle</span>
                            <span>{{ __('Proyek Tepat Waktu & Budget') }}</span>
                        </li>
                    </ul>
                </div>

                {{-- Kontak Singkat --}}
                <div class="bg-gradient-to-br from-[#0a88b2]/10 to-white rounded-2xl p-6 text-center border border-[#0a88b2]/20" data-aos="fade-left" data-aos-delay="300">
                    <span class="material-symbols-outlined notranslate text-4xl text-[#0a88b2]">support_agent</span>
                    <p class="text-slate-600 text-sm mt-2 mb-4">Butuh bantuan cepat? Tim kami siap membantu.</p>
                    <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Halo, saya butuh bantuan terkait ' . __t($service->title)) }}" 
                       class="inline-flex items-center gap-1 text-[#0a88b2] font-semibold text-sm hover:gap-2 transition-all">
                        <span>Chat via WhatsApp</span>
                        <span class="material-symbols-outlined notranslate text-sm">chevron_right</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Animasi tambahan --}}
<style>
    @keyframes pulse-slow {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.05); }
    }
    .animate-pulse-slow {
        animation: pulse-slow 4s ease-in-out infinite;
    }
    [data-aos] {
        transition-timing-function: cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .prose h2, .prose h3 {
        color: #1e293b;
        margin-top: 1.5em;
        margin-bottom: 0.5em;
    }
    .prose p {
        margin-bottom: 1em;
        line-height: 1.6;
    }
    .prose ul, .prose ol {
        margin: 1em 0;
        padding-left: 1.5em;
    }
    .prose li {
        margin: 0.3em 0;
    }
</style>
@endsection