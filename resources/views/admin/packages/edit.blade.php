@extends('layouts.admin')
@section('title', 'Edit Paket - Rakira CMS')
@section('page_title', 'Edit Paket')
@section('content')
<div class="max-w-2xl bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm p-6">
    <form action="{{ route('admin.packages.update', $package) }}" method="POST">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kode Paket</label>
                <input type="text" name="package_code" value="{{ old('package_code', $package->package_code) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Nama Paket</label>
                <input type="text" name="package_name" value="{{ old('package_name', $package->package_name) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Max Produk</label>
                <input type="number" name="package_max_products" value="{{ old('package_max_products', $package->package_max_products) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga Langganan</label>
                <input type="number" name="package_price" value="{{ old('package_price', $package->package_price) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="btn-primary mt-4">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection