@extends('layouts.admin')

@section('title', 'Tambah FAQ - Rakira CMS')
@section('page_title', 'Tambah FAQ Baru')

@section('content')
<div class="max-w-3xl mx-auto pb-20">
    {{-- Header Actions --}}
    <div class="mb-8 flex items-center justify-between animate-in slide-in-from-left duration-500">
        <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-900 transition-colors group">
            <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="text-xs font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 md:p-10 shadow-sm space-y-8">
            {{-- Pertanyaan --}}
            <div class="space-y-3">
                <label for="question_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Pertanyaan (Indonesia) *</label>
                <input type="text" name="question_id" id="question_id" required value="{{ old('question_id') }}"
                    placeholder="Contoh: Berapa lama waktu pengerjaan website?"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
            </div>

            <div class="space-y-3">
                <label for="question_en" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Question (English)</label>
                <input type="text" name="question_en" id="question_en" value="{{ old('question_en') }}"
                    placeholder="Example: How long does the website development take?"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
            </div>

            {{-- Jawaban --}}
            <div class="space-y-3">
                <label for="answer_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Jawaban (Indonesia) *</label>
                <textarea name="answer_id" id="answer_id" rows="6" required
                    placeholder="Tuliskan jawaban lengkap di sini..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ old('answer_id') }}</textarea>
            </div>

            <div class="space-y-3">
                <label for="answer_en" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Answer (English)</label>
                <textarea name="answer_en" id="answer_en" rows="6"
                    placeholder="Write the full answer here..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all outline-none resize-none">{{ old('answer_en') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Urutan --}}
                <div class="space-y-3">
                    <label for="sort_order" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all font-bold outline-none">
                </div>

                {{-- Status --}}
                <div class="space-y-3">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status</label>
                    <div class="flex gap-4">
                        <label class="cursor-pointer flex-1">
                            <input type="radio" name="status" value="active" class="peer hidden" checked>
                            <div class="flex items-center justify-center gap-2 px-5 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all">
                                <span class="text-[10px] font-black uppercase tracking-widest">Aktif</span>
                            </div>
                        </label>
                        <label class="cursor-pointer flex-1">
                            <input type="radio" name="status" value="inactive" class="peer hidden">
                            <div class="flex items-center justify-center gap-2 px-5 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-slate-900 peer-checked:border-slate-900 peer-checked:text-white transition-all">
                                <span class="text-[10px] font-black uppercase tracking-widest">Non-Aktif</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action --}}
        <button type="submit" 
            class="w-full bg-primary text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:bg-primary/90 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
            <span class="material-symbols-outlined">save</span>
            Simpan FAQ
        </button>
    </form>
</div>
@endsection
