@extends('layouts.admin')

@section('title', 'Edit Proyek - Rakira CMS')
@section('page_title', 'Perbarui Proyek')
@section('page_subtitle', 'Sesuaikan informasi dan media untuk proyek portofolio Anda.')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <form action="{{ route('admin.portfolios.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Kiri: Detail Info --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 md:p-10 shadow-sm space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Judul Proyek --}}
                        <div class="space-y-2">
                            <label for="project_name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Proyek</label>
                            <input type="text" name="project_name" id="project_name" required value="{{ old('project_name', $portfolio->project_name) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                            @error('project_name') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="space-y-2">
                            <label for="category_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Kategori</label>
                            <select name="category_id" id="category_id" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none appearance-none cursor-pointer">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $portfolio->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Client Name --}}
                        <div class="space-y-2">
                            <label for="client_name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Klien</label>
                            <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $portfolio->client_name) }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                        </div>
                        
                        {{-- Status --}}
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status</label>
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none appearance-none cursor-pointer">
                                <option value="active" {{ $portfolio->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="done" {{ $portfolio->status == 'done' ? 'selected' : '' }}>Done</option>
                                <option value="draft" {{ $portfolio->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="space-y-2">
                        <label for="description" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Deskripsi Proyek</label>
                        <textarea name="description" id="description" rows="6"
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ old('description', $portfolio->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kanan: Media --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Banner Proyek</label>
                    <input type="file" name="thumbnail_image" id="imageInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <div onclick="document.getElementById('imageInput').click()" 
                         class="aspect-video w-full rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center gap-3 cursor-pointer hover:bg-slate-100 hover:border-primary transition-all group overflow-hidden relative">
                        
                        {{-- Foto Lama atau Pratinjau --}}
                        <img id="imagePreview" src="{{ $portfolio->thumbnail_image ? asset('storage/' . $portfolio->thumbnail_image) : '' }}" 
                             class="absolute inset-0 w-full h-full object-cover {{ $portfolio->thumbnail_image ? '' : 'hidden' }}">
                        
                        <div id="uploadPlaceholder" class="flex flex-col items-center gap-2 {{ $portfolio->thumbnail_image ? 'hidden' : '' }}">
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-primary transition-all text-4xl">add_photo_alternate</span>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-primary transition-colors text-center">Ganti Foto</p>
                        </div>

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                            <span class="material-symbols-outlined text-white text-3xl">cached</span>
                        </div>
                    </div>
                    @error('thumbnail_image') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                {{-- Upload Galeri --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Galeri Proyek (Multiple)</label>
                    <input type="file" name="gallery_images[]" id="galleryInput" class="hidden" accept="image/*" multiple onchange="previewGallery(event)">
                    <div onclick="document.getElementById('galleryInput').click()" 
                         class="min-h-[150px] w-full rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center gap-3 cursor-pointer hover:bg-slate-100 hover:border-primary transition-all group overflow-hidden p-6 relative">
                        
                        <div id="galleryPreviewContainer" class="grid grid-cols-3 gap-2 w-full {{ $portfolio->gallery_images ? '' : 'hidden' }}">
                            @if($portfolio->gallery_images)
                                @foreach($portfolio->gallery_images as $img)
                                    <div class="aspect-square rounded-lg overflow-hidden border border-slate-200">
                                        <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <div id="galleryPlaceholder" class="flex flex-col items-center gap-2 {{ $portfolio->gallery_images ? 'hidden' : '' }}">
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-primary transition-all text-4xl">collections</span>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-primary transition-colors text-center">Ganti Galeri Foto</p>
                        </div>

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-2xl">
                            <span class="material-symbols-outlined text-white text-3xl">cached</span>
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
                <span class="material-symbols-outlined text-xl">update</span>
                Simpan Perubahan
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
