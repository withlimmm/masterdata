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
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('google_analytics_id')->nullable()->after('about_us');
            $table->string('facebook_pixel_id')->nullable()->after('google_analytics_id');
            $table->string('instagram_url')->nullable()->after('facebook_pixel_id');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('facebook_url')->nullable()->after('linkedin_url');
            $table->text('google_maps_iframe')->nullable()->after('facebook_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn([
                'google_analytics_id',
                'facebook_pixel_id',
                'instagram_url',
                'linkedin_url',
                'facebook_url',
                'google_maps_iframe'
            ]);
        });
    }
};
