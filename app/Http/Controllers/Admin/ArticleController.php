<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['author', 'category'])->latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:published,draft',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validated['slug'] = Str::slug($request->title) . '-' . time();
        $validated['user_id'] = auth()->id();
        $validated['content'] = strip_tags($validated['content'], '<h1><h2><h3><h4><h5><h6><p><br><a><b><i><strong><em><ul><ol><li><blockquote><img><table><thead><tbody><tr><th><td>');

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('articles', 'public');
            $validated['cover_image'] = $path;
        }

        if ($request->status == 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit(Article $article)
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:published,draft',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Tetap gunakan slug lama kecuali jika judul berubah drastis? 
        // Untuk kestabilan SEO, kita tidak ubah slug di update kecuali perlu.
        $validated['content'] = strip_tags($validated['content'], '<h1><h2><h3><h4><h5><h6><p><br><a><b><i><strong><em><ul><ol><li><blockquote><img><table><thead><tbody><tr><th><td>');
        
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $path = $request->file('cover_image')->store('articles', 'public');
            $validated['cover_image'] = $path;
        }

        if ($request->status == 'published' && !$article->published_at) {
            $validated['published_at'] = now();
        }

        $article->update($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}