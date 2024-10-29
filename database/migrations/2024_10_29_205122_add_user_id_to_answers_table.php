<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answer_ikad', function (Blueprint $table) {
            // Tambahkan kolom user_id
            $table->unsignedBigInteger('user_id')->after('id_pertanyaan');

            // Tambahkan foreign key untuk user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answer_ikad', function (Blueprint $table) {
            // Hapus foreign key
            $table->dropForeign(['user_id']);
            
            // Hapus kolom user_id
            $table->dropColumn('user_id');
        });
    }
}
