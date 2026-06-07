<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Package extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'mst_packages';

    protected $fillable = [
        'package_code',
        'package_name',
        'package_max_products',
        'package_price',
    ];

    /**
     * Get the companies that subscribe to this package.
     */
    public function companies()
    {
        return $this->hasMany(Company::class, 'package_id');
    }
}
