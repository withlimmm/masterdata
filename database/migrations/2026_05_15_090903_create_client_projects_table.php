<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('project_name', 200);
            $table->text('description')->nullable();
            // Status untuk Kanban Board Workflow
            $table->enum('workflow_status', ['planning', 'design', 'development', 'testing', 'deployed'])->default('planning');
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->decimal('project_value', 15, 2)->nullable(); // Nilai kontrak proyek (opsional, untuk admin saja)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_projects');
    }
};