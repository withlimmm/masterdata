<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Relasi ke penulis (Admin)
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title', 200);
            $table->string('slug', 250)->unique();
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->string('tags')->nullable(); // Bisa menggunakan format JSON jika tag sangat banyak
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->timestamp('published_at')->nullable(); // Tanggal rilis artikel
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};