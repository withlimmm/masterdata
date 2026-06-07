<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'categories',
        'services',
        'portfolios',
        'articles',
        'pages',
        'clients',
        'messages',
        'client_projects',
        'subscribers',
        'activity_logs',
        'reviews',
        'teams',
        'faqs',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'company_id')) {
                Schema::table($table, function (Blueprint $tableSchema) {
                    $tableSchema->uuid('company_id')->nullable()->after('id');
                    $tableSchema->foreign('company_id')
                        ->references('id')->on('mst_companies')
                        ->onDelete('cascade');
                });
            }
        }
        
        // Also drop company_settings and saas_tenants as they are deprecated by mst_companies and mst_companies_config
        Schema::dropIfExists('company_settings');
        Schema::dropIfExists('saas_tenants');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'company_id')) {
                Schema::table($table, function (Blueprint $tableSchema) use ($table) {
                    // SQLite in testing environment doesn't support dropping foreign keys easily,
                    // but in standard MySQL:
                    if (config('database.default') !== 'sqlite') {
                        $tableSchema->dropForeign([$table . '_company_id_foreign']);
                    }
                    $tableSchema->dropColumn('company_id');
                });
            }
        }
    }
};
