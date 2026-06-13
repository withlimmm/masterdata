@extends('layouts.admin')

@section('title', 'Kelola Tim - Rakira CMS')
@section('page_title', 'Kelola Akun Staf & Tim')
@section('page_subtitle', 'Kelola hak akses dan akun untuk anggota tim Anda.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    
    {{-- Header & Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-indigo-500 text-2xl">group</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Staf</p>
                <p class="text-2xl font-black text-slate-800">{{ $users->count() }}</p>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-amber-500 text-2xl">admin_panel_settings</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Super Admin</p>
                <p class="text-2xl font-black text-slate-800">{{ $users->where('role', 'admin')->count() }}</p>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm flex items-center gap-5 hover:shadow-md transition-all">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-emerald-500 text-2xl">edit_document</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Editor</p>
                <p class="text-2xl font-black text-slate-800">{{ $users->where('role', '!=', 'admin')->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white/50 backdrop-blur-md border border-slate-200/60 rounded-3xl p-4 shadow-sm">
        <div class="relative w-full md:w-80 group text-slate-400 focus-within:text-slate-800">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input type="text" placeholder="Cari nama atau email..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm font-medium focus:ring-4 focus:ring-slate-800/5 focus:border-slate-800 transition-all outline-none text-slate-800 shadow-sm">
        </div>
        
        <a href="{{ route('admin.users.create') }}" 
            class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[11px] uppercase tracking-[0.15em] flex items-center justify-center gap-2 hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
            <span class="material-symbols-outlined text-[18px] group-hover:rotate-90 transition-transform">person_add</span>
            Tambah Staf Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl text-sm font-bold flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    {{-- Users Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($users as $user)
        <div class="group bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col p-6">
            {{-- User Header --}}
            <div class="flex flex-col items-center text-center mb-6 relative">
                @if($user->role === 'admin')
                    <div class="absolute top-0 right-0 bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-[12px]">shield_person</span> Admin
                    </div>
                @else
                    <div class="absolute top-0 right-0 bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-[12px]">edit</span> Editor
                    </div>
                @endif
                
                <div class="w-20 h-20 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-black text-2xl shadow-sm mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="text-lg font-black text-slate-800 leading-tight">
                    {{ $user->name }}
                </h3>
                <p class="text-xs font-bold text-slate-400 mt-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">mail</span>
                    {{ $user->email }}
                </p>
            </div>

            {{-- Footer Area --}}
            <div class="pt-5 border-t border-slate-100 mt-auto flex items-center justify-between">
                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                    ID: #{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                </div>

                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                        class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </a>
                    
                    @if($user->role !== 'admin' && $user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus akses staf ini secara permanen?')">
                        @csrf @method('DELETE')
                        <button type="submit" 
                            class="w-8 h-8 rounded-full bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">person_remove</span>
                        </button>
                    </form>
                    @else
                    <button type="button" disabled class="w-8 h-8 rounded-full bg-slate-50 text-slate-200 flex items-center justify-center cursor-not-allowed" title="Tidak dapat dihapus">
                        <span class="material-symbols-outlined text-[16px]">lock</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
