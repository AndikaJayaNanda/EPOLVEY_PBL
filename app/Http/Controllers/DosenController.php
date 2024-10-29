<?php
namespace App\Http\Controllers;

use App\Models\AnswerIkad;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\QuestionIkad;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        return view('dosen.dashboard');
    }
    public function result()
    {
        $surveys = Survey::where('jenis', 'IKAD')->get();
        return view('dosen.results', compact('surveys'));
    }

    
    public function profil()
{
    // Attempt to find the logged-in dosen by their ID
    $dosen = Dosen::where('name', auth()->user()->name)->first();

    // If not found, create a new instance for the view
    if (!$dosen) {
        $dosen = new Dosen(); // Create a new instance to avoid null errors
        $dosen->foto = null; // Set default values as needed
        $dosen->nama_dosen = "Tidak Ada Data";
        $dosen->email = "Tidak Ada Data";
        // Add other default values if needed
    }

    return view('dosen.profil', compact('dosen'));
}


public function edit($id)
{
    // Retrieve the dosen by ID
    $dosen = Dosen::findOrFail($id);
    return view('dosen.edit', compact('dosen'));
}

public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'nama_dosen' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the max size as needed
    ]);

    $dosen = Dosen::findOrFail($id);
    $dosen->nama_dosen = $request->nama_dosen;
    $dosen->email = $request->email;

    // Handle the photo upload
    if ($request->hasFile('foto')) {
        // Delete old photo if exists
        if ($dosen->foto) {
            Storage::delete('public/images/foto_profil/' . $dosen->foto);
        }

        // Generate a new filename based on the Dosen's name
        $fileName = str_replace(' ', '_', strtolower($dosen->nama_dosen)) . '.' . $request->foto->extension();

        // Store the new photo with the new filename
        $request->foto->storeAs('public/images/foto_profil', $fileName);
        $dosen->foto = $fileName;
    }

    $dosen->save();

    return redirect()->route('dosen.profil')->with('success', 'Profil berhasil diperbarui.');
}

public function showSurveyResults($surveyId)
{
    // Fetch the survey
    $survey = Survey::findOrFail($surveyId);

    // Get the logged-in lecturer's subjects (matakuliah)
    $matakuliahs = Jadwal::where('name', auth()->user()->name)->pluck('kode_matakuliah');

    // Fetch the answers from students that are in the classes taught by the lecturer
    $answers = AnswerIkad::with('questionikad') // Include the question model
        ->whereIn('id_pertanyaan', function($query) use ($matakuliahs) {
            $query->select('id')
                  ->from('question_ikad')
                  ->whereIn('kode_matakuliah', $matakuliahs);
        })
        ->whereHas('questionikad', function($query) use ($surveyId) {
            $query->where('survey_id', $surveyId);
        })
        ->get();

    // Transform the answers into a pivot format
    $data = $this->processPivotData($answers);

    return view('dosen.survey_reslut', compact('survey', 'data'));
}

private function processPivotData($answers)
{
    $pivotData = [];

    foreach ($answers as $answer) {
        $matakuliah = $answer->questionikad->kode_matakuliah;
        $pertanyaan = $answer->questionikad->pertanyaan;

        // Initialize the row for this matakuliah if not already set
        if (!isset($pivotData[$matakuliah])) {
            $pivotData[$matakuliah] = [
                'questions' => [],
                'responses' => []
            ];
        }

        // Add the question and response
        if (!in_array($pertanyaan, $pivotData[$matakuliah]['questions'])) {
            $pivotData[$matakuliah]['questions'][] = $pertanyaan;
        }

        $pivotData[$matakuliah]['responses'][$pertanyaan][] = $answer->jawaban ?? 'No answer provided';
    }

    return $pivotData;
}


}
