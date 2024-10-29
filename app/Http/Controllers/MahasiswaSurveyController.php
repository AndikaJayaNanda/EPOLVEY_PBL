<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerIkad;
use App\Models\ProfilMahasiswa;
use App\Models\QuestionIkad;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MahasiswaSurveyController extends Controller
{
    public function show($id)
    {
        $survey = Survey::findOrFail($id);
        $questions = $survey->questions; // Mengambil pertanyaan berdasarkan survey

        return view('mahasiswa.survey_detail', compact('survey', 'questions'));
    }

    public function answer($surveyId)
    {
        // Fetch the survey along with its associated questions
        $survey = Survey::with(['questions', 'questions_ikad.matakuliah'])->findOrFail($surveyId);
    
        // Get the logged-in user's profile
        $profilMahasiswa = ProfilMahasiswa::where('id_user', auth()->id())->first();
    
        // Initialize variables for answers and questions
        $questions = [];
        $answers = [];
    
        // Check if the survey type is IKAD
        if ($survey->jenis === 'IKAD') {
            // Filter IKAD questions based on the student's class
            $questionsIkad = $survey->questions_ikad()
                ->where('kelas', $profilMahasiswa->kelas)
                ->with('matakuliah') // Load the related matakuliah
                ->get()
                ->groupBy('pertanyaan'); // Group by the main question
    
            // Fetch answers for the IKAD questions
            $answers = Answer::where('user_id', auth()->id())
                             ->whereIn('question_id', $questionsIkad->pluck('id'))
                             ->get()
                             ->keyBy('question_id');
    
            // Return the view for IKAD surveys
            return view('mahasiswa.ikad_survey_answer', compact('survey', 'questionsIkad', 'answers'));
    
        } else {
            // For non-IKAD surveys, fetch all questions
            $questions = $survey->questions;
    
            // Fetch answers for the non-IKAD questions
            $answers = Answer::where('user_id', auth()->id())
                             ->whereIn('question_id', $questions->pluck('id'))
                             ->get()
                             ->keyBy('question_id'); // Change collection to key by question_id
    
            // Return the view for regular surveys
            return view('mahasiswa.answer', compact('survey', 'questions', 'answers'));
        }
    }
    
    

    public function submitSurvey(Request $request)
    {
        // Validasi jawaban
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.jawaban' => 'required_if:answers.*.jenis,essay', // Pastikan jawaban untuk essay tidak kosong
        ]);

        // Cek setiap jawaban
        foreach ($request->answers as $answer) {
            $questionId = $answer['question_id'];
            $jawaban = $answer['jawaban'];
            $question = QuestionIkad::findOrFail($questionId);

            // Proses penyimpanan jawaban
            if ($question->jenis === 'essay') {
                // Validasi minimal 20 kata untuk jawaban essay
                if (str_word_count($jawaban) < 20) {
                    return redirect()->back()->withErrors([
                        'answers.*.jawaban' => 'Jawaban harus terdiri dari minimal 20 kata.'
                    ])->withInput();
                }

                // Simpan jawaban essay
                AnswerIkad::updateOrCreate(
                    [
                        'question_id' => $questionId,
                        'user_id' => auth()->id(),
                    ],
                    [
                        'jawaban' => $jawaban,
                        'skor' => null, // Kosongkan skor untuk jawaban essay
                    ]
                );

            } elseif ($question->jenis === 'pilihan') {
                // Simpan nilai untuk jawaban pilihan
                AnswerIkad::updateOrCreate(
                    [
                        'question_id' => $questionId,
                        'user_id' => auth()->id(),
                    ],
                    [
                        'jawaban' => null, // Kosongkan jawaban untuk jawaban pilihan
                        'skor' => $jawaban, // Simpan nilai
                    ]
                );
            }
        }

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Jawaban survei berhasil disimpan!');
    }

    // Add a method to handle IKAD survey answers
    public function submitIkadSurvey(Request $request, $surveyId)
{
    $request->validate([
        'answers.*.id_pertanyaan' => 'required|exists:question_ikad,id',
        'answers.*.jawaban' => 'required',
    ]);

    foreach ($request->input('answers') as $answerData) {
        $existingAnswer = AnswerIkad::where('user_id', auth()->id())
                                    ->where('id_pertanyaan', $answerData['id_pertanyaan'])
                                    ->first();

        if ($existingAnswer) {
            $existingAnswer->update([
                'jawaban' => $answerData['jawaban'],
            ]);
        } else {
            AnswerIkad::create([
                'user_id' => auth()->id(),
                'id_pertanyaan' => $answerData['id_pertanyaan'],
                'jawaban' => $answerData['jawaban'],
            ]);
        }
    }

    return redirect()->route('mahasiswa.dashboard')
                     ->with('success', 'Jawaban Anda berhasil disimpan.');
}

}
