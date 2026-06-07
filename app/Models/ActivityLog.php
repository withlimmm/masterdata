<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;

class ActivityLog extends Model
{
    use HasFactory, Prunable;
    use \App\Traits\BelongsToCompany;

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(30));
    }

    protected $guarded = ['id'];

    // Relasi: Mengetahui log aktivitas ini dilakukan oleh admin/user siapa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}