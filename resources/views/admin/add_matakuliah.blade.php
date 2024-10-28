@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4">Tambah Mata Kuliah</h2>

        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            @if ($errors->any())
                <div class="bg-red-500 text-white p-2 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label for="kode_matakuliah" class="block text-gray-700">Kode Matakuliah:</label>
                <input type="text" name="kode_matakuliah" id="kode_matakuliah" class="mt-1 p-2 border rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="nama_matakuliah" class="block text-gray-700">Nama Matakuliah:</label>
                <input type="text" name="nama_matakuliah" id="nama_matakuliah" class="mt-1 p-2 border rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="total_kelas" class="block text-gray-700">Jumlah Kelas (1-10):</label>
                <input type="number" name="total_kelas" id="total_kelas" min="1" max="10" class="mt-1 p-2 border rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="semester" class="block text-gray-700">Semester:</label>
                <select name="semester" id="semester" class="mt-1 p-2 border rounded w-full" required>
                    @foreach ($semesters as $sem)
                        <option value="{{ $sem }}">Semester {{ $sem }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Tambah Jadwal</button>
        </form>
    </div>
</div>

@endsection
