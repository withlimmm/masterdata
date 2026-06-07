@extends('layouts.admin')
@section('title', 'Edit Staf - Rakira CMS')
@section('page_title', 'Edit Data Staf')
@section('content')
<div class="max-w-2xl bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm p-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password Baru <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <input type="password" name="password" class="w-full border-gray-300 rounded-md" minlength="8" placeholder="Biarkan kosong jika tidak ingin mengubah password">
            </div>
            <div class="pt-4">
                <button type="submit" class="btn-primary w-full">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
@endsection
