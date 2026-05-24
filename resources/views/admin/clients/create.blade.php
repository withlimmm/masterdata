@extends('layouts.admin')

@section('title', 'Tambah Klien - Rakira CMS')
@section('page_title', 'Tambah Klien Baru')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- Header Actions --}}
    <div class="mb-8 flex items-center justify-between animate-in slide-in-from-left duration-500">
        <a href="{{ route('admin.clients.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-900 transition-colors group">
            <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="text-xs font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Kiri: Detail Info --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 md:p-10 shadow-sm space-y-6">
                    {{-- Nama Klien --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="client_name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Klien *</label>
                            <input type="text" name="client_name" id="client_name" required value="{{ old('client_name') }}"
                                placeholder="Contoh: Andi Pratama"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                        </div>
                        <div class="space-y-2">
                            <label for="company_name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Perusahaan</label>
                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}"
                                placeholder="Contoh: PT. Global Tech"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                        </div>
                    </div>

                    {{-- Kontak --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="email" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="client@email.com"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                        </div>
                        <div class="space-y-2">
                            <label for="phone" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">WhatsApp/Telepon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                placeholder="08xxxxxx"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                        </div>
                    </div>

                    {{-- Testimonial --}}
                    <div class="space-y-2">
                        <label for="testimonial" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Testimoni Klien</label>
                        <textarea name="testimonial" id="testimonial" rows="4"
                            placeholder="Tuliskan testimoni dari klien ini jika ada..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ old('testimonial') }}</textarea>
                    </div>

                    <div class="space-y-2" x-data="{ rating: {{ old('rating', 5) }}, hover: 0 }">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Rating Bintang</label>
                        <div class="flex gap-2">
                            <input type="hidden" name="rating" :value="rating">
                            @for($i=1; $i<=5; $i++)
                                <button type="button" 
                                    @click="rating = {{ $i }}" 
                                    @mouseenter="hover = {{ $i }}" 
                                    @mouseleave="hover = 0"
                                    class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-200 outline-none focus:outline-none"
                                    :class="(hover || rating) >= {{ $i }} ? 'bg-amber-50 border border-amber-400 text-amber-400 scale-110 shadow-sm' : 'bg-slate-50 border border-slate-200 text-slate-300'">
                                    <span class="material-symbols-outlined fill-1">star</span>
                                </button>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Logo & Status --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Logo Picker --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-6">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Logo Perusahaan</label>
                    
                    {{-- Preview --}}
                    <div class="relative group cursor-pointer" onclick="document.getElementById('company_logo').click()">
                        <div id="logoPreview" class="w-full aspect-square rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400 overflow-hidden transition-all hover:border-primary/50 group-hover:bg-slate-100/50">
                            <span class="material-symbols-outlined text-4xl mb-2">add_photo_alternate</span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-center px-4">Pilih Logo Perusahaan</span>
                        </div>
                        <input type="file" name="company_logo" id="company_logo" class="hidden" accept="image/*" onchange="previewLogo(this)">
                    </div>
                    <p class="text-[9px] text-slate-400 text-center italic">Format PNG/JPG (Maks. 2MB)</p>
                </div>

                {{-- Status --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status Klien</label>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer hidden" checked>
                            <div class="flex items-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-primary/5 peer-checked:border-primary peer-checked:text-primary transition-all">
                                <span class="material-symbols-outlined text-xl">check_circle</span>
                                <span class="text-xs font-black uppercase tracking-widest">Aktif</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="inactive" class="peer hidden">
                            <div class="flex items-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all">
                                <span class="material-symbols-outlined text-xl">block</span>
                                <span class="text-xs font-black uppercase tracking-widest">Non-Aktif</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Action --}}
                <button type="submit" 
                    class="w-full bg-slate-900 text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined">person_add</span>
                    Simpan Klien
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewLogo(input) {
        const preview = document.getElementById('logoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain p-4">`;
                preview.classList.remove('border-dashed');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
