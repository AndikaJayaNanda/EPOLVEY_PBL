<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilMahasiswa extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan (jika tidak mengikuti konvensi)
    protected $table = 'profil_mahasiswa';

    // Menentukan kolom yang dapat diisi
    protected $fillable = [
        'id_user',
        'name',
        'email',
        'jurusan',
        'prodi',
        'semester',
        'foto',
        'kelas',
    ];

    // Menentukan kolom yang tidak dapat diisi
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // Menentukan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kelas', 'kelas');
    }
}
