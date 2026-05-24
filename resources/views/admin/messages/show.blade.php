@extends('layouts.admin')

@section('title', 'Detail Pesan - Rakira CMS')
@section('page_title', 'Detail Pesan Konsultasi')
@section('page_subtitle', 'Dari: {{ $message->sender_name }}')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Back --}}
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-on-surface-variant hover:text-primary transition-colors">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar Pesan
    </a>

    {{-- Card --}}
    <div class="bg-white border border-outline-variant/50 rounded-xl shadow-sm overflow-hidden" data-aos>
        {{-- Header --}}
        <div class="bg-[#F1F5F9] px-8 py-6 border-b border-outline-variant/50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl shadow-lg flex-shrink-0">
                    {{ strtoupper(substr($message->sender_name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-on-surface">{{ $message->sender_name }}</h3>
                    <p class="text-sm text-on-surface-variant">{{ $message->sender_email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($message->status === 'unread')
                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary uppercase">Belum Dibaca</span>
                @else
                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-green-100 text-green-700 uppercase">Sudah Dibaca</span>
                @endif
            </div>
        </div>

        {{-- Body --}}
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="surface-card p-4 rounded-xl text-center">
                    <p class="text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">Layanan</p>
                    <p class="font-bold text-primary text-lg">{{ $message->service ?: '-' }}</p>
                </div>
                <div class="surface-card p-4 rounded-xl text-center">
                    <p class="text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">WhatsApp</p>
                    @if($message->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="font-bold text-success text-lg hover:underline">
                        {{ $message->phone }}
                    </a>
                    @else
                    <p class="text-on-surface-variant">-</p>
                    @endif
                </div>
                <div class="surface-card p-4 rounded-xl text-center">
                    <p class="text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">Tanggal Masuk</p>
                    <p class="font-bold text-on-surface">{{ $message->created_at->format('d M Y') }}</p>
                    <p class="text-xs text-on-surface-variant">{{ $message->created_at->format('H:i') }} WIB</p>
                </div>
            </div>

            @if($message->subject)
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2">Subjek</p>
                <p class="text-on-surface font-semibold">{{ $message->subject }}</p>
            </div>
            @endif

            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-2">Isi Pesan</p>
                <div class="bg-background rounded-xl p-6 text-on-surface leading-relaxed border border-outline-variant/30">
                    {{ $message->message_body }}
                </div>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="bg-[#F1F5F9] px-8 py-4 border-t border-outline-variant/50 flex items-center justify-between">
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Yakin hapus pesan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-sm font-bold text-error hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">delete</span> Hapus Pesan
                </button>
            </form>
            @if($message->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}?text={{ urlencode('Halo ' . $message->sender_name . ', terima kasih telah menghubungi Rakira Digital. Kami ingin membahas kebutuhan ' . ($message->service ?: 'proyek') . ' Anda.') }}"
                target="_blank"
                class="bg-[#25D366] text-white px-6 py-2.5 rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-[#1fb855] transition-all">
                <span class="material-symbols-outlined text-sm">chat</span>
                Balas via WhatsApp
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
