<?php
namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        return view('dosen.dashboard');
    }
    public function result()
    {
        return view('dosen.result');
    }
    public function detail_result()
    {
        return view('dosen.detail_result');
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

}
