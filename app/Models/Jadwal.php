<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'kode_matakuliah',
        'nama_matakuliah',
        'name',
        'kelas',
        'semester'
    ];

    /**
     * Relasi dengan model Dosen.
     * Menghubungkan foreign key `name` di tabel `jadwal` dengan kolom `name` di tabel `dosen`.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'name', 'name');
    }
}