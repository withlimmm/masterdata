<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Only get users that belong to the current company (tenant)
        $users = User::where('company_id', app('tenant')->id)->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'editor', // Force role to editor for sub-accounts
            'company_id' => app('tenant')->id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun staf berhasil dibuat.');
    }

    public function edit(User $user)
    {
        // Security check: Make sure user belongs to the current tenant
        if ($user->company_id !== app('tenant')->id) {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->company_id !== app('tenant')->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data akun staf berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->company_id !== app('tenant')->id) {
            abort(403);
        }

        // Prevent deleting themselves or the main admin
        if ($user->id === auth()->id() || $user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin utama atau akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun staf berhasil dihapus.');
    }
}
