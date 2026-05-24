<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 150)->unique();
            $table->enum('status', ['subscribed', 'unsubscribed'])->default('subscribed');
            $table->timestamps();
            // Tidak perlu soft delete, jika unsubscribed, ubah status saja.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};