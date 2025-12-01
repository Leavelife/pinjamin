<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
    
            // Ditujukan untuk siapa?
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    
            // Tipe notifikasi
            $table->enum('type', [
                'pengajuan_peminjaman',
                'persetujuan_peminjaman',
                'penolakan_peminjaman',
                'pengingat_pengembalian',
                'barang_dikembalikan',
                'info_lain'
            ])->default('info_lain');
    
            // Judul dan pesan
            $table->string('title');
            $table->text('message');
    
            // Info terkait (opsional)
            $table->unsignedBigInteger('related_id')->nullable();
            $table->string('related_type')->nullable(); // 'pinjaman' atau 'barang'
    
            // Status dibaca
            $table->timestamp('read_at')->nullable();
    
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
    
};
