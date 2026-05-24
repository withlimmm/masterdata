@extends('layouts.admin')

@section('title', 'Manajemen FAQ - Rakira CMS')
@section('page_title', 'Tanya Jawab (FAQ)')
@section('page_subtitle', 'Kelola pertanyaan yang sering diajukan untuk memudahkan calon klien.')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    {{-- Header Actions --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="bg-primary/5 p-3 rounded-2xl">
                <span class="material-symbols-outlined text-primary">quiz</span>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-900">Total FAQ</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $faqs->count() }} Data Terdaftar</p>
            </div>
        </div>
        
        <a href="{{ route('admin.faqs.create') }}" 
            class="bg-slate-900 text-white px-6 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-slate-800 transition-all shadow-lg active:scale-95">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Tambah FAQ
        </a>
    </div>

    {{-- FAQ Table --}}
    <div class="bg-white border border-slate-200 rounded-[2.5rem] overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400 w-16 text-center">Urutan</th>
                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400">Pertanyaan & Jawaban</th>
                    <th class="py-6 px-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="py-6 px-8 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($faqs as $faq)
                @php
                    $question = __t($faq->question);
                    $answer = __t($faq->answer);
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="py-6 px-8">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-xs font-black text-slate-400 mx-auto">
                            {{ $faq->sort_order }}
                        </div>
                    </td>
                    <td class="py-6 px-8">
                        <div>
                            <p class="text-sm font-bold text-slate-900 mb-1">{{ $question }}</p>
                            <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">{{ $answer }}</p>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        @if($faq->status === 'active')
                            <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black uppercase tracking-widest">Active</span>
                        @else
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-400 border border-slate-200 text-[9px] font-black uppercase tracking-widest">Inactive</span>
                        @endif
                    </td>
                    <td class="py-5 px-8 text-right">
                        <div class="flex justify-end items-center gap-3">
                            <a href="{{ route('admin.faqs.edit', $faq->id) }}" 
                                class="w-9 h-9 rounded-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all group-hover:bg-white group-hover:shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                    class="w-9 h-9 rounded-xl border border-slate-100 flex items-center justify-center text-slate-300 hover:text-red-500 hover:border-red-100 transition-all group-hover:bg-white group-hover:shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-20 text-center">
                        <div class="flex flex-col items-center gap-3 opacity-20">
                            <span class="material-symbols-outlined text-6xl text-slate-400">help_center</span>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Belum ada FAQ yang dibuat</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
