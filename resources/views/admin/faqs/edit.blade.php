@php
    $faqQuestion = json_decode($faq->question, true);
    $faqAnswer = json_decode($faq->answer, true);

    $questionId = old('question_id', is_array($faqQuestion) ? ($faqQuestion['id'] ?? $faqQuestion['en'] ?? $faq->question) : $faq->question);
    $questionEn = old('question_en', is_array($faqQuestion) ? ($faqQuestion['en'] ?? '') : '');
    $answerId = old('answer_id', is_array($faqAnswer) ? ($faqAnswer['id'] ?? $faqAnswer['en'] ?? $faq->answer) : $faq->answer);
    $answerEn = old('answer_en', is_array($faqAnswer) ? ($faqAnswer['en'] ?? '') : '');
@endphp

@extends('layouts.admin')

@section('title', 'Edit FAQ - Rakira CMS')
@section('page_title', 'Perbarui FAQ')

@section('content')
<div class="max-w-3xl mx-auto pb-20">
    {{-- Header Actions --}}
    <div class="mb-8 flex items-center justify-between animate-in slide-in-from-left duration-500">
        <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-900 transition-colors group">
            <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span class="text-xs font-black uppercase tracking-widest">Kembali ke Daftar</span>
        </a>
    </div>

    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST" class="space-y-8 animate-in fade-in duration-700">
        @csrf
        @method('PUT')
        
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 md:p-10 shadow-sm space-y-8">
            {{-- Pertanyaan --}}
            <div class="space-y-3">
                <label for="question_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Pertanyaan (Indonesia) *</label>
                <input type="text" name="question_id" id="question_id" required value="{{ $questionId }}"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none">
            </div>

            <div class="space-y-3">
                <label for="question_en" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Question (English)</label>
                <input type="text" name="question_en" id="question_en" value="{{ $questionEn }}"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none">
            </div>

            {{-- Jawaban --}}
            <div class="space-y-3">
                <label for="answer_id" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Jawaban (Indonesia) *</label>
                <textarea name="answer_id" id="answer_id" rows="6" required
                    class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all outline-none resize-none">{{ $answerId }}</textarea>
            </div>

            <div class="space-y-3">
                <label for="answer_en" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Answer (English)</label>
                <textarea name="answer_en" id="answer_en" rows="6"
                    class="w-full bg-slate-50 border border-slate-200 rounded-[1.5rem] px-6 py-5 text-sm leading-relaxed focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all outline-none resize-none">{{ $answerEn }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Urutan --}}
                <div class="space-y-3">
                    <label for="sort_order" class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $faq->sort_order) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-6 py-4 text-sm focus:bg-white focus:ring-4 focus:ring-slate-800/10 focus:border-slate-800 transition-all font-bold outline-none">
                </div>

                {{-- Status --}}
                <div class="space-y-3">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Status</label>
                    <div class="flex gap-4">
                        <label class="cursor-pointer flex-1">
                            <input type="radio" name="status" value="active" class="peer hidden" {{ $faq->status == 'active' ? 'checked' : '' }}>
                            <div class="flex items-center justify-center gap-2 px-5 py-4 rounded-xl bg-slate-50 border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all">
                                <span class="text-[10px] font-black uppercase tracking-widest">Aktif</span>
                            </div>
                        </label>
                        <label class="cursor-pointer flex-1">
                            <input type="radio" name="status" value="inactive" class="peer hidden" {{ $faq->status == 'inactive' ? 'checked' : '' }}>
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
            class="w-full bg-slate-900 text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:bg-slate-800 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3">
            <span class="material-symbols-outlined">save</span>
            Perbarui FAQ
        </button>
    </form>
</div>
@endsection
