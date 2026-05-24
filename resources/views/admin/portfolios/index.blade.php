@extends('layouts.admin')

@section('title', 'Manajemen Portofolio - Rakira CMS')
@section('page_title', 'Portofolio Proyek')
@section('page_subtitle', 'Kelola daftar karya terbaik Rakira Digital yang ditampilkan di website.')

@section('content')
<div class="space-y-6 animate-in fade-in duration-700">
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">folder_shared</span>
            <span class="text-sm font-bold text-slate-600">{{ $portfolios->count() }} Total Proyek</span>
        </div>
        <a href="{{ route('admin.portfolios.create') }}" 
           class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Proyek Baru
        </a>
    </div>

    {{-- Portfolio Table --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400">Proyek</th>
                        <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori</th>
                        <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Klien</th>
                        <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="py-6 px-8 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($portfolios as $portfolio)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="py-5 px-8">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-10 rounded-lg bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                                    @if($portfolio->thumbnail_image)
                                        <img src="{{ asset('storage/' . $portfolio->thumbnail_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <span class="material-symbols-outlined text-xl">image</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-primary transition-colors">{{ $portfolio->project_name }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Updated {{ $portfolio->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest">
                                {{ $portfolio->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="py-5 px-6">
                            <p class="text-xs font-bold text-slate-600">{{ $portfolio->client_name ?? '-' }}</p>
                        </td>
                        <td class="py-5 px-6">
                            @php
                                $statusClasses = [
                                    'active' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'done' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'draft' => 'bg-slate-100 text-slate-500 border-slate-200'
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-lg border {{ $statusClasses[$portfolio->status] ?? $statusClasses['draft'] }} text-[9px] font-black uppercase tracking-widest">
                                {{ $portfolio->status }}
                            </span>
                        </td>
                        <td class="py-5 px-8 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}" 
                                   class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary hover:shadow-lg transition-all">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-200 hover:shadow-lg transition-all">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center gap-3 opacity-20">
                                <span class="material-symbols-outlined text-6xl">inventory_2</span>
                                <p class="text-sm font-bold uppercase tracking-[0.2em]">Belum ada data proyek</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
