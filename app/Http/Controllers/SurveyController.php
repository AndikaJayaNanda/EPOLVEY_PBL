<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\QuestionIkad; // Tambahkan ini
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function create()
    {
        $surveys = Survey::all();
        return view('admin.add_survey',compact('surveys'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:IKAD,Survey kepuasan,Jenis baru',
            'semester' => 'required|in:1,2,3,4,5,6',
            'tahun' => 'required|digits:4|integer',
            'status' => 'required|in:berlangsung,selesai',
        ]);

        // Simpan data survei
        $survey = Survey::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'semester' => $request->semester,
            'tahun' => $request->tahun,
            'status' => $request->status,
        ]);

        // Cek jika jenis survei adalah IKAD
        if ($survey->jenis == 'IKAD') {
            // Redirect ke route untuk menambah pertanyaan ke question_ikad
            return redirect()->route('admin.add_question_ikad', $survey->id)
                             ->with('success', 'Survey berhasil ditambahkan. Silakan tambahkan pertanyaan.');
        }

        return redirect()->route('admin.create_survey')->with('success', 'Survey berhasil ditambahkan');
    }

    public function edit(Survey $survey)
    {
        return view('admin.edit_survey', compact('survey'));
    }

    // Update survei
    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required',
            'semester' => 'required',
            'tahun' => 'required|digits:4',
            'status' => 'required',
        ]);

        $survey->update($request->all());

        return redirect()->route('admin.create_survey')->with('success', 'Survey updated successfully.');
    }

    // Delete survei
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('admin.create_survey')->with('success', 'Survey deleted successfully.');
    }

    public function addQuestionIkad($surveyId)
    {
        // Ambil survey berdasarkan ID
        $survey = Survey::findOrFail($surveyId);
        
        return view('admin.add_question_ikad', compact('survey'));
    }
    public function storeQuestionIkad(Request $request, $surveyId)
{
    $request->validate([
        'pertanyaan' => 'required|string|max:255',
        'jenis_pertanyaan' => 'required|in:pilihan,essay',
        'kode_matakuliah' => 'required|exists:jadwal,kode_matakuliah', // Sesuaikan dengan kolom yang ada
    ]);

    // Simpan pertanyaan IKAD ke database
    QuestionIkad::create([
        'survey_id' => $surveyId,
        'pertanyaan' => $request->pertanyaan,
        'jenis_pertanyaan' => $request->jenis_pertanyaan,
        'kode_matakuliah' => $request->kode_matakuliah,
    ]);

    return redirect()->route('admin.create_survey')->with('success', 'Pertanyaan berhasil ditambahkan');
}


}

