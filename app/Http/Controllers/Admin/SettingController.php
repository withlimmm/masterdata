<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::first() ?? new CompanySetting();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:200',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:50',
            'address' => 'required|string',
            'about_us' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'motto' => 'nullable|string',
        ]);

        $setting = CompanySetting::first();
        if (!$setting) {
            $setting = new CompanySetting();
        }
        
        $setting->fill($validated);
        $setting->save();

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}