@extends('layouts.admin')

@section('title', 'Edit Anggota Tim - Rakira CMS')
@section('page_title', 'Perbarui Data Tim')
@section('page_subtitle', 'Sesuaikan informasi profil anggota tim Rakira Digital.')

@section('content')
<div class="max-w-4xl mx-auto pb-20 animate-in fade-in duration-700">
    <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data" class="p-10 md:p-16 space-y-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                {{-- Kiri: Upload Foto --}}
                <div class="md:col-span-4 space-y-4">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Foto Profil</label>
                    <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*" onchange="previewPhoto(event)">
                    <div onclick="document.getElementById('photoInput').click()" 
                         class="aspect-square w-full rounded-[2.5rem] bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center gap-3 cursor-pointer hover:bg-slate-100 hover:border-primary transition-all group overflow-hidden relative">
                        
                        {{-- Tampilkan foto lama jika ada, atau preview baru --}}
                        <img id="photoPreview" src="{{ $team->photo ? asset('storage/' . $team->photo) : '' }}" 
                             class="absolute inset-0 w-full h-full object-cover {{ $team->photo ? '' : 'hidden' }}">
                        
                        <div id="uploadPlaceholder" class="flex flex-col items-center gap-2 {{ $team->photo ? 'hidden' : '' }}">
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-primary transition-all text-4xl">add_a_photo</span>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-primary transition-colors text-center">Klik Ganti Foto</p>
                        </div>

                        {{-- Overlay saat hover --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                            <span class="material-symbols-outlined text-white text-3xl">cached</span>
                        </div>
                    </div>
                    @error('photo') <p class="text-error text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kanan: Detail Info --}}
                <div class="md:col-span-8 space-y-6">
                    <div class="space-y-3">
                        <label for="name" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" required value="{{ old('name', $team->name) }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                    </div>

                    <div class="space-y-3">
                        <label for="position" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Jabatan / Posisi</label>
                        <input type="text" name="position" id="position" required value="{{ old('position', $team->position) }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                    </div>

                    <div class="space-y-3">
                        <label for="description" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="4" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none italic resize-none">{{ old('description', $team->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-10 flex flex-col sm:flex-row items-center justify-end gap-4 border-t border-slate-100">
                <a href="{{ route('admin.teams.index') }}" 
                    class="w-full sm:w-auto px-10 py-4 rounded-2xl border border-slate-200 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:text-slate-900 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">close</span>
                    Batalkan
                </a>
                <button type="submit" 
                    class="w-full sm:w-auto bg-slate-900 text-white px-14 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-xl">update</span>
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewPhoto(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');
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
</script>
@endsection
