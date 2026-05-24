@extends('layouts.admin')

@section('title', 'Kelola Klien - Rakira CMS')
@section('page_title', 'Kelola Klien & Testimonial')
@section('page_subtitle', 'Tambah, edit, dan kelola testimoni klien yang tampil di beranda.')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-semibold flex items-center gap-3" data-aos>
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    {{-- Toolbar --}}
    <div class="bg-white border border-outline-variant/50 rounded-xl p-4 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between" data-aos>
        <p class="text-on-surface-variant text-sm">Total: <span class="font-bold text-on-surface">{{ $clients->count() }}</span> klien terdaftar</p>
        <a href="{{ route('admin.clients.create') }}" class="bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-primary-container transition-all">
            <span class="material-symbols-outlined text-sm">person_add</span>
            Tambah Klien
        </a>
    </div>

    {{-- Data Table --}}
    <div class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm" data-aos>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#F1F5F9] border-b border-outline-variant/50">
                    <tr>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Nama Klien</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Perusahaan</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Testimonial</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface w-24">Status</th>
                        <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface w-28 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse($clients as $client)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($client->client_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-on-surface">{{ $client->client_name }}</p>
                                    @if($client->email)
                                    <p class="text-[11px] text-on-surface-variant">{{ $client->email }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant">{{ $client->company_name ?: '-' }}</td>
                        <td class="py-4 px-6 text-sm text-on-surface-variant max-w-xs">
                            @if($client->testimonial)
                                <p class="truncate italic">"{{ Str::limit($client->testimonial, 60) }}"</p>
                            @else
                                <span class="text-outline-variant text-xs italic">Belum diisi</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($client->status === 'active')
                                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-green-100 text-green-700 uppercase">Active</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-gray-100 text-gray-500 uppercase">Inactive</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.clients.edit', $client) }}" class="text-primary hover:scale-110 transition-transform" title="Edit">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Yakin hapus klien ini?')">
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
                        <td colspan="5" class="py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl text-outline-variant mb-2 block">group_off</span>
                            <p class="font-bold">Belum ada data klien.</p>
                            <p class="text-sm">Klik "Tambah Klien" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
