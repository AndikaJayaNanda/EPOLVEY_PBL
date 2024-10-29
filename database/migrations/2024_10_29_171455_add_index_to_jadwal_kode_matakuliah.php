<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Add an index to kode_matakuliah if it doesn't exist
            $table->index('kode_matakuliah'); // Ensure you have an index
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Remove the index if rolling back
            $table->dropIndex(['kode_matakuliah']);
        });
    }
};
