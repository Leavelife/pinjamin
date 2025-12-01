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
            $table->unsignedBigInteger('user_id');

            $table->string('name');               // sebelumnya: nama
            $table->string('category');           // sebelumnya: kategori
            $table->text('description')->nullable(); // sebelumnya: deskripsi
            $table->string('pickup_address');     // sebelumnya: lokasi
            $table->integer('qty')->default(1);   // sebelumnya: jumlah
            $table->string('condition');          // sebelumnya: kondisi

            $table->string('photo');              // sebelumnya: gambar
            $table->string('status')->default('tersedia');

            $table->timestamps();
        });

    }
    
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
    
};
