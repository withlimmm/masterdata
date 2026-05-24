@extends('layouts.admin')

@section('title', 'Pesan Konsultasi - Rakira CMS')
@section('page_title', 'Pesan Konsultasi Masuk')
@section('page_subtitle', 'Lihat dan kelola permintaan konsultasi dari calon klien.')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-semibold flex items-center gap-3">
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats bar --}}
    <div class="grid grid-cols-3 gap-4" data-aos>
        <div class="bg-white border border-outline-variant/50 rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-on-surface">{{ $messages->count() }}</p>
            <p class="text-xs text-on-surface-variant font-bold uppercase mt-1">Total Pesan</p>
        </div>
        <div class="bg-white border border-outline-variant/50 rounded-xl p-5 text-center border-t-4 border-t-primary">
            <p class="text-3xl font-bold text-primary">{{ $messages->where('status', 'unread')->count() }}</p>
            <p class="text-xs text-on-surface-variant font-bold uppercase mt-1">Belum Dibaca</p>
        </div>
        <div class="bg-white border border-outline-variant/50 rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-success">{{ $messages->where('status', 'read')->count() }}</p>
            <p class="text-xs text-on-surface-variant font-bold uppercase mt-1">Sudah Dibaca</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm" data-aos>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#F1F5F9] border-b border-outline-variant/50">
                    <tr>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface w-10"></th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Pengirim</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Layanan</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">WhatsApp</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Tanggal</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface w-28 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse($messages as $msg)
                    <tr class="hover:bg-surface-container-low transition-colors group {{ $msg->status === 'unread' ? 'bg-primary/[0.03]' : '' }}">
                        <td class="py-4 px-6">
                            @if($msg->status === 'unread')
                                <span class="w-2.5 h-2.5 bg-primary rounded-full block"></span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-sm text-on-surface {{ $msg->status === 'unread' ? '' : 'font-normal' }}">{{ $msg->sender_name }}</p>
                            <p class="text-[11px] text-on-surface-variant">{{ $msg->sender_email }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if($msg->service)
                                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary uppercase">{{ $msg->service }}</span>
                            @else
                                <span class="text-outline-variant text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">
                            @if($msg->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $msg->phone) }}" target="_blank" class="text-success hover:underline font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">call</span>
                                    {{ $msg->phone }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">{{ $msg->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="text-primary hover:scale-110 transition-transform" title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>
                                <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Yakin hapus pesan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-error hover:scale-110 transition-transform" title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl text-outline-variant mb-2 block">inbox</span>
                            <p class="font-bold">Belum ada pesan masuk.</p>
                            <p class="text-sm">Pesan konsultasi dari beranda akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
