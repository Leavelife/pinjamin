<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Barang dan Peminjam
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade'); // Barang yang dipinjam
            $table->foreignId('peminjam_id')->constrained('users')->onDelete('cascade'); // User yang meminjam

            // Detail Transaksi
            $table->dateTime('tanggal_peminjaman')->nullable();
            $table->dateTime('tanggal_pengembalian_estimasi'); // Kapan harus dikembalikan
            $table->dateTime('tanggal_pengembalian_aktual')->nullable(); // Kapan dikembalikan sebenarnya
            
            // Status Peminjaman
            // 'Diajukan', 'Disetujui', 'Ditolak', 'Dipinjam', 'Selesai'
            $table->string('status')->default('Diajukan'); 

            $table->text('catatan')->nullable(); // Catatan tambahan
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};