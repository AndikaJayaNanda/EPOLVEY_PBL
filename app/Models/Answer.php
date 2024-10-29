<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'jawaban',
        'skor',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profileMahasiswa() // Ubah nama fungsi sesuai dengan relasi
    {
        return $this->belongsTo(ProfilMahasiswa::class, 'user_id'); // pastikan user_id adalah foreign key
    }
}
