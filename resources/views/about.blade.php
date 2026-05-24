@extends('layouts.main')

@section('title', __('Tentang Kami - Rakira Digital Nusantara'))
@section('meta_description', __('Kolektif profesional ahli teknologi, desainer, dan pengembang software Rakira Digital Nusantara yang berdedikasi menciptakan solusi IT terbaik.'))

@section('content')
    <div class="pt-24 pb-section-padding">
        <section class="page-hero bg-white text-center" data-aos="fade-up">
            <div class="content-container max-w-4xl" 
                 x-data="{ 
                    text: '', 
                    fullText: '{{ __('about.hero_prefix') }} ',
                    typingDone: false,
                    init() {
                        let i = 0;
                        let timer = setInterval(() => {
                            this.text += this.fullText.charAt(i);
                            i++;
                            if (i >= this.fullText.length) {
                                clearInterval(timer);
                                this.typingDone = true;
                            }
                        }, 80);
                    }
                 }">
                <div
                    class="inline-flex items-center space-x-2 bg-primary/10 px-4 py-1.5 text-primary rounded-full mb-6 transition-transform duration-300 hover:scale-105">
                    <span class="material-symbols-outlined notranslate text-[18px]" translate="no">groups</span>
                    <span class="font-semibold text-sm">{{ __('Tim Kami') }}</span>
                </div>
                
                <h1 class="mx-auto mb-6 max-w-4xl text-4xl font-black leading-[1.05] tracking-tight text-on-surface sm:text-5xl lg:text-7xl min-h-[1.1em]">
                    <span x-text="text"></span><template x-if="typingDone"><span class="inline-block" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"><span class="text-primary relative inline-block">{{ __('about.hero_highlight') }}<span class="absolute -bottom-2 left-0 w-full h-1.5 bg-primary/20 rounded-full"></span></span> {{ __('about.hero_suffix') }}</span></template><span class="animate-ping text-primary" x-show="!typingDone">|</span>
                </h1>

                <p class="section-subtitle mx-auto text-center" data-aos="fade-up" data-aos-delay="1500">
                    {{ __('Kolektif profesional berdedikasi dengan pengalaman mendalam dalam merancang dan mengembangkan solusi digital inovatif.') }}
                </p>
            </div>
        </section>

        <section class="page-section">
            <div class="content-container grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">

                {{-- Asumsikan data dilempar dari controller dengan variabel $teams --}}
                @forelse($teams as $index => $team)
                    <div class="group surface-card rounded-3xl border-t-4 border-primary-container p-6 transition-all duration-300 hover:-translate-y-3 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)]"
                        data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div
                                class="w-28 h-28 rounded-full overflow-hidden mb-5 border-4 border-primary/10 transition-all duration-300 group-hover:border-primary-container group-hover:shadow-lg">
                                {{-- Mengambil foto dari storage, jika tidak ada pakai gambar default --}}
                                <img src="{{ $team->photo ? asset('storage/' . $team->photo) : asset('images/default-avatar.png') }}"
                                    alt="{{ $team->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>

                            <h3
                                class="text-xl font-bold text-on-surface mb-1 transition-colors duration-300 group-hover:text-primary-container">
                                {{ $team->name }}
                            </h3>
                            <p class="text-primary-container font-semibold text-sm mb-4">{{ __t($team->position) }}</p>
                            <p class="text-on-surface-variant text-sm mb-6 line-clamp-3">{{ __t($team->description) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-on-surface-variant">
                        <p>{{ __('Belum ada data tim yang ditambahkan.') }}</p>
                    </div>
                @endforelse

            </div>
        </section>

        <section class="page-section">
            <div class="content-container">
                <div class="glass-panel relative overflow-hidden rounded-3xl p-8 md:p-12" data-aos="zoom-in"
                    data-aos-duration="800">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 animate-pulse">
                    </div>
                    <div class="relative z-10">
                        <h2 class="mb-12 text-center text-3xl font-black text-on-surface md:text-5xl">{{ __('Nilai Inti Kami') }}</h2>
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">

                            <div
                                class="group flex flex-col items-center text-center transition-transform duration-300 hover:-translate-y-2">
                                <div
                                    class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary-container mb-4 transition-transform duration-300 group-hover:rotate-12 group-hover:bg-primary/20">
                                    <span class="material-symbols-outlined notranslate text-[32px]" translate="no">lightbulb</span>
                                </div>
                                <h4 class="font-bold text-lg text-on-surface mb-2">{{ __('Innovation') }}</h4>
                                <p class="text-on-surface-variant text-sm">{{ __('Menghadirkan teknologi kreatif dan relevan') }}</p>
                            </div>

                            <div class="group flex flex-col items-center text-center transition-transform duration-300 hover:-translate-y-2"
                                data-aos-delay="100">
                                <div
                                    class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary-container mb-4 transition-transform duration-300 group-hover:rotate-12 group-hover:bg-primary/20">
                                    <span class="material-symbols-outlined notranslate text-[32px]" translate="no">shield</span>
                                </div>
                                <h4 class="font-bold text-lg text-on-surface mb-2">{{ __('Integrity') }}</h4>
                                <p class="text-on-surface-variant text-sm">{{ __('Menjaga kepercayaan dengan profesionalisme') }}</p>
                            </div>

                            <div class="group flex flex-col items-center text-center transition-transform duration-300 hover:-translate-y-2"
                                data-aos-delay="200">
                                <div
                                    class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary-container mb-4 transition-transform duration-300 group-hover:rotate-12 group-hover:bg-primary/20">
                                    <span class="material-symbols-outlined notranslate text-[32px]" translate="no">handshake</span>
                                </div>
                                <h4 class="font-bold text-lg text-on-surface mb-2">{{ __('Collaboration') }}</h4>
                                <p class="text-on-surface-variant text-sm">{{ __('Tumbuh bersama klien melalui kemitraan') }}</p>
                            </div>

                            <div class="group flex flex-col items-center text-center transition-transform duration-300 hover:-translate-y-2"
                                data-aos-delay="300">
                                <div
                                    class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary-container mb-4 transition-transform duration-300 group-hover:rotate-12 group-hover:bg-primary/20">
                                    <span class="material-symbols-outlined notranslate text-[32px]" translate="no">star</span>
                                </div>
                                <h4 class="font-bold text-lg text-on-surface mb-2">{{ __('Excellence') }}</h4>
                                <p class="text-on-surface-variant text-sm">{{ __('Memberikan hasil terbaik dengan standar tinggi') }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection