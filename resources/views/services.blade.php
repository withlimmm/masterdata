@extends('layouts.main')

@section('title', 'Layanan Digital Profesional - ' . ($settings->company_name ?? 'Rakira Digital') . ' | Software House Indonesia')
@section('meta_description', 'Layanan pembuatan website company profile, aplikasi mobile Android iOS, web app kustom, desain UI/UX, dan konsultasi IT dari Rakira Digital. Solusi teknologi terpercaya untuk bisnis Indonesia.')
@section('meta_keywords', 'layanan pembuatan website, jasa web developer indonesia, pembuatan aplikasi android, pembuatan aplikasi ios, software house tangerang, it consultant jakarta, jasa ui ux design, web app kustom, system informasi perusahaan, rakira digital layanan')

@push('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ItemList",
  "name": "Layanan Digital Rakira Digital",
  "description": "Daftar layanan digital profesional dari Rakira Digital Nusantara",
  "url": "{{ url('/layanan') }}",
  "numberOfItems": {{ $services->count() }},
  "itemListElement": [
    @foreach($services as $i => $service)
    {
      "@@type": "ListItem",
      "position": {{ $i + 1 }},
      "item": {
        "@@type": "Service",
        "name": "{{ addslashes(strip_tags(__t($service->title))) }}",
        "description": "{{ addslashes(Str::limit(strip_tags(__t($service->short_description ?? '')), 150)) }}",
        "url": "{{ url('/layanan/' . $service->slug) }}",
        "provider": {
          "@@type": "Organization",
          "name": "{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}"
        },
        "areaServed": "Indonesia"
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endpush

@section('content')
<div class="bg-gradient-to-b from-white via-[#0a88b2]/5 to-white">
    
    {{-- HERO --}}
    <section class="relative pt-28 pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-white via-[#0a88b2]/10 to-white"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-[#0a88b2]/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-[#0a88b2]/5 rounded-full blur-3xl"></div>
        
        <div class="content-container relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-[#0a88b2]/10 rounded-full px-4 py-1.5 text-sm font-semibold text-[#0a88b2] mb-6 border border-[#0a88b2]/20">
                <span class="material-symbols-outlined notranslate text-sm">bolt</span>
                <span>Premium Digital Services</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-slate-800 leading-tight">
                Transformasi Digital<br>
                <span class="bg-gradient-to-r from-[#0a88b2] to-[#0a88b2]/70 bg-clip-text text-transparent">Tanpa Batas</span>
            </h1>
            <p class="text-slate-500 text-lg mt-6 max-w-2xl mx-auto">
                Layanan teknologi end-to-end untuk membantu bisnis Anda berkembang di era digital.
            </p>
            <div class="flex flex-wrap gap-4 justify-center mt-10">
                {{-- TOMBOL WHATSAPP YANG PROFESIONAL --}}
                <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Halo, saya ingin konsultasi layanan digital') }}" 
                   class="inline-flex items-center gap-2 bg-[#0a88b2] hover:bg-[#0a88b2]/90 text-white px-6 py-3 rounded-full font-semibold shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="inline-block">
                        <path d="M12.032 2.004c-5.514 0-9.996 4.48-9.996 9.99 0 1.76.46 3.484 1.32 4.996L2 22l5.196-1.44c1.468.86 3.122 1.316 4.832 1.316 5.514 0 9.996-4.48 9.996-9.99 0-5.51-4.482-9.99-9.996-9.99zm0 18.38c-1.488 0-2.95-.4-4.21-1.16l-.3-.18-3.08.85.83-3.01-.2-.31c-.82-1.3-1.26-2.8-1.26-4.33 0-4.54 3.7-8.24 8.24-8.24 4.54 0 8.24 3.7 8.24 8.24 0 4.54-3.7 8.24-8.24 8.24zm4.52-6.17c-.25-.12-1.48-.73-1.71-.81-.23-.09-.4-.12-.56.12-.16.25-.63.81-.77.98-.14.17-.28.19-.52.07-.25-.12-1.04-.38-1.98-1.22-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.5.11-.12.25-.3.37-.45.13-.15.17-.25.25-.42.09-.17.04-.32-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.48-.41-.41-.56-.42h-.48c-.17 0-.43.06-.66.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.78 2.72 4.32 3.81.6.26 1.07.42 1.44.54.6.19 1.15.16 1.58.1.48-.07 1.48-.6 1.69-1.19.21-.58.21-1.08.15-1.18-.06-.1-.22-.16-.47-.28z"/>
                    </svg>
                    <span>Konsultasi WhatsApp</span>
                </a>
                <a href="#services" class="border border-[#0a88b2] text-[#0a88b2] px-8 py-3 rounded-full font-semibold hover:bg-[#0a88b2]/5 transition">Lihat Layanan</a>
            </div>
        </div>
    </section>

    {{-- SERVICES GRID --}}
    <section id="services" class="py-20">
        <div class="content-container">
            <div class="text-center mb-16">
                <span class="text-[#0a88b2] font-mono text-sm uppercase tracking-wider">Core Services</span>
                <h2 class="text-4xl md:text-5xl font-bold text-slate-800 mt-2">Apa yang Kami Tawarkan?</h2>
                <div class="w-20 h-1 bg-[#0a88b2] mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $index => $service)
                <div class="group bg-white rounded-2xl p-6 border border-slate-100 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-2 hover:border-[#0a88b2]/30" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="w-16 h-16 rounded-xl bg-[#0a88b2]/10 flex items-center justify-center mb-5 group-hover:scale-110 transition duration-300">
                        <span class="material-symbols-outlined notranslate text-3xl text-[#0a88b2]">{{ $service->icon_image ?: 'settings' }}</span>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">{{ __t($service->title) }}</h3>
                    <p class="text-slate-500 leading-relaxed mb-4">{{ __t($service->short_description) }}</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="text-xs bg-[#0a88b2]/10 text-[#0a88b2] px-2 py-1 rounded-full">Modern Tech</span>
                        <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">Scalable</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('services.show', $service->slug) }}" class="text-[#0a88b2] font-semibold flex items-center gap-1 group-hover:gap-2 transition">
                            <span>Detail</span>
                            <span class="material-symbols-outlined notranslate text-sm">arrow_forward</span>
                        </a>
                        <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Saya tertarik dengan ' . __t($service->title)) }}" class="text-slate-400 hover:text-[#0a88b2] transition" title="Tanya via WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="inline-block">
                                <path d="M12.032 2.004c-5.514 0-9.996 4.48-9.996 9.99 0 1.76.46 3.484 1.32 4.996L2 22l5.196-1.44c1.468.86 3.122 1.316 4.832 1.316 5.514 0 9.996-4.48 9.996-9.99 0-5.51-4.482-9.99-9.996-9.99zm0 18.38c-1.488 0-2.95-.4-4.21-1.16l-.3-.18-3.08.85.83-3.01-.2-.31c-.82-1.3-1.26-2.8-1.26-4.33 0-4.54 3.7-8.24 8.24-8.24 4.54 0 8.24 3.7 8.24 8.24 0 4.54-3.7 8.24-8.24 8.24z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="py-16 bg-white">
        <div class="content-container">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @php
                    $stats = [
                        ['value' => '4+', 'label' => 'Proyek Selesai', 'icon' => 'checklist'],
                        ['value' => '98%', 'label' => 'Kepuasan Klien', 'icon' => 'sentiment_satisfied'],
                        ['value' => '24/7', 'label' => 'Dukungan Teknis', 'icon' => 'support_agent'],
                        ['value' => '4.9', 'label' => 'Rating Google', 'icon' => 'star']
                    ];
                @endphp
                @foreach($stats as $stat)
                <div class="bg-gradient-to-b from-white to-[#0a88b2]/5 rounded-2xl p-6 border border-[#0a88b2]/10 shadow-sm">
                    <span class="material-symbols-outlined notranslate text-4xl text-[#0a88b2]">{{ $stat['icon'] }}</span>
                    <div class="text-3xl md:text-4xl font-black text-slate-800 mt-2">{{ $stat['value'] }}</div>
                    <div class="text-slate-500 text-sm mt-1">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PROSES LAYANAN --}}
    <section class="py-20 bg-[#0a88b2]/5">
        <div class="content-container">
            <div class="text-center mb-16">
                <span class="text-[#0a88b2] font-mono text-sm uppercase tracking-wider">How We Work</span>
                <h2 class="text-4xl font-bold text-slate-800 mt-2">Proses Kolaborasi Kami</h2>
                <div class="w-20 h-1 bg-[#0a88b2] mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="max-w-3xl mx-auto relative">
                <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-[#0a88b2]/20 hidden md:block"></div>
                @php
                    $steps = [
                        ['icon' => 'search', 'title' => 'Discovery', 'desc' => 'Memahami visi, kebutuhan, dan target bisnis Anda'],
                        ['icon' => 'draw', 'title' => 'Perancangan', 'desc' => 'Membuat blueprint solusi dan prototype interaktif'],
                        ['icon' => 'code', 'title' => 'Development', 'desc' => 'Pengembangan agile dengan iterasi berkala'],
                        ['icon' => 'rocket_launch', 'title' => 'Launch & Optimasi', 'desc' => 'Deployment, monitoring, dan peningkatan berkelanjutan']
                    ];
                @endphp
                @foreach($steps as $i => $step)
                <div class="relative flex gap-6 mb-12 last:mb-0 group">
                    <div class="flex-shrink-0 w-16 h-16 rounded-full bg-white border-2 border-[#0a88b2] flex items-center justify-center text-[#0a88b2] group-hover:scale-110 transition z-10 shadow-sm">
                        <span class="material-symbols-outlined notranslate text-2xl">{{ $step['icon'] }}</span>
                    </div>
                    <div class="bg-white rounded-2xl p-6 flex-1 border border-slate-100 shadow-sm group-hover:shadow-md group-hover:border-[#0a88b2]/30 transition">
                        <h3 class="text-xl font-bold text-slate-800">{{ $step['title'] }}</h3>
                        <p class="text-slate-500 mt-1">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TECH STACK --}}
    <section class="py-16 bg-white">
        <div class="content-container text-center">
            <h3 class="text-2xl font-bold text-slate-800 mb-8">Teknologi yang Kami Kuasai</h3>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach(['Laravel', 'React', 'Vue.js', 'Flutter', 'Node.js', 'Tailwind', 'Express.js', 'Firebase', 'MySQL', 'Docker','Kotlin'] as $tech)
                <span class="bg-[#0a88b2]/10 text-[#0a88b2] px-4 py-2 rounded-full text-sm font-medium border border-[#0a88b2]/20 hover:bg-[#0a88b2] hover:text-white transition cursor-default">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA DENGAN TOMBOL WHATSAPP YANG PROFESIONAL --}}
    <section class="py-20 relative">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0a88b2]/10 via-white to-[#0a88b2]/10"></div>
        <div class="content-container relative">
            <div class="max-w-4xl mx-auto text-center bg-white rounded-3xl p-12 shadow-xl border border-[#0a88b2]/20">
                <span class="material-symbols-outlined notranslate text-6xl text-[#0a88b2]">rocket_launch</span>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-800 mt-4">Siap Meluncurkan Proyek Anda?</h3>
                <p class="text-slate-500 mt-3 mb-8 max-w-lg mx-auto">Dapatkan penawaran terbaik dan konsultasi gratis bersama tim ahli kami.</p>
                <div class="flex flex-wrap gap-4 justify-center">
                    {{-- TOMBOL WHATSAPP YANG JELAS DAN PROFESIONAL --}}
                    <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Halo, saya ingin konsultasi proyek digital') }}" 
                       class="inline-flex items-center gap-2 bg-[#0a88b2] hover:bg-[#0a88b2]/90 text-white px-6 py-3 rounded-full font-semibold shadow-md transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="inline-block">
                            <path d="M12.032 2.004c-5.514 0-9.996 4.48-9.996 9.99 0 1.76.46 3.484 1.32 4.996L2 22l5.196-1.44c1.468.86 3.122 1.316 4.832 1.316 5.514 0 9.996-4.48 9.996-9.99 0-5.51-4.482-9.99-9.996-9.99zm0 18.38c-1.488 0-2.95-.4-4.21-1.16l-.3-.18-3.08.85.83-3.01-.2-.31c-.82-1.3-1.26-2.8-1.26-4.33 0-4.54 3.7-8.24 8.24-8.24 4.54 0 8.24 3.7 8.24 8.24 0 4.54-3.7 8.24-8.24 8.24z"/>
                        </svg>
                        <span>Konsultasi via WhatsApp</span>
                    </a>
                    <a href="{{ url('/#kontak') }}" class="border border-[#0a88b2] text-[#0a88b2] px-6 py-3 rounded-full font-semibold hover:bg-[#0a88b2]/5 transition">Form Kontak</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection