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
        // Migrasi ini membuat tabel standar Laravel untuk notifikasi berbasis database
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable'); // Membuat notifiable_type dan notifiable_id (polymorphic relation)
            $table->text('data'); // Payload JSON untuk notifikasi
            $table->integer('priority')->default(0); // Kolom baru untuk tingkat prioritas (0: Low, 1: Medium, 2: High)
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};