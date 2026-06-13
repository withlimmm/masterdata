@php
    $titleData = json_decode($service->title, true);
    $shortDescriptionData = json_decode($service->short_description, true);
    $fullDescriptionData = json_decode($service->full_description, true);

    $titleId = old('title_id', is_array($titleData) ? ($titleData['id'] ?? $titleData['en'] ?? $service->title) : $service->title);
    $titleEn = old('title_en', is_array($titleData) ? ($titleData['en'] ?? '') : '');
    $shortDescriptionId = old('short_description_id', is_array($shortDescriptionData) ? ($shortDescriptionData['id'] ?? $shortDescriptionData['en'] ?? $service->short_description) : $service->short_description);
    $shortDescriptionEn = old('short_description_en', is_array($shortDescriptionData) ? ($shortDescriptionData['en'] ?? '') : '');
    $fullDescriptionId = old('full_description_id', is_array($fullDescriptionData) ? ($fullDescriptionData['id'] ?? $fullDescriptionData['en'] ?? $service->full_description) : $service->full_description);
    $fullDescriptionEn = old('full_description_en', is_array($fullDescriptionData) ? ($fullDescriptionData['en'] ?? '') : '');
@endphp

@extends('layouts.admin')

@section('title', 'Edit Layanan - Rakira CMS')
@section('page_title', 'Perbarui Layanan')
@section('page_subtitle', 'Sesuaikan detail konten layanan yang sudah ada.')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    {{-- Header Actions --}}
    <div class="mb-8 flex items-center justify-between animate-in slide-in-from-left duration-500">
        <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-5 py-2.5 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-slate-900 hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm group">
            <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="text-[10px] font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            {{-- Kiri: Detail Info --}}
            <div class="xl:col-span-8 space-y-8">
                
                {{-- Penamaan Layanan --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 md:p-10 shadow-sm relative overflow-hidden group hover:border-slate-300 transition-colors">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-[100px] -z-0 opacity-50 group-hover:scale-110 transition-transform"></div>
                    
                    <div class="flex items-center gap-4 mb-8 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-inner">
                            <span class="material-symbols-outlined text-xl">subtitles</span>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-1">Informasi Dasar</h3>
                            <p class="text-[10px] text-slate-400 font-medium">Judul dan penamaan layanan utama</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                        <div class="space-y-2">
                            <label for="title_id" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Judul Layanan (ID) <span class="text-red-400">*</span></label>
                            <input type="text" name="title_id" id="title_id" required value="{{ $titleId }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none text-slate-700 placeholder-slate-300">
                        </div>

                        <div class="space-y-2">
                            <label for="title_en" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Service Title (EN)</label>
                            <input type="text" name="title_en" id="title_en" value="{{ $titleEn }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none text-slate-700 placeholder-slate-300">
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Singkat --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 md:p-10 shadow-sm hover:border-slate-300 transition-colors">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-inner">
                            <span class="material-symbols-outlined text-xl">short_text</span>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-1">Deskripsi Singkat</h3>
                            <p class="text-[10px] text-slate-400 font-medium">Teks pendek untuk kartu layanan di beranda</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="short_description_id" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Teks Pendek (ID) <span class="text-red-400">*</span></label>
                            <textarea name="short_description_id" id="short_description_id" rows="4" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all outline-none resize-none text-slate-700 placeholder-slate-300">{{ $shortDescriptionId }}</textarea>
                        </div>

                        <div class="space-y-2">
                            <label for="short_description_en" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Short Text (EN)</label>
                            <textarea name="short_description_en" id="short_description_en" rows="4"
                                class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all outline-none resize-none text-slate-700 placeholder-slate-300">{{ $shortDescriptionEn }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi Lengkap --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 md:p-10 shadow-sm hover:border-slate-300 transition-colors">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shadow-inner">
                            <span class="material-symbols-outlined text-xl">article</span>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-1">Konten Deskripsi Penuh</h3>
                            <p class="text-[10px] text-slate-400 font-medium">Penjelasan mendalam saat layanan di-klik detailnya</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between ml-1">
                                <label for="full_description_id" class="text-[10px] font-black uppercase tracking-widest text-slate-400">Konten Detail (Indonesia)</label>
                                <span class="text-[9px] font-bold text-slate-300 uppercase tracking-wider bg-slate-50 px-2 py-1 rounded-md border border-slate-100">ID</span>
                            </div>
                            <textarea name="full_description_id" id="full_description_id" rows="6"
                                class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all outline-none resize-y text-slate-700 placeholder-slate-300">{{ $fullDescriptionId }}</textarea>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-slate-100 border-dashed">
                            <div class="flex items-center justify-between ml-1">
                                <label for="full_description_en" class="text-[10px] font-black uppercase tracking-widest text-slate-400">Full Description (English)</label>
                                <span class="text-[9px] font-bold text-slate-300 uppercase tracking-wider bg-slate-50 px-2 py-1 rounded-md border border-slate-100">EN</span>
                            </div>
                            <textarea name="full_description_en" id="full_description_en" rows="6"
                                class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all outline-none resize-y text-slate-700 placeholder-slate-300">{{ $fullDescriptionEn }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Icon & Status --}}
            <div class="xl:col-span-4 space-y-8">
                
                {{-- Status --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-slate-400">tune</span>
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-800">Status Publikasi</label>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer hidden" {{ $service->status == 'active' ? 'checked' : '' }}>
                            <div class="flex items-center gap-4 px-6 py-4 rounded-[1.25rem] bg-slate-50 border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all group hover:border-emerald-300">
                                <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center peer-checked:border-emerald-500 group-hover:scale-110 transition-transform shadow-sm">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-200 peer-checked:bg-emerald-500 transition-colors"></span>
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest mb-0.5">Aktif / Terbit</p>
                                    <p class="text-[10px] text-slate-400 font-medium normal-case tracking-normal">Tampil di beranda publik</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="draft" class="peer hidden" {{ $service->status == 'draft' ? 'checked' : '' }}>
                            <div class="flex items-center gap-4 px-6 py-4 rounded-[1.25rem] bg-slate-50 border border-slate-200 peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all group hover:border-slate-400">
                                <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center peer-checked:border-slate-700 group-hover:scale-110 transition-transform shadow-sm">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-200 peer-checked:bg-white transition-colors"></span>
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest mb-0.5">Simpan Draft</p>
                                    <p class="text-[10px] text-slate-400 peer-checked:text-slate-300 font-medium normal-case tracking-normal">Disembunyikan sementara</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Icon Picker --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-slate-400">category</span>
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-800">Ikon Representasi</label>
                    </div>
                    
                    {{-- Preview --}}
                    <div class="flex flex-col items-center justify-center p-8 bg-slate-50 rounded-3xl border border-slate-200/60 mb-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-grid-slate-100/[0.2] bg-[size:20px_20px]"></div>
                        
                        <div class="w-20 h-20 bg-white rounded-[1.5rem] shadow-md flex items-center justify-center text-slate-800 border border-slate-100 relative z-10 hover:scale-110 hover:shadow-lg transition-all duration-500 hover:-rotate-3">
                            <span id="iconPreview" class="material-symbols-outlined text-[40px]">{{ $service->icon_image ?? 'category' }}</span>
                        </div>
                        
                        <div class="mt-5 relative z-10 w-full">
                            <input type="text" name="icon_image" id="iconInput" value="{{ old('icon_image', $service->icon_image) }}" readonly
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-[11px] font-black text-center text-slate-600 uppercase tracking-widest outline-none shadow-sm cursor-default">
                        </div>
                    </div>

                    {{-- Popular Icons Grid --}}
                    <div class="space-y-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Rekomendasi Ikon</p>
                        
                        <div class="grid grid-cols-4 gap-2">
                            @php
                                $icons = [
                                    'web', 'smartphone', 'terminal', 'cloud', 
                                    'design_services', 'monitoring', 'campaign', 'hub',
                                    'database', 'security', 'api', 'rocket_launch',
                                    'settings_suggest', 'psychology', 'query_stats', 'language'
                                ];
                            @endphp
                            @foreach($icons as $icon)
                                <button type="button" onclick="selectIcon('{{ $icon }}')" 
                                    class="h-12 rounded-[14px] border border-slate-100 hover:border-slate-800 hover:text-white hover:bg-slate-800 transition-all flex items-center justify-center bg-slate-50/50 text-slate-500 shadow-sm active:scale-95">
                                    <span class="material-symbols-outlined text-xl">{{ $icon }}</span>
                                </button>
                            @endforeach
                        </div>
                        <p class="text-[9px] text-slate-400 text-center font-medium pt-2">Klik salah satu ikon untuk mengganti</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Action Buttons Bottom --}}
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 sticky bottom-6 z-40">
            <div class="text-xs text-slate-400 font-medium hidden md:block">
                Pastikan semua isian wajib (<span class="text-red-400">*</span>) telah diisi.
            </div>
            <button type="submit" 
                class="w-full sm:w-auto bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.15em] shadow-xl shadow-slate-900/20 hover:bg-slate-800 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3">
                <span class="material-symbols-outlined text-xl">update</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function selectIcon(iconName) {
        const input = document.getElementById('iconInput');
        const preview = document.getElementById('iconPreview');
        
        // Add subtle animation
        preview.style.transform = 'scale(0.8) rotate(10deg)';
        preview.style.opacity = '0';
        
        setTimeout(() => {
            input.value = iconName;
            preview.innerText = iconName;
            
            preview.style.transform = 'scale(1) rotate(0deg)';
            preview.style.opacity = '1';
        }, 150);
    }
</script>
@endsection
