<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CompanyConfig extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'mst_companies_config';

    protected $fillable = [
        'company_id',
        'cfg_app_logo',
        'cfg_primary_color',
        'cfg_secondary_color',
        'cfg_payment_api_key',
        'cfg_site_name',
        'cfg_about_us',
        'cfg_phone',
        'cfg_email',
        'cfg_address',
        'cfg_facebook',
        'cfg_instagram',
        'cfg_twitter',
        'cfg_youtube',
        'cfg_linkedin',
    ];

    /**
     * Get the company that owns this configuration.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
