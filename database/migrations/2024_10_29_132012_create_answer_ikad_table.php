<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerIkadTable extends Migration
{
    public function up()
    {
        Schema::create('answer_ikad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pertanyaan')->constrained('question_ikad')->onDelete('cascade');
            $table->enum('skor', ['1', '2', '3', '4', '5']);
            $table->longText('jawaban')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('answer_ikad');
    }
}
