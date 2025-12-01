<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
    
            // siapa yang meminjam
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    
            // barang apa yang dipinjam
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
    
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable(); // user mengajukan
            $table->date('tanggal_dikembalikan')->nullable(); // admin/owner confirm
    
            $table->enum('status', [
                'diajukan',
                'ditolak',
                'dipinjam',
                'dikembalikan'
            ])->default('diajukan');
    
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
    
};
