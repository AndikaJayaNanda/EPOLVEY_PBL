<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKelasToProfilMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profil_mahasiswa', function (Blueprint $table) {
            $table->string('kelas')->nullable()->after('prodi'); // Menambahkan kolom kelas setelah kolom prodi
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profil_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('kelas'); // Menghapus kolom kelas jika migrasi dibatalkan
        });
    }
}
