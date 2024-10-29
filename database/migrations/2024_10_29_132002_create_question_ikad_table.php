<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionIkadTable extends Migration
{
    public function up()
    {
        Schema::create('question_ikad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
            $table->string('pertanyaan');
            $table->enum('jenis_pertanyaan', ['pilihan', 'essay']);
            $table->foreignId('kode_matakuliah')->constrained('jadwal')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('question_ikad');
    }
}
