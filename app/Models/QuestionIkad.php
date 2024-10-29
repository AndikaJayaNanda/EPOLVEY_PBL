<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionIkad extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'pertanyaan',
        'jenis_pertanyaan',
        'kode_matakuliah',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function kodeMatakuliah()
    {
        return $this->belongsTo(Jadwal::class, 'kode_matakuliah');
    }

    public function answers()
    {
        return $this->hasMany(AnswerIkad::class, 'id_pertanyaan');
    }
}
