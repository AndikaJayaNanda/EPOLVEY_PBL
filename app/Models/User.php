<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'is_logged_in',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_logged_in' => 'boolean', // Pastikan ini ada
    ];

    public function profilMahasiswa()
    {
        return $this->hasOne(ProfilMahasiswa::class, 'id_user');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'name', 'id'); // Pastikan parameter kedua sesuai dengan kolom foreign key
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role === 'Dosen') {
                Dosen::create([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
            }
        });

        static::updated(function ($user) {
            if ($user->role === 'Dosen') {
                Dosen::updateOrCreate(
                    ['name' => $user->name],
                    ['email' => $user->email]
                );
            }
        });

        static::deleting(function ($user) {
            if ($user->role === 'Dosen') {
                Dosen::where('name', $user->name)->delete();
            }
        });
    }
}
