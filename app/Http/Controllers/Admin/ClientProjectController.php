<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientProject;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientProjectController extends Controller
{
    public function index()
    {
        // Memanggil proyek beserta data klien yang terelasi
        $projects = ClientProject::with('client')->latest()->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'workflow_status' => 'required|in:planning,design,development,testing,deployed',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
            'project_value' => 'nullable|numeric',
        ]);

        ClientProject::create($validated);
        return redirect()->route('admin.client-projects.index')->with('success', 'Proyek internal berhasil dibuat!');
    }

    public function update(Request $request, ClientProject $clientProject)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'project_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'workflow_status' => 'required|in:planning,design,development,testing,deployed',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
            'project_value' => 'nullable|numeric',
        ]);

        $clientProject->update($validated);
        return redirect()->route('admin.client-projects.index')->with('success', 'Status proyek diperbarui!');
    }

    public function destroy(ClientProject $clientProject)
    {
        $clientProject->delete();
        return redirect()->route('admin.client-projects.index')->with('success', 'Proyek dihapus!');
    }
}