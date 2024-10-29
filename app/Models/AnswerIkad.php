<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerIkad extends Model
{
    use HasFactory;
    protected $table = 'answer_ikad';

    protected $fillable = [
        'id_pertanyaan',
        'user_id',
        'skor',
        'jawaban',
    ];

    public function questionIkad()
    {
        return $this->belongsTo(QuestionIkad::class, 'id_pertanyaan', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Assuming you have a User model
    }
}
