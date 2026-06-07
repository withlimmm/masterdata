@extends('layouts.admin')
@section('title', 'Kelola Tim - Rakira CMS')
@section('page_title', 'Kelola Staf / Tim')
@section('content')
<div class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden shadow-sm">
    <div class="p-4 border-b border-outline-variant/50 flex justify-between items-center bg-slate-50/50">
        <h2 class="text-lg font-bold text-on-surface">Daftar Akun Tim</h2>
        <a href="{{ route('admin.users.create') }}" class="btn-primary text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">add</span> Tambah Staf
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-slate-600 font-medium">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/50">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-on-surface">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-[10px] uppercase tracking-wider font-bold rounded-full {{ $user->role === 'admin' ? 'bg-primary/10 text-primary' : 'bg-secondary/10 text-secondary' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            @if($user->role !== 'admin' && $user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus staf ini?');" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
