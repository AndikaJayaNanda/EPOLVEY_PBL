<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('jadwal', function (Blueprint $table) {
        $table->id();
        $table->enum('semester', ['1', '2', '3', '4', '5', '6']);
        $table->string('kelas', 50)->nullable();
        $table->string('mata_kuliah', 100);
        $table->unsignedBigInteger('id_dosen')->unique(); // Menggunakan name dari user sebagai foreign key
        $table->string('dosen_pengampu', 100);
        $table->foreign('id_dosen')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('jadwal');
}

};
