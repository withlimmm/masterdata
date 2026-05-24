<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name', 150);
            $table->string('sender_email', 150);
            $table->string('company_name', 150)->nullable();
            $table->string('subject', 200)->nullable();
            $table->text('message_body');
            $table->enum('status', ['unread', 'read', 'replied'])->default('unread');
            $table->timestamp('replied_at')->nullable(); // Kapan admin membalas pesan ini
            $table->timestamps();
            $table->softDeletes(); // Menyimpan riwayat pesan meskipun sudah 'dihapus' admin
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};