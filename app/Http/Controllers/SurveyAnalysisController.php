<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyAnalysisController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua jenis survey untuk dropdown
        $surveyTypes = Survey::select('jenis')->distinct()->where('status', 'selesai')->get();
    
        // Jenis survei dipilih, default ke "IKAD" jika tidak ada pilihan
        $selectedType = $request->input('jenis', 'Kepuasa');
    
        // Filter survei sesuai jenis yang dipilih
        $surveys = Survey::with(['questions' => function ($query) {
            $query->where('jenis', 'pilihan');
        }])
        ->where('jenis', $selectedType)
        ->where('status', 'selesai')
        ->get();
    
        // Hitung rata-rata skor hanya untuk survei "IKAD"
        $chartData = $surveys->map(function ($survey) {
            $averageScore = $survey->questions->flatMap(function ($question) {
                return $question->answers->pluck('skor');
            })->avg();
    
            return [
                'judul' => $survey->nama,
                'tahun' => $survey->tahun,
                'average_score' => $averageScore ?: 0,
            ];
        });
    
        return view('admin.analys_survey', compact('surveyTypes', 'selectedType', 'chartData'));
    }
    

    public function fetchResponses(Request $request)
    {
        $surveyTitle = $request->query('survey');

        // Pastikan survei IKAD yang diambil
        $survey = Survey::where('nama', $surveyTitle)->where('jenis', 'IKAD')->first();

        if ($survey) {
            $questions = $survey->questions()->where('jenis', 'pilihan')->with('answers.profileMahasiswa')->get();

            $responses = [];

            foreach ($questions as $question) {
                foreach ($question->answers as $answer) {
                    $responses[$answer->user_id]['user_id'] = $answer->user_id;
                    $responses[$answer->user_id]['user_name'] = $answer->profileMahasiswa->nama ?? 'Anonymous';
                    $responses[$answer->user_id]['answers'][$question->id] = $answer->jawaban;
                }
            }

            return response()->json([
                'questions' => $questions,
                'responses' => array_values($responses),
            ]);
        }

        return response()->json(['questions' => [], 'responses' => []]);
    }
}
