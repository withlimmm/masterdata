@extends('layouts.admin')
@section('title', 'Data Klien Tenant - Rakira CMS')
@section('page_title', 'Data Perusahaan / Klien')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('admin.companies.create') }}" class="inline-flex items-center gap-2 text-white text-sm font-semibold py-2.5 px-5 rounded-lg shadow-sm hover:shadow hover:opacity-90 transition-all duration-200" style="background-color: #0B1120;">
            <span class="material-symbols-outlined text-[20px]">add</span> Daftarkan Klien
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
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Klien</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Domain</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Paket</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface">Status</th>
                    <th class="py-4 px-6 text-[11px] font-black uppercase tracking-widest text-on-surface w-32 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/30">
                @forelse($companies as $c)
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="py-4 px-6">
                        <p class="font-bold text-sm">{{ $c->company_name }}</p>
                        <p class="text-xs text-gray-500">{{ $c->company_code }}</p>
                    </td>
                    <td class="py-4 px-6 text-sm"><a href="http://{{ $c->company_domain }}" target="_blank" class="text-primary hover:underline">{{ $c->company_domain }}</a></td>
                    <td class="py-4 px-6 text-sm">{{ $c->package->package_name ?? '-' }}</td>
                    <td class="py-4 px-6">
                        @if($c->subscription_status === 'active')
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-green-100 text-green-700 uppercase">Active</span>
                        @elseif($c->subscription_status === 'suspended')
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-orange-100 text-orange-700 uppercase">Suspended</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-red-100 text-red-700 uppercase">Expired</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.companies.edit', $c) }}" class="text-primary hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-12 text-center text-on-surface-variant">Belum ada klien.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection