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
        Schema::create('mst_companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('package_id');
            $table->string('company_code', 10)->unique();
            $table->string('company_name', 100);
            $table->string('company_domain', 100)->unique();
            $table->enum('subscription_status', ['active', 'suspended', 'expired'])->default('active');
            $table->dateTime('subscription_start_at');
            $table->dateTime('subscription_expired_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('package_id')->references('id')->on('mst_packages')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_companies');
    }
};
