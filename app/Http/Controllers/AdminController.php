<?php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $surveys = Survey::all(); // Atau gunakan Survey::paginate() jika datanya banyak

        // Kirim data ke view dashboard.blade.php
        return view('admin.dashboard', compact('surveys'));
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
    public function manage_accounts()
    {
        $profils = User::leftJoin('profil_mahasiswa', 'users.id', '=', 'profil_mahasiswa.id_user')
        ->leftJoin('dosen', 'users.name', '=', 'dosen.name')
        ->select(
            'users.id',
            'users.role',
            'users.name as username', // username dari tabel users
            'profil_mahasiswa.name as mahasiswa_name', // nama lengkap mahasiswa
            'dosen.nama_dosen as dosen_name' // nama lengkap dosen
        )
        ->paginate(10);

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
        return view('admin.profil'); 
    }
    public function jadwal()
    {
        return view('admin.jadwal'); 
    }
}
