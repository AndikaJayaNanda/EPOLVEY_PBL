<?php

namespace App\Exports;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResponsesExport implements FromView, WithHeadings
{
    protected $surveyId;

    public function __construct($surveyId)
    {
        $this->surveyId = $surveyId;
    }

    public function view(): View
    {
        // Fetch responses
        $responses = Answer::whereIn('question_id', function ($query) {
            $query->select('id')->from('questions')->where('survey_id', $this->surveyId);
        })
        ->with(['question.survey', 'user.profilMahasiswa'])
        ->get();

        $scores = [];
        $essayResponses = [];

        // Fetch questions for the survey
        $questions = Question::where('survey_id', $this->surveyId)->get();

        foreach ($responses as $response) {
            if ($response->question->jenis === 'essay') {
                $essayResponses[] = [
                    'name' => $response->user->name,
                    'mahasiswa_name' => $response->user->profilMahasiswa->name,
                    'response' => $response->jawaban,
                ];
            } else {
                $scores[$response->user_id]['name'] = $response->user->name;
                $scores[$response->user_id]['mahasiswa_name'] = $response->user->profilMahasiswa->name;
                $scores[$response->user_id]['scores'][$response->question->id] = $response->skor; // Store scores by question id
            }
        }

        // Prepare data for export
        $data = [];
        foreach ($scores as $userScore) {
            $row = [
                'name' => $userScore['name'],
                'mahasiswa_name' => $userScore['mahasiswa_name'],
            ];

            foreach ($questions as $question) {
                $row['question_' . $question->id] = $userScore['scores'][$question->id] ?? '-';
            }
            $data[] = $row;
        }

        // Add essay responses
        foreach ($essayResponses as $essayResponse) {
            $data[] = [
                'name' => $essayResponse['name'],
                'mahasiswa_name' => $essayResponse['mahasiswa_name'],
                'response' => $essayResponse['response'],
            ];
        }

        return view('exports.responses', [
            'data' => $data,
            'questions' => $questions,
            'headings' => $this->headings() // Pass the headings to the view
        ]);
    }

    public function headings(): array
    {
        // Define headings
        $headings = [
            'Name',
            'Nama Lengkap',
        ];

        // Add headings for each question
        foreach (Question::where('survey_id', $this->surveyId)->get() as $question) {
            $headings[] = 'Pertanyaan ' . $question->id;
        }

        // Add column for essay responses if needed
        $headings[] = 'Respon';

        return $headings;
    }
}