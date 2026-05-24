<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'company_name' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:150|unique:clients,email',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'testimonial' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('clients/logos', 'public');
            $validated['company_logo'] = $path;
        }

        Client::create($validated);
        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil ditambahkan!');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'company_name' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:150|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'testimonial' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('company_logo')) {
            // Hapus logo lama jika ada
            if ($client->company_logo) {
                Storage::disk('public')->delete($client->company_logo);
            }
            $path = $request->file('company_logo')->store('clients/logos', 'public');
            $validated['company_logo'] = $path;
        }

        $client->update($validated);
        return redirect()->route('admin.clients.index')->with('success', 'Data klien diperbarui!');
    }

    public function destroy(Client $client)
    {
        if ($client->company_logo) {
            Storage::disk('public')->delete($client->company_logo);
        }
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'Klien dihapus!');
    }
}