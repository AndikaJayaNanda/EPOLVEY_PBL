<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'name',           // FK dari users
        'nama_dosen',
        'email',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'name');
    }
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'name', 'name');
    }
}
