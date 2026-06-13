<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('system')->latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $systems = \App\Models\System::orderBy('system_name')->get();
        return view('admin.packages.create', compact('systems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'system_id' => 'required|exists:mst_systems,id',
            'package_code' => 'required|string|max:20|unique:mst_packages,package_code',
            'package_name' => 'required|string|max:50',
            'package_description' => 'nullable|string',
            'package_benefits' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
        ]);

        $validated['is_popular'] = $request->has('is_popular');

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        $systems = \App\Models\System::orderBy('system_name')->get();
        return view('admin.packages.edit', compact('package', 'systems'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'system_id' => 'required|exists:mst_systems,id',
            'package_code' => 'required|string|max:20|unique:mst_packages,package_code,' . $package->id,
            'package_name' => 'required|string|max:50',
            'package_description' => 'nullable|string',
            'package_benefits' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
        ]);

        $validated['is_popular'] = $request->has('is_popular');

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket langganan berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
