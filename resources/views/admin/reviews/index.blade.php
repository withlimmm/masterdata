@extends('layouts.admin')

@section('title', 'Manajemen Ulasan - Rakira CMS')
@section('page_title', 'Daftar Ulasan')
@section('page_subtitle', 'Kelola ulasan dari klien yang masuk melalui website.')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400">Pengirim</th>
                    <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Komentar</th>
                    <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Rating</th>
                    <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($reviews as $r)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="py-5 px-8">
                        <p class="font-bold text-sm text-slate-900">{{ $r->name }}</p>
                        <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest">{{ $r->company ?: '-' }}</p>
                    </td>
                    <td class="py-5 px-6">
                        <p class="text-sm text-slate-600 line-clamp-2 max-w-xs italic">"{{ $r->comment }}"</p>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex text-amber-400">
                            @for($i=0; $i<($r->rating ?? 5); $i++)
                                <span class="material-symbols-outlined text-[16px] fill-1">star</span>
                            @endfor
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        @if($r->status === 'approved')
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest">Approved</span>
                        @elseif($r->status === 'rejected')
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black bg-red-50 text-red-600 border border-red-100 uppercase tracking-widest">Rejected</span>
                        @else
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black bg-amber-50 text-amber-600 border border-amber-100 uppercase tracking-widest">Pending</span>
                        @endif
                    </td>
                    <td class="py-5 px-8 text-right">
                        <div class="flex justify-end items-center gap-3">
                            @if($r->status !== 'approved')
                            <form action="{{ route('admin.reviews.update', $r->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-200">Approve</button>
                            </form>
                            @endif
                            
                            @if($r->status === 'pending')
                            <form action="{{ route('admin.reviews.update', $r->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="text-slate-400 hover:text-red-500 font-bold text-[10px] uppercase tracking-widest">Reject</button>
                            </form>
                            @endif

                            <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl border border-slate-100 flex items-center justify-center text-slate-300 hover:text-red-500 hover:border-red-100 transition-all group-hover:bg-white group-hover:shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <div class="flex flex-col items-center gap-3 opacity-20">
                            <span class="material-symbols-outlined text-6xl text-slate-400">rate_review</span>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Belum ada ulasan masuk</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
