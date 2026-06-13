@extends('layouts.admin')

@section('title', 'Tambah Kategori - Rakira CMS')
@section('page_title', 'Buat Kategori Baru')
@section('page_subtitle', 'Tambahkan kategori baru untuk mengelompokkan proyek portofolio Anda.')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6 animate-in fade-in duration-700">
        @csrf
        
        <div class="bg-white border border-slate-200 rounded-[2rem] p-10 shadow-sm space-y-8">
            {{-- Nama Kategori --}}
            <div class="space-y-2">
                <label for="name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Kategori</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                    placeholder="Contoh: Web Application, Mobile App, Branding"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none">
                @error('name') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="space-y-4">
                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status Kategori</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="active" class="peer hidden" checked>
                        <div class="flex items-center justify-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all font-bold text-xs uppercase tracking-widest">
                            <span class="material-symbols-outlined text-xl">check_circle</span>
                            Aktif
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="inactive" class="peer hidden" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                        <div class="flex items-center justify-center gap-3 px-6 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all font-bold text-xs uppercase tracking-widest">
                            <span class="material-symbols-outlined text-xl">cancel</span>
                            Non-Aktif
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between gap-4 pt-4">
            <a href="{{ route('admin.categories.index') }}" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-3">
                <span class="material-symbols-outlined text-xl">save</span>
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
