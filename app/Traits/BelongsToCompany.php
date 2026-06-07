<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Company;

trait BelongsToCompany
{
    /**
     * Boot the trait to add the global scope.
     */
    protected static function bootBelongsToCompany()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            // Jika ada context tenant aktif dan bukan super_admin yang sedang melihat semua data
            if (app()->bound('tenant') && app('tenant') instanceof Company) {
                $builder->where($builder->getModel()->getTable() . '.company_id', app('tenant')->id);
            }
        });

        static::creating(function ($model) {
            if (app()->bound('tenant') && app('tenant') instanceof Company && empty($model->company_id)) {
                $model->company_id = app('tenant')->id;
            }
        });
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
