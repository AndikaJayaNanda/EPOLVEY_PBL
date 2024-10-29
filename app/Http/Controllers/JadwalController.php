<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal; // Pastikan model Jadwal diimport
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $semester = $request->input('semester', '1');
        $semesters = range(1, 6);
    
        // Mengambil jadwal berdasarkan semester yang dipilih
        $jadwals = Jadwal::where('semester', $semester)
            ->with('dosen') // Menyertakan relasi dosen
            ->get();
    
        return view('admin.jadwal', compact('jadwals', 'semesters', 'semester'));
    }

    public function create(Request $request)
    {
        $semester = $request->input('semester', '1'); // Default ke semester 1 jika tidak ada input
        $semesters = range(1, 6); // Daftar semester dari 1 hingga 6
    
        return view('admin.add_matakuliah', compact('semester', 'semesters'));
    }

    public function store(Request $request)
    {
        // Tambahkan validasi untuk memeriksa apakah kode_matakuliah sudah ada
        $validated = $request->validate([
            'kode_matakuliah' => 'required|string|unique:jadwal,kode_matakuliah', // Pastikan kode tidak duplikat
            'nama_matakuliah' => 'required|string',
            'total_kelas' => 'required|integer|min:1|max:10',
            'semester' => 'required|integer|in:1,2,3,4,5,6', // Pastikan semester valid
        ]);
    
        // Simpan mata kuliah sesuai jumlah kelas yang diinginkan
        for ($i = 0; $i < $validated['total_kelas']; $i++) {
            $kelas = chr(65 + $i); // Menghasilkan huruf A, B, C, ...
            Jadwal::create([
                'kode_matakuliah' => $validated['kode_matakuliah'],
                'nama_matakuliah' => $validated['nama_matakuliah'],
                'dosen_pengampu' => null, // Dosen pengampu kosong
                'kelas' => $kelas,
                'semester' => $validated['semester'],
            ]);
        }
    
        // Redirect ke halaman jadwal dengan semester yang dipilih
        return redirect()->route('admin.jadwal', ['semester' => $validated['semester']])
                         ->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id); // Ambil data berdasarkan ID
        $dosens = Dosen::all(); // Ambil semua data dosen
        $semester = $jadwal->semester; // Ambil semester dari jadwal yang sedang diedit
        return view('admin.edit_matakuliah', compact('jadwal', 'dosens', 'semester'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari request
        $request->validate([
            'kode_matakuliah' => 'required|string|max:50',
            'nama_matakuliah' => 'required|string|max:255',
            'dosen_pengampu' => 'required|string', // NIP
            'kelas' => 'required|string|max:1',

        ]);

        // Mencari jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($id);
        
        // Mengupdate data jadwal
        $jadwal->kode_matakuliah = $request->kode_matakuliah;
        $jadwal->nama_matakuliah = $request->nama_matakuliah;
        $jadwal->name = $request->dosen_pengampu; // Simpan NIP
        $jadwal->kelas = $request->kelas;
        $jadwal->save();

        // Redirect ke halaman jadwal dengan semester yang dipilih dan pesan sukses
        return redirect()->route('admin.jadwal', ['semester' => $request->semester])
                        ->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari jadwal berdasarkan ID dan hapus
        $jadwal = Jadwal::findOrFail($id);  
        $jadwal->delete();

        // Redirect kembali ke halaman jadwal dengan pesan sukses
        return redirect()->route('admin.jadwal', ['semester' => $jadwal->semester])
                        ->with('success', 'Mata kuliah berhasil dihapus!');
    }
    public function manage(Request $request)
    {
    $semester = $request->input('semester', '1');
    $semesters = range(1, 6);

    // Ambil mata kuliah per kode, hanya pada semester yang dipilih
    $jadwals = Jadwal::where('semester', $semester)
        ->select('kode_matakuliah', 'nama_matakuliah')
        ->groupBy('kode_matakuliah', 'nama_matakuliah')
        ->get();

    return view('admin.manage_matakuliah', compact('jadwals', 'semesters', 'semester'));
    }
    public function editByCode($kode_matakuliah, Request $request)
    {
        $semester = $request->input('semester');
        $jadwals = Jadwal::where('kode_matakuliah', $kode_matakuliah)
                        ->where('semester', $semester)
                        ->get();
        $dosens = Dosen::all();
        $nama_matakuliah = $jadwals->first()->nama_matakuliah;

        return view('admin.edit_matakuliah2', compact('jadwals', 'dosens', 'kode_matakuliah', 'nama_matakuliah', 'semester'));
    }

    public function updateByCode(Request $request, $kode_matakuliah)
    {
        $semester = $request->input('semester');
        $request->validate([
            'kode_matakuliah' => 'required|string|max:255',
            'nama_matakuliah' => 'required|string|max:255',
        ]);

        Jadwal::where('kode_matakuliah', $kode_matakuliah)
            ->where('semester', $semester)
            ->update([
                'nama_matakuliah' => $request->nama_matakuliah,

            ]);

        return redirect()->route('jadwal.manage', ['semester' => $semester])
                        ->with('success', 'Mata kuliah berhasil diperbarui untuk semua kelas di semester tersebut!');
    }

    public function destroyByCode($kode_matakuliah, Request $request)
    {
        $semester = $request->input('semester');

        Jadwal::where('kode_matakuliah', $kode_matakuliah)
            ->where('semester', $semester)
            ->delete();

        return redirect()->route('jadwal.manage', ['semester' => $semester])
                        ->with('success', 'Mata kuliah beserta semua kelasnya berhasil dihapus pada semester ini!');
    }


}
