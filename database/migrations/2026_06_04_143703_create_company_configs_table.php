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
        Schema::create('mst_companies_config', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id')->unique();
            $table->string('cfg_app_logo', 255);
            $table->string('cfg_primary_color', 7)->default('#000000');
            $table->string('cfg_secondary_color', 7)->default('#FFFFFF');
            $table->text('cfg_payment_api_key')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('mst_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_companies_config');
    }
};
