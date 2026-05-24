<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Siapa yang melakukan
            $table->string('action'); // Contoh: 'created_article', 'updated_project'
            $table->text('description'); // Contoh: 'Admin menambahkan artikel baru: Tren Web 2026'
            $table->ipAddress('ip_address')->nullable(); // Keamanan: mencatat IP admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};