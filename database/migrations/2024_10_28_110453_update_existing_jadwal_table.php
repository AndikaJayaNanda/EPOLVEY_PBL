<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExistingJadwalTable extends Migration
{
    public function up()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Hapus kolom jika ada
            if (Schema::hasColumn('jadwal', 'mata_kuliah')) {
                $table->dropColumn('mata_kuliah');
            }
            if (Schema::hasColumn('jadwal', 'id_dosen')) {
                $table->dropColumn('id_dosen');
            }
            if (Schema::hasColumn('jadwal', 'dosen_pengampu')) {
                $table->dropColumn('dosen_pengampu');
            }

            // Tambahkan kolom baru
            if (!Schema::hasColumn('jadwal', 'kode_matakuliah')) {
                $table->string('kode_matakuliah', 50)->after('id')->nullable(false);
            }
            if (!Schema::hasColumn('jadwal', 'nama_matakuliah')) {
                $table->string('nama_matakuliah', 255)->after('kode_matakuliah')->nullable(false);
            }
            if (!Schema::hasColumn('jadwal', 'name')) {
                $table->string('name')->nullable()->after('nama_matakuliah'); // Foreign key to `dosen` table
            }

            // Jika kolom name ada, tambahkan foreign key
            if (Schema::hasColumn('jadwal', 'name')) {
                $table->foreign('name')->references('name')->on('dosen')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Kembalikan perubahan jika di-rollback
            if (Schema::hasColumn('jadwal', 'name')) {
                $table->dropForeign(['name']);
                $table->dropColumn(['kode_matakuliah', 'nama_matakuliah', 'name']);
            }

            // Kembalikan kolom yang dihapus
            if (!Schema::hasColumn('jadwal', 'mata_kuliah')) {
                $table->string('mata_kuliah', 100)->nullable(false);
            }
            if (!Schema::hasColumn('jadwal', 'id_dosen')) {
                $table->bigInteger('id_dosen')->unsigned()->nullable(false);
            }
            if (!Schema::hasColumn('jadwal', 'dosen_pengampu')) {
                $table->string('dosen_pengampu', 100)->nullable(false);
            }

            // Tambahkan kembali foreign key untuk id_dosen jika diperlukan
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('cascade');
        });
    }
}
