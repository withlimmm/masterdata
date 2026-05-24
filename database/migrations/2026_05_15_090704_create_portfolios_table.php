<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('project_name', 200);
            $table->string('slug', 220)->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Relasi ke tabel categories
            $table->string('client_name', 150)->nullable();
            $table->date('project_date')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->enum('status', ['active', 'done', 'draft'])->default('active'); // Mengikuti badge status di UI
            $table->timestamps();
            $table->softDeletes(); // Wajib untuk keamanan data (Soft Delete)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};