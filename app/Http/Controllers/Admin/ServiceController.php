<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'short_description_id' => 'required|string',
            'short_description_en' => 'nullable|string',
            'full_description_id' => 'required|string',
            'full_description_en' => 'nullable|string',
            'icon_image' => 'nullable|string|max:100', // Material Icon name
            'status' => 'required|in:active,draft',
        ]);

        $service = Service::create([
            'title' => $this->packLocaleText($validated['title_id'], $validated['title_en'] ?? null),
            'short_description' => $this->packLocaleText($validated['short_description_id'], $validated['short_description_en'] ?? null),
            'full_description' => $this->packLocaleText($validated['full_description_id'] ?? '', $validated['full_description_en'] ?? null),
            'icon_image' => $validated['icon_image'] ?? null,
            'status' => $validated['status'],
            'slug' => Str::slug($validated['title_id']),
        ]);
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title_id' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'short_description_id' => 'required|string',
            'short_description_en' => 'nullable|string',
            'full_description_id' => 'required|string',
            'full_description_en' => 'nullable|string',
            'icon_image' => 'nullable|string|max:100',
            'status' => 'required|in:active,draft',
        ]);

        $service->update([
            'title' => $this->packLocaleText($validated['title_id'], $validated['title_en'] ?? null),
            'short_description' => $this->packLocaleText($validated['short_description_id'], $validated['short_description_en'] ?? null),
            'full_description' => $this->packLocaleText($validated['full_description_id'] ?? '', $validated['full_description_en'] ?? null),
            'icon_image' => $validated['icon_image'] ?? null,
            'status' => $validated['status'],
            'slug' => Str::slug($validated['title_id']),
        ]);
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus!');
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