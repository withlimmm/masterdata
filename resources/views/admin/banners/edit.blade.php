@extends('layouts.admin')

@section('title', 'Edit Banner - Rakira CMS')
@section('page_title', 'Edit Banner')
@section('page_subtitle', 'Ubah informasi banner promosi Anda.')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm mb-8">
        <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors bg-white px-5 py-2.5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 shadow-sm rounded-[2rem] p-8 md:p-10 space-y-8">
        @csrf
        @method('PUT')

        {{-- Banner Info --}}
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-indigo-500">info</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Informasi Banner</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Judul Banner (Opsional)</label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none"
                        placeholder="Misal: Promo Akhir Tahun">
                    @error('title') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Gambar Banner</label>
                    @if($banner->image_path)
                    <div class="mb-3 w-64 rounded-xl overflow-hidden border border-slate-200">
                        <img src="{{ asset('storage/' . $banner->image_path) }}" alt="Preview" class="w-full h-auto object-cover">
                    </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none">
                    <p class="text-xs text-slate-400 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                    @error('image') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">URL Tautan (Opsional)</label>
                    <input type="url" name="link_url" value="{{ old('link_url', $banner->link_url) }}" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none"
                        placeholder="https://contoh.com/promo">
                    @error('link_url') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Urutan Tampil *</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" required min="0"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none">
                    <p class="text-xs text-slate-400 mt-2">1 akan tampil pertama.</p>
                    @error('sort_order') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- Status --}}
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-500">toggle_on</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Status Terbit</h3>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500"></div>
                <span class="ml-3 text-sm font-bold text-slate-600">Aktifkan Banner</span>
            </label>
        </div>

        <div class="pt-6 flex gap-4">
            <button type="submit" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.banners.index') }}" class="bg-white border border-slate-200 text-slate-600 px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center gap-2 hover:bg-slate-50 transition-all active:scale-95">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
