@extends('layouts.admin')

@section('title', 'Manajemen Layanan - Rakira CMS')
@section('page_title', 'Daftar Layanan')
@section('page_subtitle', 'Kelola kategori layanan yang ditampilkan di website.')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('admin.services.create') }}" class="btn-primary">
            <span class="material-symbols-outlined">add</span>
            Tambah Layanan Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-[#F1F5F9] border-b border-outline-variant/50">
                <tr>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Icon</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Judul Layanan</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Status</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface w-32 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/30">
                @forelse($services as $s)
                @php
                    $serviceTitle = __t($s->title);
                    $serviceShortDescription = __t($s->short_description);
                @endphp
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="py-4 px-6">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">{{ $s->icon_image ?: 'settings' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <p class="font-bold text-sm text-on-surface">{{ $serviceTitle }}</p>
                        <p class="text-[11px] text-on-surface-variant line-clamp-1">{{ $serviceShortDescription }}</p>
                    </td>
                    <td class="py-4 px-6">
                        @if($s->status === 'active')
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-green-100 text-green-700 uppercase tracking-tighter">Active</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-gray-100 text-gray-500 uppercase tracking-tighter">Draft</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.services.edit', $s) }}" class="text-primary hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-error hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 text-center text-on-surface-variant">Belum ada layanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
