<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'mst_companies';

    protected static function booted()
    {
        static::creating(function ($company) {
            if (empty($company->id)) {
                $company->id = (string) Str::uuid();
            }
            if (empty($company->vendor_id)) {
                $company->vendor_id = (string) Str::uuid();
            }
            if (empty($company->api_key)) {
                $company->api_key = 'rk_' . Str::random(32);
            }
        });
    }

    public function generateApiKey()
    {
        $this->update(['api_key' => 'rk_' . Str::random(32)]);
    }

    protected $fillable = [
        'vendor_id',
        'package_id',
        'company_code',
        'company_name',
        'company_domain',
        'api_key',
        'subscription_status',
        'subscription_start_at',
        'subscription_expired_at',
    ];

    protected $casts = [
        'subscription_start_at' => 'datetime',
        'subscription_expired_at' => 'datetime',
    ];

    /**
     * Get the package that the company is subscribed to.
     */
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * Get the white-label configuration associated with the company.
     */
    public function config()
    {
        return $this->hasOne(CompanyConfig::class, 'company_id');
    }
}
