@extends('layouts.admin')

@section('title', 'Edit Artikel - Rakira CMS')
@section('page_title', 'Perbarui Artikel')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    {{-- Header Actions --}}
    <div class="mb-8 flex items-center justify-between animate-in slide-in-from-left duration-500">
        <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-900 transition-colors group">
            <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="text-xs font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Kiri: Konten Utama --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 md:p-10 shadow-sm space-y-6">
                    {{-- Judul --}}
                    <div class="space-y-2">
                        <label for="title" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Judul Artikel</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $article->title) }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-lg focus:bg-white focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all font-bold outline-none">
                    </div>

                    {{-- Konten --}}
                    <div class="space-y-2">
                        <label for="content" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Isi Artikel</label>
                        <textarea name="content" id="content" rows="20" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-[2rem] px-6 py-6 text-base leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none resize-none">{{ old('content', $article->content) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kanan: Metadata & Media --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Media --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-6">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Gambar Sampul</label>
                    
                    {{-- Preview Container --}}
                    <div class="relative group cursor-pointer" onclick="document.getElementById('cover_image').click()">
                        <div id="imagePreview" class="w-full aspect-[4/3] rounded-2xl bg-slate-50 border-2 border-slate-100 flex flex-col items-center justify-center text-slate-400 overflow-hidden transition-all hover:border-slate-800/50 group-hover:bg-slate-100/50">
                            @if($article->cover_image)
                                <img src="{{ asset('storage/' . $article->cover_image) }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-4xl mb-2">add_photo_alternate</span>
                                <span class="text-[10px] font-black uppercase tracking-widest">Ganti Foto</span>
                            @endif
                        </div>
                        <input type="file" name="cover_image" id="cover_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <p class="text-[9px] text-slate-400 text-center italic">Klik gambar untuk mengganti</p>
                </div>

                {{-- Pengaturan --}}
                <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm space-y-6">
                    {{-- Kategori --}}
                    <div class="space-y-3">
                        <label for="category_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $article->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status</label>
                        <div class="grid grid-cols-1 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="published" class="peer hidden" {{ $article->status == 'published' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 px-5 py-3 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all">
                                    <span class="material-symbols-outlined text-xl">rocket_launch</span>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Published</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="draft" class="peer hidden" {{ $article->status == 'draft' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3 px-5 py-3 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all">
                                    <span class="material-symbols-outlined text-xl">drafts</span>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Draft</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Action --}}
                <button type="submit" 
                    class="w-full bg-slate-900 text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:bg-slate-900/90 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                preview.classList.remove('border-dashed');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
