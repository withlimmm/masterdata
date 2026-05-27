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
            
            {{-- Social Media & Maps --}}
            <div class="space-y-6">
                <h3 class="text-sm font-black uppercase tracking-[0.2em] text-primary border-b border-outline-variant/30 pb-2">Sosial Media & Maps</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label for="instagram_url" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Instagram URL</label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="facebook_url" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Facebook URL</label>
                        <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="linkedin_url" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="google_maps_iframe" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Google Maps (Iframe Embed HTML)</label>
                    <textarea name="google_maps_iframe" id="google_maps_iframe" rows="3" placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." ...></iframe>'
                        class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-mono">{{ old('google_maps_iframe', $settings->google_maps_iframe) }}</textarea>
                </div>
            </div>

            {{-- Analytics & Tracking --}}
            <div class="space-y-6">
                <h3 class="text-sm font-black uppercase tracking-[0.2em] text-primary border-b border-outline-variant/30 pb-2">Analytics & Marketing Tracking</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="google_analytics_id" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Google Analytics 4 ID (GA4)</label>
                        <input type="text" name="google_analytics_id" id="google_analytics_id" placeholder="G-XXXXXXXXXX" value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-mono">
                    </div>
                    <div class="space-y-2">
                        <label for="facebook_pixel_id" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Facebook Pixel ID</label>
                        <input type="text" name="facebook_pixel_id" id="facebook_pixel_id" placeholder="123456789012345" value="{{ old('facebook_pixel_id', $settings->facebook_pixel_id) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant/50 rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all font-mono">
                    </div>
                </div>
                <p class="text-xs text-on-surface-variant/70 italic mt-2">ID tracking ini akan otomatis terpasang (inject) ke semua halaman publik website jika diisi.</p>
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
