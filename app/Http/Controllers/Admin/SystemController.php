<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function index()
    {
        $systems = System::latest()->get();
        return view('admin.systems.index', compact('systems'));
    }

    public function create()
    {
        return view('admin.systems.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'system_code' => 'required|string|max:20|unique:mst_systems,system_code',
            'system_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        System::create($validated);

        return redirect()->route('admin.systems.index')->with('success', 'Sistem berhasil ditambahkan.');
    }

    public function edit(System $system)
    {
        return view('admin.systems.edit', compact('system'));
    }

    public function update(Request $request, System $system)
    {
        $validated = $request->validate([
            'system_code' => 'required|string|max:20|unique:mst_systems,system_code,' . $system->id,
            'system_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $system->update($validated);

        return redirect()->route('admin.systems.index')->with('success', 'Sistem berhasil diperbarui.');
    }

    public function destroy(System $system)
    {
        if ($system->packages()->count() > 0) {
            return redirect()->route('admin.systems.index')->with('error', 'Tidak dapat menghapus sistem karena masih memiliki paket terkait.');
        }

        $system->delete();

        return redirect()->route('admin.systems.index')->with('success', 'Sistem berhasil dihapus.');
    }
}
