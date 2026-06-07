<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientProject extends Model
{
    use HasFactory, SoftDeletes;
    use \App\Traits\BelongsToCompany;

    protected $guarded = ['id'];

    // Relasi: Proyek ini milik siapa?
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}