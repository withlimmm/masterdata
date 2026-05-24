@extends('layouts.admin')

@section('title', 'Manajemen Kategori - Rakira CMS')
@section('page_title', 'Kategori Portofolio')
@section('page_subtitle', 'Kelola pengelompokan proyek portofolio agar mudah difilter oleh pengunjung.')

@section('content')
<div class="max-w-4xl space-y-6 animate-in fade-in duration-700">
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">category</span>
            <span class="text-sm font-bold text-slate-600">{{ $categories->count() }} Total Kategori</span>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-slate-800 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Kategori Baru
        </a>
    </div>

    {{-- Categories Table --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Kategori</th>
                        <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Slug / URL</th>
                        <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="py-6 px-8 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($categories as $cat)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="py-5 px-8">
                            <p class="text-sm font-bold text-slate-900 group-hover:text-primary transition-colors">{{ $cat->name }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">Dibuat {{ $cat->created_at ? $cat->created_at->format('d M Y') : '-' }}</p>
                        </td>
                        <td class="py-5 px-6">
                            <code class="text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-500">{{ $cat->slug }}</code>
                        </td>
                        <td class="py-5 px-6">
                            @if($cat->status == 'active')
                                <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black uppercase tracking-widest">Active</span>
                            @else
                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-400 border border-slate-200 text-[9px] font-black uppercase tracking-widest">Inactive</span>
                            @endif
                        </td>
                        <td class="py-5 px-8 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" 
                                   class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary hover:shadow-lg transition-all">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Data portofolio terkait mungkin terdampak.')">
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
                        <td colspan="4" class="py-20 text-center">
                            <div class="flex flex-col items-center gap-3 opacity-20">
                                <span class="material-symbols-outlined text-6xl">category</span>
                                <p class="text-sm font-bold uppercase tracking-[0.2em]">Belum ada kategori</p>
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
