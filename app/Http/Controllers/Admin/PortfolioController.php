<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    use \App\Traits\CheckPackageLimit;

    public function index()
    {
        $portfolios = Portfolio::with('category')->latest()->get(); 
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.portfolios.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->enforcePackageLimit(Portfolio::class);

        $validated = $request->validate([
            'project_name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,done,draft',
            'description' => 'nullable|string',
            'client_name' => 'nullable|string|max:150',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Slug hanya dibuat sekali di sini
        $validated['slug'] = Str::slug($request->project_name) . '-' . rand(1000, 9999);

        if ($request->hasFile('thumbnail_image')) {
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store(tenant_path('portfolios/thumbnails'), 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $file->store(tenant_path('portfolios/gallery'), 'public');
            }
            $validated['gallery_images'] = $gallery;
        }

        Portfolio::create($validated);

        return redirect()->route('admin.portfolios.index')->with('success', 'Project berhasil ditambahkan!');
    }

    public function edit(Portfolio $portfolio)
    {
        $categories = Category::all();
        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,done,draft',
            'description' => 'nullable|string',
            'client_name' => 'nullable|string|max:150',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Update slug HANYA jika nama proyek berubah
        if ($portfolio->project_name !== $request->project_name) {
            $validated['slug'] = Str::slug($request->project_name) . '-' . rand(1000, 9999);
        }

        if ($request->hasFile('thumbnail_image')) {
            if ($portfolio->thumbnail_image) {
                Storage::disk('public')->delete($portfolio->thumbnail_image);
            }
            $validated['thumbnail_image'] = $request->file('thumbnail_image')->store(tenant_path('portfolios/thumbnails'), 'public');
        }

        if ($request->hasFile('gallery_images')) {
            if ($portfolio->gallery_images) {
                foreach ($portfolio->gallery_images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $file->store(tenant_path('portfolios/gallery'), 'public');
            }
            $validated['gallery_images'] = $gallery;
        }

        $portfolio->update($validated);

        return redirect()->route('admin.portfolios.index')->with('success', 'Project berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        if ($portfolio->thumbnail_image) Storage::disk('public')->delete($portfolio->thumbnail_image);
        if ($portfolio->gallery_images) {
            foreach ($portfolio->gallery_images as $image) Storage::disk('public')->delete($image);
        }
        $portfolio->delete(); 
        return redirect()->route('admin.portfolios.index')->with('success', 'Project berhasil dihapus!');
    }
}