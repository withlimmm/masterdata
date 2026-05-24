<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan ini

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes; // Tambahkan SoftDeletes di sini

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'editor'], true);
    }

    // Relasi: Satu Admin bisa menulis banyak Artikel
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    // Relasi: Satu Admin bisa memiliki banyak catatan aktivitas
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}