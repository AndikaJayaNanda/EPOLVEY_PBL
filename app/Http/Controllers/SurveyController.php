<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
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
    $survey = Survey::with('questions_ikad')->findOrFail($surveyId);
    return view('admin.add_question_ikad', compact('survey'));
}
public function storeQuestionIkad(Request $request, $surveyId)
{
    $survey = Survey::findOrFail($surveyId);

    $request->validate([
        'pertanyaan.*' => 'required|string|max:255',
        'jenis.*' => 'required|in:pilihan,essay',
    ]);

    // Dapatkan semua mata kuliah pada semester yang sama dengan survei
    $matakuliahs = Jadwal::where('semester', $survey->semester)->get();

    // Iterasi untuk setiap pertanyaan yang diinput
    foreach ($request->pertanyaan as $index => $pertanyaanText) {
        $jenisPertanyaan = $request->jenis[$index];

        foreach ($matakuliahs as $matakuliah) {
            // Simpan pertanyaan untuk setiap mata kuliah yang terkait
            QuestionIkad::create([
                'survey_id' => $surveyId,
                'pertanyaan' => $pertanyaanText,
                'jenis_pertanyaan' => $jenisPertanyaan,
                'kode_matakuliah' => $matakuliah->kode_matakuliah, // Sesuaikan field 'kode' sesuai tabel Anda
                'kelas' => $matakuliah->kelas, // Menambahkan kelas dari jadwal
            ]);
        }
    }

    return redirect()->route('admin.create_survey')->with('success', 'Pertanyaan berhasil ditambahkan ke semua mata kuliah pada semester tersebut.');
}

    public function editQuestion($id)
    {
        // Find the question by ID
        $question = QuestionIkad::findOrFail($id);
        return view('admin.edit_question_ikad', compact('question'));
    }
    
    public function updateQuestion(Request $request, $id)
{
    // Find the question by ID
    $question = QuestionIkad::findOrFail($id);

    // Validate the input
    $request->validate([
        'pertanyaan' => 'required|string|max:255',
        'jenis_pertanyaan' => 'required|in:pilihan,essay',
    ]);

    // Update all questions with the same text
    QuestionIkad::where('pertanyaan', $question->pertanyaan)->update([
        'pertanyaan' => $request->pertanyaan,
        'jenis_pertanyaan' => $request->jenis_pertanyaan,
    ]);

    return redirect()->route('admin.add_question_ikad', $question->survey_id)
                     ->with('success', 'Semua pertanyaan dengan teks yang sama telah diperbarui.');
}

    // In SurveyController.php

    public function deleteQuestion($id)
    {
        // Find the question by ID
        $question = QuestionIkad::findOrFail($id);
        
        // Store the survey ID to redirect after deletion
        $surveyId = $question->survey_id;
    
        // Delete all questions with the same text
        QuestionIkad::where('pertanyaan', $question->pertanyaan)->delete();
    
        return redirect()->route('admin.add_question_ikad', $surveyId)
                         ->with('success', 'Semua pertanyaan dengan teks yang sama telah dihapus.');
    }
    


}

