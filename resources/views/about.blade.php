@extends('layouts.main')

@section('title', 'Tentang Kami - ' . ($settings->company_name ?? 'Rakira Digital Nusantara') . ' | Software House Indonesia')
@section('meta_description', 'Kenali tim profesional Rakira Digital Nusantara — software house terpercaya di Tangerang yang berdedikasi menghadirkan solusi teknologi terbaik untuk bisnis Indonesia sejak 2020.')
@section('meta_keywords', 'tentang rakira digital, profil perusahaan software house, tim developer indonesia, software house tangerang banten, visi misi perusahaan IT, digital agency indonesia')

@push('structured_data')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "AboutPage",
  "name": "Tentang {{ $settings->company_name ?? 'Rakira Digital Nusantara' }}",
  "description": "Software house profesional di Tangerang, Indonesia.",
  "url": "{{ url('/tentang-kami') }}",
  "mainEntity": {
    "@@type": "Organization",
    "@@id": "{{ url('/') }}/#organization",
    "name": "{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}",
    "member": [
      @foreach($teams as $i => $member)
      {
        "@@type": "Person",
        "name": "{{ $member->name }}",
        "jobTitle": "{{ __t($member->position) }}",
        "worksFor": { "@@id": "{{ url('/') }}/#organization" }
      }{{ !$loop->last ? ',' : '' }}
      @endforeach
    ]
  }
}
</script>
@endpush

@section('content')
<div class="bg-gradient-to-b from-white via-[#0a88b2]/5 to-white pt-16 pb-20 overflow-x-hidden">
    
    {{-- Hero dengan typing & background animasi --}}
    <section class="relative text-center px-4 py-12 md:py-20 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_#0a88b210_0%,_transparent_70%)]"></div>
        <div class="absolute top-20 left-10 w-56 h-56 md:w-72 md:h-72 bg-[#0a88b2]/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 md:w-80 md:h-80 bg-[#0a88b2]/10 rounded-full blur-3xl animate-pulse-slow animation-delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[600px] md:h-[600px] bg-[#0a88b2]/5 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>
        <div class="absolute inset-0 opacity-20 hidden md:block" style="background-image: radial-gradient(#0a88b2 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="relative z-10 max-w-5xl mx-auto" 
             x-data="{ 
                text: '', 
                fullText: '{{ __("Kami adalah ") }}',
                typingDone: false,
                init() {
                    let i = 0;
                    let timer = setInterval(() => {
                        if (i < this.fullText.length) {
                            this.text += this.fullText.charAt(i);
                            i++;
                        } else {
                            clearInterval(timer);
                            this.typingDone = true;
                        }
                    }, 50);
                }
             }">
            <div class="inline-flex items-center gap-2 bg-white/60 backdrop-blur-md rounded-full px-4 py-1.5 text-xs md:text-sm font-semibold text-[#0a88b2] border border-[#0a88b2]/20 shadow-sm mb-6 hover:scale-105 transition-transform duration-300">
                <span class="material-symbols-outlined notranslate text-sm">bolt</span>
                <span>{{ __('Digital Innovation Partner') }}</span>
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-slate-800 leading-[1.15] tracking-tight min-h-[1.2em]">
                <span x-text="text" class="bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent"></span>
                <template x-if="typingDone">
                    <span class="inline-block" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <span class="bg-gradient-to-r from-[#0a88b2] to-[#0a88b2]/80 bg-clip-text text-transparent relative">
                            {{ __('Ekosistem Digital') }}
                            <span class="absolute -bottom-2 left-0 w-full h-1 bg-[#0a88b2]/30 rounded-full animate-pulse"></span>
                        </span> 
                        <span class="text-slate-800">{{ __('Terpercaya') }}</span>
                    </span>
                </template>
                <span class="text-[#0a88b2] animate-pulse" x-show="!typingDone">|</span>
            </h1>
            <p class="text-slate-500 text-base md:text-lg lg:text-xl mt-5 md:mt-6 max-w-3xl mx-auto px-2 leading-relaxed" data-aos="fade-up" data-aos-delay="800">
                {{ __('Kami adalah kolektif profesional ahli teknologi, desainer, dan pengembang software yang berdedikasi menciptakan solusi IT terbaik untuk bisnis Anda.') }}
            </p>
            <div class="flex flex-wrap justify-center gap-4 mt-8 md:mt-10" data-aos="fade-up" data-aos-delay="1000">
                <a href="#team" class="group bg-[#0a88b2] hover:bg-[#0a88b2]/90 text-white px-6 py-2.5 md:px-7 md:py-3 rounded-full font-semibold shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 active:scale-95 inline-flex items-center gap-2 text-sm md:text-base">
                    <span>{{ __('Kenali Tim Kami') }}</span>
                    <span class="material-symbols-outlined notranslate text-sm md:text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
                <a href="#values" class="group border-2 border-[#0a88b2] text-[#0a88b2] hover:bg-[#0a88b2]/10 px-6 py-2.5 md:px-7 md:py-3 rounded-full font-semibold transition-all duration-300 hover:-translate-y-0.5 active:scale-95 inline-flex items-center gap-2 text-sm md:text-base">
                    <span>{{ __('Visi & Misi') }}</span>
                    <span class="material-symbols-outlined notranslate text-sm md:text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>
        <!-- Abstract wave illustration -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0] z-0">
            <svg class="relative block w-full h-12 md:h-16" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-white"></path>
            </svg>
        </div>
    </section>

    {{-- Visi & Misi + Statistik --}}
    <section class="py-12 md:py-20 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div data-aos="fade-right" data-aos-duration="700">
                    <div class="inline-flex items-center gap-2 bg-[#0a88b2]/10 rounded-full px-3 py-1 text-xs font-semibold text-[#0a88b2] mb-4">
                        <span class="material-symbols-outlined notranslate text-sm">lightbulb</span>
                        <span>{{ __('Visi & Misi') }}</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-slate-800 mt-2 mb-4 md:mb-6 leading-tight">{{ __('Tujuan & Komitmen Kami') }}</h2>
                    <p class="text-slate-500 leading-relaxed text-base md:text-lg mb-8 md:mb-10">
                        {{ __('Rakira Digital Nusantara hadir sebagai mitra transformasi digital yang mengutamakan inovasi, integritas, dan dampak nyata bagi klien.') }}
                    </p>
                    <div class="space-y-6 md:space-y-8">
                        {{-- VISI dari database --}}
                        <div class="flex gap-4 group cursor-pointer">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-[#0a88b2]/20 to-[#0a88b2]/5 flex items-center justify-center text-[#0a88b2] group-hover:bg-[#0a88b2] group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined notranslate text-2xl">visibility</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl md:text-2xl text-slate-800 mb-1">{{ __('Visi') }}</h3>
                                <p class="text-slate-500 text-sm md:text-base">{{ $settings->vision ?? 'Menjadi ekosistem digital terdepan di Asia Tenggara yang memberdayakan bisnis melalui teknologi.' }}</p>
                            </div>
                        </div>
                        {{-- MISI dari database --}}
                        <div class="flex gap-4 group cursor-pointer">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-[#0a88b2]/20 to-[#0a88b2]/5 flex items-center justify-center text-[#0a88b2] group-hover:bg-[#0a88b2] group-hover:text-white transition-all duration-300">
                                <span class="material-symbols-outlined notranslate text-2xl">flag</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl md:text-2xl text-slate-800 mb-1">{{ __('Misi') }}</h3>
                                <p class="text-slate-500 text-sm md:text-base">{{ $settings->mission ?? 'Memberikan solusi IT berkualitas tinggi, memberdayakan talenta lokal, dan menciptakan dampak sosial melalui teknologi.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STATISTIK (Statis, mudah diubah langsung di sini) --}}
                <div class="grid grid-cols-2 gap-4 md:gap-6" data-aos="fade-left" data-aos-duration="700" data-aos-delay="200">
                    @php
                        // ✏️ GANTI ANGKA BERIKUT SESUAI DATA PERUSAHAAN ANDA
                        $tahunBerdiri = 2026;
                        $proyekSelesai = 4;
                        $klienAktif = 4;
                        $kepuasan = 98;

                        $stats = [
                            ['value' => $tahunBerdiri, 'label' => 'Tahun Berdiri', 'icon' => 'event', 'suffix' => ''],
                            ['value' => $proyekSelesai, 'label' => 'Proyek Selesai', 'icon' => 'checklist', 'suffix' => '+'],
                            ['value' => $klienAktif, 'label' => 'Klien Aktif', 'icon' => 'groups', 'suffix' => '+'],
                            ['value' => $kepuasan, 'label' => 'Kepuasan', 'icon' => 'sentiment_satisfied', 'suffix' => '%']
                        ];
                    @endphp
                    @foreach($stats as $stat)
                    <div class="bg-gradient-to-br from-white to-[#0a88b2]/5 rounded-xl p-4 md:p-5 text-center border border-[#0a88b2]/10 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                        <div class="w-12 h-12 md:w-14 md:h-14 mx-auto rounded-full bg-[#0a88b2]/10 flex items-center justify-center text-[#0a88b2] group-hover:bg-[#0a88b2] group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined notranslate text-2xl md:text-3xl">{{ $stat['icon'] }}</span>
                        </div>
                        <div class="text-2xl md:text-3xl font-black text-slate-800 mt-3">
                            {{ $stat['value'] }}{{ $stat['suffix'] }}
                        </div>
                        <div class="text-slate-500 text-xs md:text-sm mt-1 font-medium">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Tim Kami --}}
    <section id="team" class="py-12 md:py-20 bg-[#0a88b2]/5 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-10 md:mb-16" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm rounded-full px-3 py-1 text-xs font-semibold text-[#0a88b2] border border-[#0a88b2]/20 mb-3">
                    <span class="material-symbols-outlined notranslate text-sm">groups</span>
                    <span>{{ __('Our Team') }}</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold text-slate-800 mt-2">{{ __('Tim Ahli Rakira Digital') }}</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-[#0a88b2] to-[#0a88b2]/40 mx-auto mt-4 rounded-full"></div>
                <p class="text-slate-500 max-w-2xl mx-auto mt-4 text-base md:text-lg">{{ __('Didukung oleh profesional berpengalaman di bidangnya, siap membantu kesuksesan digital Anda.') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @forelse($teams as $index => $team)
                <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-2" 
                     data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ ($index % 4) * 100 }}">
                    <div class="relative h-64 md:h-72 overflow-hidden">
                        <img src="{{ $team->photo ? asset('storage/' . $team->photo) : asset('images/default-avatar.png') }}" 
                             alt="{{ $team->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-4">
                            <div class="flex gap-2 mb-2">
                                <a href="#" class="bg-white/20 backdrop-blur-md p-2 rounded-full hover:bg-[#0a88b2] transition-all duration-300 hover:scale-110">
                                    <span class="material-symbols-outlined notranslate text-white text-sm">link</span>
                                </a>
                            </div>
                            <p class="text-white text-xs line-clamp-2 opacity-90">{{ __t($team->description) }}</p>
                        </div>
                    </div>
                    <div class="p-5 text-center">
                        <h3 class="text-lg md:text-xl font-bold text-slate-800">{{ $team->name }}</h3>
                        <p class="text-[#0a88b2] font-semibold text-xs md:text-sm mb-2">{{ __t($team->position) }}</p>
                        <div class="flex flex-wrap justify-center gap-1.5 mt-2">
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">Agile</span>
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">Leadership</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-slate-500 bg-white/70 rounded-2xl backdrop-blur-sm">
                    <span class="material-symbols-outlined notranslate text-5xl">group_off</span>
                    <p class="mt-2 text-base">{{ __('Belum ada data tim. Segera hadir.') }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Milestones / Perjalanan Perusahaan --}}
    <section class="py-12 md:py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 md:mb-16" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 bg-[#0a88b2]/10 rounded-full px-3 py-1 text-xs font-semibold text-[#0a88b2] mb-3">
                    <span class="material-symbols-outlined notranslate text-sm">timeline</span>
                    <span>{{ __('Milestones') }}</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold text-slate-800 mt-2">{{ __('Perjalanan Kami') }}</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-[#0a88b2] to-[#0a88b2]/40 mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="relative">
                <div class="absolute left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-gradient-to-b from-[#0a88b2]/20 via-[#0a88b2]/40 to-[#0a88b2]/20 hidden md:block"></div>
                <div class="space-y-12 md:space-y-0">
                    @php
                        $milestones = [
                            ['year' => 'Maret 2026', 'title' => 'Berdiri', 'desc' => 'Rakira Digital didirikan dengan visi menjadi mitra transformasi digital.', 'icon' => 'rocket_launch'],
                            ['year' => 'April 2026', 'title' => 'Ekspansi Tim', 'desc' => 'Memperkuat tim ahli di bidang pengembangan software & desain.', 'icon' => 'group_add'],
                            ['year' => 'Juni 2026', 'title' => '4+ Proyek', 'desc' => 'Telah menyelesaikan lebih dari 4 proyek untuk berbagai industri.', 'icon' => 'checklist'],
                            ['year' => 'Juli 2026', 'title' => 'Skala Regional', 'desc' => 'Memperluas jangkauan ke klien di Asia Tenggara.', 'icon' => 'public']
                        ];
                    @endphp
                    @foreach($milestones as $i => $ms)
                    <div class="relative flex flex-col md:flex-row items-center md:even:flex-row-reverse gap-6 md:gap-10 group" 
                         data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $i * 100 }}">
                        <div class="md:w-1/2 text-center md:text-right md:even:text-left px-3">
                            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-[#0a88b2]/10 to-white rounded-full px-3 py-1 text-xs font-bold text-[#0a88b2] mb-2 shadow-sm">
                                <span class="material-symbols-outlined notranslate text-sm">{{ $ms['icon'] }}</span>
                                <span>{{ $ms['year'] }}</span>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-slate-800">{{ $ms['title'] }}</h3>
                            <p class="text-slate-500 mt-2 text-sm md:text-base">{{ $ms['desc'] }}</p>
                        </div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 md:w-5 md:h-5 bg-[#0a88b2] rounded-full border-3 border-white shadow-md z-10 hidden md:flex items-center justify-center group-hover:scale-150 transition-transform duration-300">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="md:w-1/2"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Nilai Inti Perusahaan --}}
    <section id="values" class="py-12 md:py-20 bg-[#0a88b2]/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 md:mb-16" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 bg-white/70 backdrop-blur-sm rounded-full px-3 py-1 text-xs font-semibold text-[#0a88b2] border border-[#0a88b2]/20 mb-3">
                    <span class="material-symbols-outlined notranslate text-sm">stars</span>
                    <span>{{ __('Core Values') }}</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold text-slate-800 mt-2">{{ __('Nilai yang Kami Pegang') }}</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-[#0a88b2] to-[#0a88b2]/40 mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @php
                    $values = [
                        ['icon' => 'lightbulb', 'title' => 'Inovasi', 'desc' => 'Menghadirkan solusi kreatif dan teknologi terkini yang memberikan nilai lebih bagi klien.', 'color' => 'from-amber-500 to-orange-500'],
                        ['icon' => 'shield', 'title' => 'Integritas', 'desc' => 'Berpegang pada etika, transparansi, dan tanggung jawab penuh dalam setiap proyek.', 'color' => 'from-emerald-500 to-teal-500'],
                        ['icon' => 'handshake', 'title' => 'Kolaborasi', 'desc' => 'Mitra jangka panjang yang mendukung pertumbuhan bisnis Anda secara berkelanjutan.', 'color' => 'from-blue-500 to-cyan-500'],
                        ['icon' => 'star', 'title' => 'Keunggulan', 'desc' => 'Standar tinggi dalam setiap hasil karya, didukung oleh proses quality assurance.', 'color' => 'from-purple-500 to-pink-500']
                    ];
                @endphp
                @foreach($values as $idx => $val)
                <div class="group bg-white rounded-xl md:rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-2 relative overflow-hidden" 
                     data-aos="zoom-in-up" data-aos-duration="500" data-aos-delay="{{ $idx * 100 }}">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r {{ $val['color'] }} transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-[#0a88b2]/20 to-[#0a88b2]/5 rounded-full flex items-center justify-center text-[#0a88b2] group-hover:bg-gradient-to-br group-hover:from-[#0a88b2] group-hover:to-[#0a88b2]/80 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined notranslate text-3xl">{{ $val['icon'] }}</span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 mt-4">{{ $val['title'] }}</h3>
                    <p class="text-slate-500 text-sm md:text-base mt-2 leading-relaxed">{{ $val['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Premium --}}
    <section class="py-16 md:py-20 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0a88b2]/20 via-white to-[#0a88b2]/20"></div>
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-[#0a88b2]/30 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-[#0a88b2]/20 rounded-full blur-3xl animate-pulse-slow animation-delay-1000"></div>
        <div class="relative z-10 max-w-5xl mx-auto px-4">
            <div data-aos="zoom-in" data-aos-duration="700">
                <div class="bg-white/60 backdrop-blur-xl rounded-2xl md:rounded-3xl p-6 md:p-10 shadow-xl border border-white/50">
                    <span class="material-symbols-outlined notranslate text-5xl md:text-6xl text-[#0a88b2] animate-bounce">rocket_launch</span>
                    <h3 class="text-2xl md:text-4xl lg:text-5xl font-bold text-slate-800 mt-4">{{ __('Tertarik Bekerja Sama?') }}</h3>
                    <p class="text-slate-500 mt-3 mb-6 max-w-2xl mx-auto text-base md:text-lg">{{ __('Jadilah bagian dari perjalanan digital bersama tim ahli kami. Konsultasi gratis tersedia.') }}</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="https://wa.me/{{ $settings->phone ?? '6287868184742' }}?text={{ urlencode('Halo, saya tertarik bekerja sama dengan Rakira Digital.') }}" 
                           class="group inline-flex items-center gap-2 bg-[#0a88b2] hover:bg-[#0a88b2]/90 text-white px-6 py-3 rounded-full font-semibold text-sm md:text-base shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.032 2.004c-5.514 0-9.996 4.48-9.996 9.99 0 1.76.46 3.484 1.32 4.996L2 22l5.196-1.44c1.468.86 3.122 1.316 4.832 1.316 5.514 0 9.996-4.48 9.996-9.99 0-5.51-4.482-9.99-9.996-9.99z"/>
                            </svg>
                            <span>{{ __('Konsultasi via WhatsApp') }}</span>
                            <span class="material-symbols-outlined notranslate text-sm md:text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                        <a href="{{ url('/#kontak') }}" class="group border-2 border-[#0a88b2] text-[#0a88b2] hover:bg-[#0a88b2]/10 px-6 py-3 rounded-full font-semibold text-sm md:text-base transition-all duration-300 hover:-translate-y-0.5 active:scale-95 inline-flex items-center gap-2">
                            <span>{{ __('Kirim Pesan') }}</span>
                            <span class="material-symbols-outlined notranslate text-sm md:text-base group-hover:translate-x-1 transition-transform">email</span>
                        </a>
                    </div>
                    <p class="text-slate-400 text-xs md:text-sm mt-6">*Respon dalam waktu kurang dari 1x24 jam</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    [x-cloak] { display: none; }
    .animate-pulse-slow {
        animation: pulse-slow 4s ease-in-out infinite;
    }
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    @keyframes pulse-slow {
        0%, 100% { opacity: 0.2; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.05); }
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    @media (max-width: 640px) {
        .line-clamp-2 {
            -webkit-line-clamp: 2;
        }
    }
</style>

<script>
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 700, once: true, offset: 60, easing: 'ease-out-quad' });
    }
    // Smooth scroll untuk anchor link
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    // Refresh AOS after dynamic content
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof AOS !== 'undefined') AOS.refresh();
    });
</script>
@endsection