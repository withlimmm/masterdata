@extends('layouts.admin')

@section('title', 'Pengaturan Perusahaan - Rakira CMS')
@section('page_title', 'Pengaturan Profil')
@section('page_subtitle', 'Kelola informasi publik perusahaan Anda.')

@section('content')
<div class="max-w-4xl mx-auto">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-semibold mb-6">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white border border-outline-variant/30 rounded-2xl p-8 shadow-sm space-y-8">
            {{-- General Info --}}
            <div class="space-y-6">
                <h3 class="text-sm font-black uppercase tracking-[0.2em] text-primary border-b border-outline-variant/30 pb-2">Informasi Umum</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="company_name" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Nama Perusahaan</label>
                        <input type="text" name="company_name" id="company_name" required value="{{ old('company_name', $settings->company_name) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="motto" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Motto Perusahaan</label>
                        <input type="text" name="motto" id="motto" value="{{ old('motto', $settings->motto) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="space-y-6">
                <h3 class="text-sm font-black uppercase tracking-[0.2em] text-primary border-b border-outline-variant/30 pb-2">Kontak & Lokasi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Email Bisnis</label>
                        <input type="email" name="email" id="email" required value="{{ old('email', $settings->email) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="phone" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Nomor WhatsApp/Telp</label>
                        <input type="text" name="phone" id="phone" required value="{{ old('phone', $settings->phone) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="address" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Alamat Kantor</label>
                    <textarea name="address" id="address" rows="3" required
                        class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all resize-none">{{ old('address', $settings->address) }}</textarea>
                </div>
            </div>

            {{-- Branding --}}
            <div class="space-y-6">
                <h3 class="text-sm font-black uppercase tracking-[0.2em] text-primary border-b border-outline-variant/30 pb-2">Branding (About Us)</h3>
                
                <div class="space-y-2">
                    <label for="about_us" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Tentang Kami</label>
                    <textarea name="about_us" id="about_us" rows="4" required
                        class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">{{ old('about_us', $settings->about_us) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="vision" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Visi</label>
                        <textarea name="vision" id="vision" rows="3"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">{{ old('vision', $settings->vision) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label for="mission" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Misi</label>
                        <textarea name="mission" id="mission" rows="3"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">{{ old('mission', $settings->mission) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-primary text-white px-12 py-4 rounded-xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
