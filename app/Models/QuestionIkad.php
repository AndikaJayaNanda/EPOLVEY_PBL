<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionIkad extends Model
{
    use HasFactory;
    protected $table = 'question_ikad';

    protected $fillable = [
        'survey_id',
        'pertanyaan',
        'jenis_pertanyaan',
        'kode_matakuliah',
        'kelas',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function matakuliah()
    {
        return $this->belongsTo(Jadwal::class, 'kode_matakuliah', 'kode_matakuliah');
    }

    public function answersikad()
    {
        return $this->hasMany(AnswerIkad::class, 'id_pertanyaan');
    }
}
