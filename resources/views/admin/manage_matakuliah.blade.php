@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen p-4 md:p-6">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-6">Kelola Mata Kuliah</h3>

        <!-- Dropdown untuk Memilih Semester -->
        <form action="{{ route('jadwal.manage') }}" method="GET" class="mb-6">
            <label for="semester" class="text-gray-700 font-semibold mr-2">Pilih Semester:</label>
            <select name="semester" id="semester" onchange="this.form.submit()" class="p-2 border rounded">
                @foreach ($semesters as $sem)
                    <option value="{{ $sem }}" {{ $sem == $semester ? 'selected' : '' }}>
                        Semester {{ $sem }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Tabel Mata Kuliah -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-lg w-full">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 text-sm md:text-base">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600 border-b">Kode Matakuliah</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600 border-b">Nama Matakuliah</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwals as $jadwal)
                            <tr>
                                <td class="border-y border-l border-gray-300 p-3 md:p-5">{{ $jadwal->kode_matakuliah }}</td>
                                <td class="border-y border-l border-gray-300 p-3 md:p-5">{{ $jadwal->nama_matakuliah }}</td>
                                <td class="border-y border-l border-gray-300 p-3 md:p-5 space-x-2">
                                    <a href="{{ route('jadwal.editByCode', ['kode_matakuliah' => $jadwal->kode_matakuliah, 'semester' => $semester]) }}" class="text-white hover:bg-blue-800 bg-blue-600 px-4 md:px-6 py-1 rounded">Edit</a>
                                    <form action="{{ route('jadwal.destroyByCode', ['kode_matakuliah' => $jadwal->kode_matakuliah, 'semester' => $semester]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini beserta semua kelasnya?')" class="text-white hover:bg-red-800 bg-red-600 px-4 md:px-6 py-1 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
