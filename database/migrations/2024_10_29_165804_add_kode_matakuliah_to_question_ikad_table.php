<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        // Add foreign key constraint to question_ikad table
        Schema::table('question_ikad', function (Blueprint $table) {
            // Ensure the column type is compatible
            $table->string('kode_matakuliah', 50)->change(); // Adjust the type if needed
            
            $table->foreign('kode_matakuliah')
                  ->references('kode_matakuliah')
                  ->on('jadwal')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Remove foreign key constraint
        Schema::table('question_ikad', function (Blueprint $table) {
            $table->dropForeign(['kode_matakuliah']);
        });
    }
};
    