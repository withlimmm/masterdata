@extends('layouts.admin')
@section('title', 'Tambah Staf - Rakira CMS')
@section('page_title', 'Tambah Staf Baru')
@section('content')
<div class="max-w-2xl bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm p-6">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded-md" required minlength="8">
            </div>
            <div class="pt-2">
                <p class="text-xs text-amber-600 bg-amber-50 p-3 rounded-md mb-4 border border-amber-200">
                    <strong class="block mb-1">Info Hak Akses:</strong>
                    Akun staf baru akan secara otomatis diatur sebagai <b>Editor</b>. Editor dapat menambahkan dan mengubah data portofolio/artikel, namun tidak dapat mengubah pengaturan langganan sistem.
                </p>
                <button type="submit" class="btn-primary w-full">Buat Akun Staf</button>
            </div>
        </div>
    </form>
</div>
@endsection
