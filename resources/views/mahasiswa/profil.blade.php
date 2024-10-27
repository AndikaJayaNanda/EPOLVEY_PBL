@extends('layouts.app')

@section('content')

    <div class="flex-1 p-6 mx-auto max-w-4xl">
        <h1 class="text-2xl font-bold text-gray-800 flex justify-center font-poppins mb-6">Profil Mahasiswa</h1>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold">{{ $mahasiswa->name }}</h2>
            <p class="mt-2">Email: {{ $mahasiswa->email }}</p>
            <p class="mt-1">Jurusan: {{ $mahasiswa->jurusan }}</p>
            <p class="mt-1">Prodi: {{ $mahasiswa->prodi }}</p>
            <p class="mt-1">Semester: {{ $mahasiswa->semester }}</p>
            
            <!-- Tampilkan foto jika ada -->
            <div class="mt-4">
                @if($mahasiswa->foto)
                    <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto Profil" class="rounded-full w-32 h-32 mx-auto">
                @else
                    <p>Tidak ada foto profil.</p>
                @endif
            </div>

            <!-- Tombol Edit -->
            <div class="mt-4 text-center">
                <a href="{{ route('mahasiswa.profil_edit', $mahasiswa->id) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit Profil</a>
            </div>
        </div>
    </div>

@endsection