<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerIkad extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pertanyaan',
        'skor',
        'jawaban',
    ];

    public function question()
    {
        return $this->belongsTo(QuestionIkad::class, 'id_pertanyaan');
    }
}
