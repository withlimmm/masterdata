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

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- Header Actions --}}
    <div class="mb-8 flex items-center justify-between animate-in slide-in-from-left duration-500">
        <a href="{{ route('admin.services.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-900 transition-colors group">
            <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="text-xs font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Kiri: Detail Info --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 md:p-10 shadow-sm space-y-6">
                    {{-- Judul --}}
                    <div class="space-y-2">
                        <label for="title_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Judul Layanan (Indonesia)</label>
                        <input type="text" name="title_id" id="title_id" required value="{{ $titleId }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                    </div>

                    <div class="space-y-2">
                        <label for="title_en" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Service Title (English)</label>
                        <input type="text" name="title_en" id="title_en" value="{{ $titleEn }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                    </div>

                    {{-- Deskripsi Singkat --}}
                    <div class="space-y-2">
                        <label for="short_description_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Deskripsi Singkat (Indonesia)</label>
                        <textarea name="short_description_id" id="short_description_id" rows="3" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ $shortDescriptionId }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label for="short_description_en" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Short Description (English)</label>
                        <textarea name="short_description_en" id="short_description_en" rows="3"
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ $shortDescriptionEn }}</textarea>
                    </div>

                    {{-- Deskripsi Lengkap --}}
                    <div class="space-y-2">
                        <label for="full_description_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Konten Detail (Indonesia)</label>
                        <textarea name="full_description_id" id="full_description_id" rows="10"
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ $fullDescriptionId }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label for="full_description_en" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Full Description (English)</label>
                        <textarea name="full_description_en" id="full_description_en" rows="10"
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ $fullDescriptionEn }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kanan: Icon & Status --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Icon Picker --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-6">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Pilih Ikon Layanan</label>
                    
                    {{-- Preview --}}
                    <div class="flex items-center justify-center p-8 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center text-primary border border-slate-100">
                            <span id="iconPreview" class="material-symbols-outlined text-4xl">{{ $service->icon_image ?? 'category' }}</span>
                        </div>
                    </div>

                    {{-- Input & Popular Icons --}}
                    <div class="space-y-4">
                        <input type="text" name="icon_image" id="iconInput" value="{{ old('icon_image', $service->icon_image) }}" readonly
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3 text-xs font-black text-center uppercase tracking-widest outline-none">
                        
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
                                    class="h-10 rounded-lg border border-slate-100 {{ $service->icon_image == $icon ? 'border-primary text-primary bg-white shadow-md' : 'bg-slate-50/50' }} hover:border-primary hover:text-primary transition-all flex items-center justify-center hover:bg-white hover:shadow-md group">
                                    <span class="material-symbols-outlined text-xl group-hover:scale-110 transition-transform">{{ $icon }}</span>
                                </button>
                            @endforeach
                        </div>
                        <p class="text-[9px] text-slate-400 text-center italic">Klik salah satu ikon di atas untuk mengganti</p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status Publikasi</label>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer hidden" {{ $service->status == 'active' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-primary/5 peer-checked:border-primary peer-checked:text-primary transition-all group">
                                <span class="material-symbols-outlined text-xl">public</span>
                                <span class="text-xs font-black uppercase tracking-widest">Aktif / Publik</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="draft" class="peer hidden" {{ $service->status == 'draft' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all group">
                                <span class="material-symbols-outlined text-xl">drafts</span>
                                <span class="text-xs font-black uppercase tracking-widest">Simpan Draft</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-100">
            <button type="submit" 
                class="w-full sm:w-auto bg-slate-900 text-white px-14 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                <span class="material-symbols-outlined text-xl">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function selectIcon(iconName) {
        document.getElementById('iconInput').value = iconName;
        document.getElementById('iconPreview').innerText = iconName;
        
        // Update selection UI highlight
        document.querySelectorAll('button[onclick^="selectIcon"]').forEach(btn => {
            btn.classList.remove('border-primary', 'text-primary', 'bg-white', 'shadow-md');
            btn.classList.add('bg-slate-50/50');
        });
        event.currentTarget.classList.add('border-primary', 'text-primary', 'bg-white', 'shadow-md');
        event.currentTarget.classList.remove('bg-slate-50/50');
    }
</script>
@endsection
