<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKelasToQuestionIkadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_ikad', function (Blueprint $table) {
            // Ensure the referenced column has an index
            $table->foreign('kelas')->references('kelas')->on('jadwal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_ikad', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['kelas']);
        });
    }
}
