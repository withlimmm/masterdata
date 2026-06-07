<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_code' => 'required|string|max:20|unique:mst_packages,package_code',
            'package_name' => 'required|string|max:50',
            'package_max_products' => 'required|integer|min:1',
            'package_price' => 'required|numeric|min:0',
        ]);

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'package_code' => 'required|string|max:20|unique:mst_packages,package_code,' . $package->id,
            'package_name' => 'required|string|max:50',
            'package_max_products' => 'required|integer|min:1',
            'package_price' => 'required|numeric|min:0',
        ]);

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket langganan berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
