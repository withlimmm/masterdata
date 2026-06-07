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
        Schema::table('mst_companies_config', function (Blueprint $table) {
            $table->string('cfg_site_name')->nullable();
            $table->text('cfg_about_us')->nullable();
            $table->string('cfg_phone')->nullable();
            $table->string('cfg_email')->nullable();
            $table->text('cfg_address')->nullable();
            
            // Socials
            $table->string('cfg_facebook')->nullable();
            $table->string('cfg_instagram')->nullable();
            $table->string('cfg_twitter')->nullable();
            $table->string('cfg_youtube')->nullable();
            $table->string('cfg_linkedin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_companies_config', function (Blueprint $table) {
            $table->dropColumn([
                'cfg_site_name',
                'cfg_about_us',
                'cfg_phone',
                'cfg_email',
                'cfg_address',
                'cfg_facebook',
                'cfg_instagram',
                'cfg_twitter',
                'cfg_youtube',
                'cfg_linkedin',
            ]);
        });
    }
};
