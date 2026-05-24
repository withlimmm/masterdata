<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('Rakira Digital Nusantara');
            $table->text('about_us')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('motto')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('logo_path')->nullable();
            // Kita tidak pakai soft delete di sini karena biasanya row ini hanya 1 dan di-update terus.
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};