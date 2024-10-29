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
        $surveyTypes = Survey::select('jenis')->distinct()->where('status', 'selesai')->get(); // Filter berdasarkan status 'selesai'

        // Ambil jenis survey dari request
        $selectedType = $request->input('jenis');

        // Jika ada jenis survey terpilih, ambil data sesuai dengan jenis tersebut
        if ($selectedType) {
            // Ambil survey yang sesuai dengan jenis survey yang dipilih dan status 'selesai'
            $surveys = Survey::with(['questions' => function ($query) {
                $query->where('jenis', 'pilihan'); // Filter berdasarkan jenis 'pilihan'
            }])->where('jenis', $selectedType)
              ->where('status', 'selesai') // Tambahkan filter status
              ->get();

            // Hitung rata-rata skor untuk setiap survey
            $chartData = $surveys->map(function ($survey) {
                $averageScore = $survey->questions->flatMap(function ($question) {
                    return $question->answers->pluck('skor'); // Ambil semua skor dari jawaban
                })->avg(); // Hitung rata-rata skor dari semua jawaban

                return [
                    'judul' => $survey->nama,
                    'tahun' => $survey->tahun,
                    'average_score' => $averageScore ?: 0, // Menghindari nilai null
                ];
            });
        } else {
            $chartData = collect(); // Jika belum ada yang dipilih, set data kosong
        }

        return view('admin.analys_survey', compact('surveyTypes', 'selectedType', 'chartData'));
    }

    public function fetchResponses(Request $request)
{
    $surveyTitle = $request->query('survey');

    $survey = Survey::where('nama', $surveyTitle)->first();

    if ($survey) {
        $questions = $survey->questions()->where('jenis', 'pilihan')->with('answers.profileMahasiswa')->get();

        $responses = [];

        foreach ($questions as $question) {
            foreach ($question->answers as $answer) {
                // Simpan jawaban berdasarkan user_id
                $responses[$answer->user_id]['user_id'] = $answer->user_id;
                $responses[$answer->user_id]['user_name'] = $answer->profileMahasiswa->nama; // Ambil nama dari profil_mahasiswa
                $responses[$answer->user_id]['answers'][$question->id] = $answer->jawaban;
            }
        }

        return response()->json([
            'questions' => $questions,
            'responses' => array_values($responses), // Mengubah array asosiatif ke array numerik
        ]);
    }

    return response()->json(['questions' => [], 'responses' => []]);
}


}
