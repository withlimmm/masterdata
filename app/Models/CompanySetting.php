<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function about()
    {
        $companySetting = CompanySetting::first(); // ambil baris pertama
        $teams = Team::all(); // jika ada
        return view('about', compact('companySetting', 'teams'));
    }
}