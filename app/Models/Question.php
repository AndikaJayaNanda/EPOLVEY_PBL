<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'pertanyaan',
        'jenis',
    ];

    // Relasi ke Survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relasi ke Answers (jika diperlukan)
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}

?>