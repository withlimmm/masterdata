<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'meta_title')) {
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'meta_title')) {
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
            }
        });

        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolios', 'meta_title')) {
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('meta_keywords')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'meta_title')) {
                $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords']);
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'meta_title')) {
                $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords']);
            }
        });

        Schema::table('portfolios', function (Blueprint $table) {
            if (Schema::hasColumn('portfolios', 'meta_title')) {
                $table->dropColumn(['meta_title', 'meta_description', 'meta_keywords']);
            }
        });
    }
};
