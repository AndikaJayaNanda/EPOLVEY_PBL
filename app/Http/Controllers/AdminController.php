<?php
namespace App\Http\Controllers;

use App\Exports\ResponsesExport;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{

    public function index()
    {
        $surveys = Survey::all(); // Ambil semua survei
        $totalMahasiswa = User::where('role', 'Mahasiswa')->count(); // Total mahasiswa

        // Hitung total mahasiswa yang sudah mengisi survei aktif
        $totalSudahMengisi = Answer::whereIn('question_id', function ($query) {
                $query->select('id')
                    ->from('questions')
                    ->whereIn('survey_id', Survey::where('status', 'berlangsung')->pluck('id'));
            })
            ->distinct('user_id')
            ->count('user_id');

        // Hitung mahasiswa yang belum mengisi survei aktif
        $totalBelumMengisi = $totalMahasiswa - $totalSudahMengisi;

        // Kirim data ke tampilan dashboard
        return view('admin.dashboard', compact('surveys', 'totalMahasiswa', 'totalSudahMengisi', 'totalBelumMengisi'));
    }
    
    
    public function create_survey()
    {
        $surveys = Survey::all();
        return view('admin.create_survey', compact('surveys')); 
    }
    public function analys_survey()
    {
        return view('admin.analys_survey'); 
    }
    public function manage_accounts(Request $request)
    {
        $sortOrder = $request->input('sort') === 'oldest_update' ? 'asc' : 'desc';
    
        $profils = User::leftJoin('profil_mahasiswa', 'users.id', '=', 'profil_mahasiswa.id_user')
            ->leftJoin('dosen', 'users.name', '=', 'dosen.name')
            ->select(
                'users.id',
                'users.role',
                'users.name as username',
                'profil_mahasiswa.name as mahasiswa_name',
                'dosen.nama_dosen as dosen_name',
                'users.updated_at'
            )
            ->orderBy('users.updated_at', $sortOrder)
            ->get();
    
        return view('admin.manage_accounts', compact('profils'));
    }
    
    public function add_survey()
    {
        return view('admin.add_survey'); 
    }
    public function result_survey()
    {
        return view('admin.result_survey'); 
    }
    public function profil()
    {
        // Tarik data admin dari tabel users berdasarkan role
        $admin = User::where('role', 'Admin')->first();

        // Pastikan data ditemukan sebelum mengirim ke view
        if (!$admin) {
            abort(404, 'Admin profile not found.');
        }

        return view('admin.profil', compact('admin'));
    }
    
    public function jadwal()
    {
        return view('admin.jadwal'); 
    }

    public function viewResponses($surveyId)
{
    // Existing logic to fetch responses
    $responses = Answer::whereIn('question_id', function ($query) use ($surveyId) {
            $query->select('id')->from('questions')->where('survey_id', $surveyId);
        })
        ->with(['question.survey', 'user.profilMahasiswa'])
        ->get();

    $scores = [];
    $essayResponses = [];

    $questions = Question::where('survey_id', $surveyId)
                        ->where('jenis', 'pilihan')
                        ->get();

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
            $scores[$response->user_id]['scores'][] = [
                'question_number' => $response->question->id,
                'score' => $response->skor,
            ];
        }
    }

    // Pass the surveyId to the view
    return view('admin.view_responses', compact('scores', 'essayResponses', 'questions', 'surveyId'));
}

public function exportResponses($surveyId)
{
    return Excel::download(new ResponsesExport($surveyId), 'responses.xlsx');
}

}
