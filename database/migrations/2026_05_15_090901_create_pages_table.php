<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 170)->unique();
            $table->longText('content'); // Untuk inputan WYSIWYG
            $table->string('featured_image')->nullable(); // Upload gambar tim/kantor
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};