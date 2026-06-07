<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan role untuk manajemen otorisasi
            $table->string('role')->default('admin')->after('password');
            $table->string('avatar')->nullable()->after('role'); // Foto profil admin
            $table->softDeletes(); // Keamanan agar akun admin yang dihapus bisa di-restore
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar']);
            $table->dropSoftDeletes();
        });
    }
};
