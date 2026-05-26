<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // Menampilkan daftar halaman di panel admin
    public function index()
    {
        $pages = Page::latest()->get();
        // Perbaikan: Kembalikan ke view Blade, bukan JSON
        return view('admin.pages.index', compact('pages'));
    }

    // Menampilkan form tambah halaman baru
    public function create()
    {
        return view('admin.pages.create');
    }

    // Menyimpan data halaman baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150|unique:pages,title', // Tambahan: unique agar tidak ada judul ganda
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['content'] = strip_tags($validated['content'], '<h1><h2><h3><h4><h5><h6><p><br><a><b><i><strong><em><ul><ol><li><blockquote><img><table><thead><tbody><tr><th><td>');

        Page::create($validated);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat!');
    }

    // Menampilkan form edit halaman
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    // Memperbarui data halaman di database
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            // Tambahan: abaikan validasi unique untuk judul halaman yang sedang diedit
            'title' => 'required|string|max:150|unique:pages,title,' . $page->id,
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['content'] = strip_tags($validated['content'], '<h1><h2><h3><h4><h5><h6><p><br><a><b><i><strong><em><ul><ol><li><blockquote><img><table><thead><tbody><tr><th><td>');

        $page->update($validated);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui!');
    }

    // Menghapus halaman
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus!');
    }
    public function about()
    {
        $companySetting = \App\Models\CompanySetting::first();
        $teams = \App\Models\Team::all(); // jika ada model Team
        return view('about', compact('companySetting', 'teams'));
    }
}