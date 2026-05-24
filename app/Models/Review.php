<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company', 'rating', 'comment', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_clients_v2');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_clients_v2');
        });
    }
}
