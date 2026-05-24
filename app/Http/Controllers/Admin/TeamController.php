<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::latest()->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Simpan foto ke folder storage/app/public/teams
            $data['photo'] = $request->file('photo')->store('teams', 'public');
        }

        Team::create($data);
        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil ditambahkan!');
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'position' => 'required|string|max:100',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($team->photo) {
                Storage::disk('public')->delete($team->photo);
            }
            $data['photo'] = $request->file('photo')->store('teams', 'public');
        }

        $team->update($data);
        return redirect()->route('admin.teams.index')->with('success', 'Data tim berhasil diperbarui!');
    }

    public function destroy(Team $team)
    {
        if ($team->photo) {
            Storage::disk('public')->delete($team->photo);
        }
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil dihapus!');
    }
}
