@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen p-4 md:p-6">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-6">Edit Mata Kuliah</h3>

        <!-- Form Edit Mata Kuliah -->
        <form action="{{ route('jadwal.updateByCode', ['kode_matakuliah' => $kode_matakuliah]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="semester" value="{{ $semester }}">
            
            <div class="mb-4">
                <label for="kode_matakuliah" class="block text-gray-700 font-semibold mb-2">Kode Matakuliah</label>
                <input type="text" name="kode_matakuliah" id="kode_matakuliah" value="{{ $kode_matakuliah }}"  class="w-full p-2 border rounded bg-gray-200">
            </div>

            <div class="mb-4">
                <label for="nama_matakuliah" class="block text-gray-700 font-semibold mb-2">Nama Matakuliah</label>
                <input type="text" name="nama_matakuliah" id="nama_matakuliah" value="{{ $nama_matakuliah }}" class="w-full p-2 border rounded" required>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center space-x-4">
                <button type="submit" class="text-white hover:bg-blue-800 bg-blue-600 px-4 py-2 rounded">Simpan Perubahan</button>
                <a href="{{ route('jadwal.manage', ['semester' => $semester]) }}" class="text-gray-700 hover:text-gray-900">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
