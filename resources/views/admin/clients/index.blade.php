@extends('layouts.admin')

@section('title', 'Kelola Klien - Rakira CMS')
@section('page_title', 'Daftar Klien & Testimonial')
@section('page_subtitle', 'Kelola data klien, perusahaan, dan testimonial yang akan ditampilkan di website.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    {{-- Header & Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-indigo-500 text-2xl">group</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Klien</p>
                <p class="text-2xl font-black text-slate-800">{{ $clients->count() }}</p>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-emerald-500 text-2xl">rate_review</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Dengan Testimonial</p>
                <p class="text-2xl font-black text-slate-800">{{ $clients->where('testimonial', '!=', null)->count() }}</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-slate-500 text-2xl">visibility</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Status Aktif</p>
                <p class="text-2xl font-black text-slate-800">{{ $clients->where('status', 'active')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="relative w-full md:w-80 group text-slate-400 focus-within:text-slate-800">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input type="text" placeholder="Cari klien atau perusahaan..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none text-slate-800 shadow-sm">
        </div>
        
        <a href="{{ route('admin.clients.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">add</span>
            Tambah Klien Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    {{-- Clients Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($clients as $client)
        <div class="group bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col p-6">
            {{-- Header Card --}}
            <div class="flex items-start justify-between mb-5">
                <div class="flex items-center gap-4">
                    {{-- Avatar Initials --}}
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-black text-xl shadow-sm">
                        {{ strtoupper(substr($client->client_name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-800 leading-tight">
                            {{ $client->client_name }}
                        </h3>
                        <p class="text-xs font-bold text-slate-400 mt-0.5">{{ $client->company_name ?: 'Personal / Individu' }}</p>
                    </div>
                </div>
            </div>

            {{-- Body Card (Testimonial) --}}
            <div class="flex-1 bg-slate-50 rounded-[1.5rem] p-5 border border-slate-100 relative mt-2 mb-6">
                <span class="material-symbols-outlined text-4xl text-slate-200 absolute top-3 right-3 select-none">format_quote</span>
                @if($client->testimonial)
                    <p class="text-sm text-slate-600 leading-relaxed italic relative z-10 line-clamp-3">
                        "{{ $client->testimonial }}"
                    </p>
                @else
                    <p class="text-sm text-slate-400 leading-relaxed italic relative z-10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        Belum ada testimonial
                    </p>
                @endif
            </div>

            {{-- Footer Area --}}
            <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                {{-- Status Badge --}}
                @if($client->status === 'active')
                    <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-black uppercase tracking-widest flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active
                    </span>
                @else
                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 text-[9px] font-black uppercase tracking-widest flex items-center gap-1">
                        Inactive
                    </span>
                @endif

                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.clients.edit', $client) }}" 
                        class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </a>
                    <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus klien ini beserta testimonialnya?')">
                        @csrf @method('DELETE')
                        <button type="submit" 
                            class="w-8 h-8 rounded-full bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 bg-white border border-slate-200 border-dashed rounded-[2rem] text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-slate-300">group_off</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Klien</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-md">Tambahkan profil klien beserta testimonial mereka untuk meningkatkan kepercayaan pengunjung website.</p>
            <a href="{{ route('admin.clients.create') }}" class="text-[11px] font-black uppercase tracking-widest text-slate-800 bg-slate-100 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all">
                Tambah Klien Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
