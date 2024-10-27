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
    ];

    // Jika Anda ingin mengonversi kolom tertentu
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function profilMahasiswa()
    {
        return $this->hasOne(ProfilMahasiswa::class, 'user_id');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role === 'Dosen') {
                Dosen::create([
                    'name' => $user->name,          // FK ke kolom name di users
                    'email' => $user->email,
                ]);
            }
        });

        static::updated(function ($user) {
            if ($user->role === 'Dosen') {
                Dosen::updateOrCreate(
                    ['name' => $user->name],
                    [
                        'email' => $user->email,
                    ]
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
