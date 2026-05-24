<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|string|max:255',
            'question_en' => 'nullable|string|max:255',
            'answer_id' => 'required|string',
            'answer_en' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer'
        ]);

        Faq::create([
            'question' => $this->packLocaleText($validated['question_id'], $validated['question_en'] ?? null),
            'answer' => $this->packLocaleText($validated['answer_id'], $validated['answer_en'] ?? null),
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question_id' => 'required|string|max:255',
            'question_en' => 'nullable|string|max:255',
            'answer_id' => 'required|string',
            'answer_en' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer'
        ]);

        $faq->update([
            'question' => $this->packLocaleText($validated['question_id'], $validated['question_en'] ?? null),
            'answer' => $this->packLocaleText($validated['answer_id'], $validated['answer_en'] ?? null),
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus!');
    }

    private function packLocaleText(string $idText, ?string $enText = null): string
    {
        $payload = [
            'id' => trim($idText),
            'en' => trim((string) $enText),
        ];

        if ($payload['en'] === '') {
            unset($payload['en']);
        }

        return json_encode($payload, JSON_UNESCAPED_UNICODE);
    }
}
