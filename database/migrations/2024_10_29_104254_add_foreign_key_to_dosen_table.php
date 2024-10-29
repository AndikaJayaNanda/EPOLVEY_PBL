<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToDosenTable extends Migration
{
    public function up()
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Adding the foreign key constraint
            $table->foreign('name')
                  ->references('name')
                  ->on('users')
                  ->onDelete('cascade'); // Optional: specify what happens on delete
        });
    }

    public function down()
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Dropping the foreign key constraint
            $table->dropForeign(['name']);
        });
    }
}
