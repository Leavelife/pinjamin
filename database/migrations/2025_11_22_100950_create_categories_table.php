<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insert kategori default
        DB::table('categories')->insert([
            ['name' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Buku', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pakaian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perabotan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mainan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lainnya', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
