@extends('layouts.admin')

@section('title', 'Manajemen Tim - Rakira CMS')
@section('page_title', 'Data Anggota Tim')
@section('page_subtitle', 'Kelola profesional di balik layar Rakira Digital.')

@section('content')
<div class="max-w-6xl mx-auto pb-20 animate-in fade-in duration-700">
    {{-- Header & Action --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h3 class="text-xl font-black text-slate-900 tracking-tight">Daftar Anggota Tim</h3>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Total {{ $teams->count() }} Personel</p>
        </div>
        <a href="{{ route('admin.teams.create') }}" class="inline-flex items-center justify-center gap-2 bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Anggota
        </a>
    </div>

    {{-- Teams Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($teams as $team)
            <div class="group bg-white rounded-[2.5rem] border border-slate-200 p-8 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-300">
                <div class="flex flex-col items-center text-center">
                    {{-- Photo --}}
                    <div class="w-24 h-24 rounded-full overflow-hidden mb-5 border-4 border-slate-50 group-hover:border-primary/10 transition-colors">
                        <img src="{{ $team->photo ? asset('storage/' . $team->photo) : asset('images/default-avatar.png') }}" 
                             alt="{{ $team->name }}" 
                             class="w-full h-full object-cover">
                    </div>

                    {{-- Info --}}
                    <h4 class="text-lg font-black text-slate-900 group-hover:text-primary transition-colors">{{ $team->name }}</h4>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary bg-primary/5 px-4 py-1.5 rounded-full mt-2 mb-4">{{ $team->position }}</span>
                    
                    <p class="text-sm text-slate-500 line-clamp-2 italic mb-8">
                        {{ $team->description ?: 'Tidak ada deskripsi singkat.' }}
                    </p>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 w-full pt-6 border-t border-slate-50">
                        <a href="{{ route('admin.teams.edit', $team->id) }}" class="flex-1 bg-slate-50 text-slate-600 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">edit</span>
                            Edit
                        </a>
                        <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus anggota tim ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full bg-slate-50 text-slate-400 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-error/10 hover:text-error transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-base">delete</span>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-[3rem] p-20 text-center">
                <span class="material-symbols-outlined text-slate-300 text-6xl mb-4">group_off</span>
                <p class="text-slate-500 font-bold uppercase tracking-widest text-sm">Belum ada anggota tim.</p>
                <a href="{{ route('admin.teams.create') }}" class="text-slate-900 font-black text-xs uppercase tracking-widest mt-4 inline-block hover:underline">Klik di sini untuk menambah</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
