<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class System extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'mst_systems';

    protected $fillable = [
        'system_code',
        'system_name',
        'description',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'system_id');
    }
}
