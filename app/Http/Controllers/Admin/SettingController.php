<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyConfig;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first()) ?? new CompanyConfig();
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
            'google_analytics_id' => 'nullable|string|max:100',
            'facebook_pixel_id' => 'nullable|string|max:100',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'google_maps_iframe' => 'nullable|string',
        ]);

        $setting = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
        if (!$setting) {
            $setting = new CompanyConfig();
        }
        
        $setting->fill($validated);
        $setting->save();

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}