<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Answer;


class AdminController extends Controller
{
    public function index()
    {
        $surveys = Survey::all(); // Fetch all surveys
        $totalMahasiswa = User::where('role', 'Mahasiswa')->count(); // Total students
        $totalSudahMengisi = Answer::distinct('user_id')->count('user_id'); // Total unique students who completed survey
    
        // Hitung mahasiswa yang belum mengisi survei
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
            ->paginate(6);
    
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
}
