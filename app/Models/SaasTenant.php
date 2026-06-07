<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SaasTenant extends Model
{
    use SoftDeletes;

    protected $table = 'saas_tenants';

    protected $guarded = ['id'];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'expires_at'    => 'datetime',
        'price_yearly'  => 'decimal:2',
    ];

    /** Generate API key otomatis sebelum create */
    protected static function booted(): void
    {
        static::creating(function (self $tenant) {
            if (empty($tenant->api_key)) {
                $tenant->api_key = Str::random(32) . bin2hex(random_bytes(16));
            }
        });
    }

    // ─── Accessors ───────────────────────────────────────────────

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getDaysRemainingAttribute(): int
    {
        if (!$this->expires_at) return 0;
        return max(0, (int) Carbon::now()->diffInDays($this->expires_at, false));
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active'    => 'bg-emerald-100 text-emerald-700',
            'expired'   => 'bg-red-100 text-red-700',
            'suspended' => 'bg-orange-100 text-orange-700',
            'trial'     => 'bg-blue-100 text-blue-700',
            default     => 'bg-gray-100 text-gray-700',
        };
    }

    public function getPlanLabelAttribute(): string
    {
        return match ($this->plan) {
            'basic'        => 'Basic',
            'professional' => 'Professional',
            'enterprise'   => 'Enterprise',
            default        => ucfirst($this->plan),
        };
    }

    // ─── Scopes ─────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('expires_at', '>', now());
    }

    public function scopeExpiringSoon($query, int $days = 7)
    {
        return $query->where('status', 'active')
                     ->whereBetween('expires_at', [now(), now()->addDays($days)]);
    }
}
