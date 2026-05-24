<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function articles()
    {
        return $this->hasMany(Article::class)->withTrashed();
    }

    // Relasi: Satu kategori punya banyak portfolio
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }
}