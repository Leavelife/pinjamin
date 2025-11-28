<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'study_program')) {
                $table->string('study_program')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'location')) {
                $table->string('location')->nullable()->after('study_program');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['study_program','location']);
        });
    }
}