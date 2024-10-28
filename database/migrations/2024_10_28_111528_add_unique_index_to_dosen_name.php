<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIndexToDosenName extends Migration
{
    public function up()
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Menambahkan UNIQUE constraint pada kolom name
            $table->unique('name');
        });
    }

    public function down()
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Menghapus UNIQUE constraint
            $table->dropUnique(['name']);
        });
    }
}