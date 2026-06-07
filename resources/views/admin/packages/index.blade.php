@extends('layouts.admin')
@section('title', 'Master Paket - Rakira CMS')
@section('page_title', 'Master Paket Langganan')
@section('page_subtitle', 'Kelola paket langganan SaaS.')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('admin.packages.create') }}" class="btn-primary">
            <span class="material-symbols-outlined">add</span> Tambah Paket Baru
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
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Kode Paket</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Nama Paket</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Max Produk</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Harga</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface w-32 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/30">
                @forelse($packages as $p)
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="py-4 px-6 font-bold text-sm">{{ $p->package_code }}</td>
                    <td class="py-4 px-6 text-sm">{{ $p->package_name }}</td>
                    <td class="py-4 px-6 text-sm">{{ number_format($p->package_max_products) }}</td>
                    <td class="py-4 px-6 text-sm">Rp {{ number_format($p->package_price, 0, ',', '.') }}</td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.packages.edit', $p) }}" class="text-primary hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('admin.packages.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-error hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-12 text-center text-on-surface-variant">Belum ada paket.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection