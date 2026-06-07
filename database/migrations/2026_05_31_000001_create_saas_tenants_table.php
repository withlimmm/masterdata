<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saas_tenants', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('domain')->unique()->comment('e.g. akagroupconsulting.com');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('plan')->default('basic')->comment('basic, professional, enterprise');
            $table->decimal('price_yearly', 12, 2)->nullable();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('expires_at')->nullable()->comment('Tanggal berakhir langganan');
            $table->enum('status', ['active', 'expired', 'suspended', 'trial'])->default('trial');
            $table->string('api_key', 64)->unique()->nullable()->comment('Key untuk verifikasi dari domain client');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saas_tenants');
    }
};
