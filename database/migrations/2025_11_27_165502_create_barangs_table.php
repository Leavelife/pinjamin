<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke pemilik (owner)
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade'); 
            
            // Informasi Barang
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            
            // Inventaris & Klasifikasi
            $table->string('kode_barang')->unique()->nullable(); 
            $table->integer('jumlah')->default(1); 
            $table->string('jenis')->nullable(); 
            $table->string('lokasi')->nullable();

            // Status Ketersediaan
            $table->string('status')->default('Tersedia'); // Tersedia, Dipinjam, Rusak

            $table->timestamps();
            $table->softDeletes(); // Untuk fitur soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};