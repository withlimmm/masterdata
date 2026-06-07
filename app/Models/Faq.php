<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    use \App\Traits\BelongsToCompany;

    protected $fillable = [
        'question',
        'answer',
        'sort_order',
        'status'
    ];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('home_faqs_v4');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_faqs_v4');
        });
    }
}
