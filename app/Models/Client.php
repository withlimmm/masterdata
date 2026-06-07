<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    use \App\Traits\BelongsToCompany;

    protected $guarded = ['id'];

    public function projects()
    {
        return $this->hasMany(ClientProject::class)->withTrashed();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->withTrashed();
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_clients_v2');
            \Illuminate\Support\Facades\Cache::forget('home_client_logos_v2');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_clients_v2');
            \Illuminate\Support\Facades\Cache::forget('home_client_logos_v2');
        });
    }
}
