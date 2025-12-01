<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prodi')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('foto_profile')->nullable(); // path foto
            $table->enum('role', ['user', 'admin'])->default('user');
        });
    }
    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prodi', 'no_hp', 'foto_profile', 'role']);
        });
    }
    
};
