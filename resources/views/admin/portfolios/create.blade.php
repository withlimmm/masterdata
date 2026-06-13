@extends('layouts.admin')

@section('title', 'Tambah Proyek - Rakira CMS')
@section('page_title', 'Tambah Proyek Baru')
@section('page_subtitle', 'Masukkan detail proyek portofolio baru Anda.')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Kiri: Detail Info --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 md:p-10 shadow-sm space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Judul Proyek --}}
                        <div class="space-y-2">
                            <label for="project_name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Proyek</label>
                            <input type="text" name="project_name" id="project_name" required value="{{ old('project_name') }}"
                                placeholder="Contoh: Website E-Commerce Nusantara"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none">
                            @error('project_name') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="space-y-2">
                            <label for="category_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Kategori</label>
                            <select name="category_id" id="category_id" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none appearance-none cursor-pointer">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Client Name --}}
                        <div class="space-y-2">
                            <label for="client_name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Klien</label>
                            <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}"
                                placeholder="Contoh: PT. Global Retail"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none">
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="space-y-2">
                        <label for="description" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Deskripsi Proyek</label>
                        <textarea name="description" id="description" rows="6"
                            placeholder="Jelaskan sedikit tentang tantangan dan solusi dari proyek ini..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all outline-none resize-none">{{ old('description') }}</textarea>
                        @error('description') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Kanan: Media & Status --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Upload Foto --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Banner Proyek</label>
                    <input type="file" name="thumbnail_image" id="imageInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <div onclick="document.getElementById('imageInput').click()" 
                         class="aspect-video w-full rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center gap-3 cursor-pointer hover:bg-slate-100 hover:border-slate-800 transition-all group overflow-hidden relative">
                        
                        <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover hidden">
                        
                        <div id="uploadPlaceholder" class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-slate-800 transition-all text-4xl">add_photo_alternate</span>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-slate-800 transition-colors text-center">Klik untuk Unggah Foto</p>
                        </div>
                    </div>
                    @error('thumbnail_image') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status Publikasi</label>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer hidden" checked>
                            <div class="flex items-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all group">
                                <span class="material-symbols-outlined text-xl">public</span>
                                <span class="text-xs font-black uppercase tracking-widest">Aktif / Publik</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="draft" class="peer hidden" {{ old('status') == 'draft' ? 'checked' : '' }}>
                            <div class="flex items-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all group">
                                <span class="material-symbols-outlined text-xl">drafts</span>
                                <span class="text-xs font-black uppercase tracking-widest">Simpan Draft</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

                {{-- Upload Galeri --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Galeri Proyek (Multiple)</label>
                    <input type="file" name="gallery_images[]" id="galleryInput" class="hidden" accept="image/*" multiple onchange="previewGallery(event)">
                    <div onclick="document.getElementById('galleryInput').click()" 
                         class="min-h-[150px] w-full rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center gap-3 cursor-pointer hover:bg-slate-100 hover:border-slate-800 transition-all group overflow-hidden p-6">
                        
                        <div id="galleryPreviewContainer" class="grid grid-cols-3 gap-2 w-full hidden">
                            {{-- Preview images will go here --}}
                        </div>
                        
                        <div id="galleryPlaceholder" class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-slate-800 transition-all text-4xl">collections</span>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-slate-800 transition-colors text-center">Pilih Beberapa Foto</p>
                        </div>
                    </div>
                    @error('gallery_images') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.portfolios.index') }}" 
                class="w-full sm:w-auto px-10 py-4 rounded-2xl border border-slate-200 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:text-slate-900 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">close</span>
                Batalkan
            </a>
            <button type="submit" 
                class="w-full sm:w-auto bg-slate-900 text-white px-14 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                <span class="material-symbols-outlined text-xl">save</span>
                Simpan Proyek
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewGallery(event) {
        const input = event.target;
        const container = document.getElementById('galleryPreviewContainer');
        const placeholder = document.getElementById('galleryPlaceholder');
        
        container.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            container.classList.remove('hidden');
            placeholder.classList.add('hidden');
            
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'aspect-square rounded-lg overflow-hidden border border-slate-200';
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection
