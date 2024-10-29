<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'semester',
        'tahun',
        'status',
    ];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function questions_ikad()
    {
        return $this->hasMany(QuestionIkad::class);
    }
}
