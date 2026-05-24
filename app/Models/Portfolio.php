<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    protected $casts = [
        'gallery_images' => 'array',
        'project_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke Kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
