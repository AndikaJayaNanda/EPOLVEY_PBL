@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">

        <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full">
            <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Edit Mata Kuliah</h3>

            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Untuk mengindikasikan bahwa ini adalah permintaan update -->
                
                <div class="mb-4">
                    <label for="kode_matakuliah" class="block text-gray-700 font-semibold">Kode Matakuliah:</label>
                    <input type="text" name="kode_matakuliah" id="kode_matakuliah" value="{{ $jadwal->kode_matakuliah }}" required readonly class="mt-1 p-2 border rounded w-full" placeholder="Masukkan Kode Matakuliah">
                </div>

                <div class="mb-4">
                    <label for="nama_matakuliah" class="block text-gray-700 font-semibold">Nama Matakuliah:</label>
                    <input type="text" name="nama_matakuliah" id="nama_matakuliah" value="{{ $jadwal->nama_matakuliah }}" required readonly class="mt-1 p-2 border rounded w-full" placeholder="Masukkan Nama Matakuliah">
                </div>

                <div class="mb-4">
                    <label for="dosen_pengampu" class="block text-gray-700 font-semibold">Dosen Pengampu:</label>
                    <select name="dosen_pengampu" id="dosen_pengampu" required class="mt-1 p-2 border rounded w-full">
                        <option value="" disabled>Pilih Dosen</option>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->name }}" {{ $dosen->name == $jadwal->dosen_pengampu ? 'selected' : '' }}>
                                {{ $dosen->nama_dosen }} <!-- Menampilkan nama dosen -->
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="kelas" class="block text-gray-700 font-semibold">Kelas:</label>
                    <select name="kelas" id="kelas" required class="mt-1 p-2 border rounded w-full">
                        <option value="" disabled>Pilih Kelas</option>
                        @foreach (['A', 'B', 'C', 'D', 'E'] as $kelas)
                            <option value="{{ $kelas }}" {{ $kelas == $jadwal->kelas ? 'selected' : '' }}>
                                Kelas {{ $kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="text-white hover:bg-blue-800 bg-blue-600 px-4 md:px-6 py-2 rounded">Perbarui Mata Kuliah</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
