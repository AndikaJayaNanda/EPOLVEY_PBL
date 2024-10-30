@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">

        <!-- Dropdown untuk Memilih Semester -->
        
            

        <!-- Tombol Tambah Mata Kuliah -->
        <div class="mb-6 flex items-center space-x-4">
            <!-- Tombol Tambah Mata Kuliah -->
            <a href="{{ route('jadwal.create') }}" class="text-white hover:bg-blue-800 bg-blue-600 px-4 md:px-6 py-2 rounded">
                Tambah Mata Kuliah
            </a>
            
                <a href="{{ route('jadwal.manage') }}" class="text-white hover:bg-teal-800 bg-teal-600 px-4 md:px-6 py-2 rounded">
                    Kelola Mata Kuliah
                </a>
           
        
            <!-- Form Dropdown -->
            <form action="{{ route('admin.jadwal') }}" method="GET" class="flex items-center">
                <label for="semester" class="text-gray-700 font-semibold mr-2">Pilih Semester:</label>
                <select name="semester" id="semester" onchange="this.form.submit()" class="p-2 border rounded">
                    @foreach ($semesters as $sem)
                        <option value="{{ $sem }}" {{ $sem == $semester ? 'selected' : '' }}>
                            Semester {{ $sem }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        

        <!-- Tabel Jadwal Kuliah -->
        <div class="mt-6 md:mt-10 bg-white p-4 md:p-6 rounded-lg shadow-lg w-full">
            <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Jadwal Kuliah Semester {{ $semester }}</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white  text-sm md:text-base">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-slate-200 rounded-tl-lg">Kode Matakuliah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-slate-200">Nama Matakuliah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-slate-200">Dosen Pengampu</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-slate-200">Kelas</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-slate-200 rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwals->groupBy('kode_matakuliah') as $kode => $group)
                            @php
                                $firstJadwal = $group->first(); // Ambil data jadwal pertama untuk kode dan nama
                            @endphp
                            <tr>
                                <td class="p-3 md:p-5 " rowspan="{{ $group->count() }}">
                                    {{ $firstJadwal->kode_matakuliah }}
                                </td>
                                <td class="p-3 md:p-5 " rowspan="{{ $group->count() }}">
                                    {{ $firstJadwal->nama_matakuliah }}
                                </td>
                                
                                <td class=" p-3 md:p-5">{{ $firstJadwal->dosen ? $firstJadwal->dosen->nama_dosen : 'Tidak Ada' }}</td>
                                <td class=" p-3 md:p-5 ">{{ $firstJadwal->kelas }}</td>
                                <td class=" p-3 md:p-5">
                                    <a href="{{ route('jadwal.edit', $firstJadwal->id) }}" class="text-white hover:bg-blue-800 bg-blue-600 px-4 md:px-6 py-1 rounded">Edit</a>
                                </td>
                            </tr>
                            @foreach ($group->slice(1) as $jadwal) {{-- Loop untuk baris selanjutnya --}}
                                <tr>
                                    <td class=" p-3 md:p-5">{{ $jadwal->dosen ? $jadwal->dosen->nama_dosen : 'Tidak Ada' }}</td>
                                    <td class=" p-3 md:p-5">{{ $jadwal->kelas }}</td>
                                    <td class=" p-3 md:p-5">
                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="text-white hover:bg-blue-800 bg-blue-600 px-4 md:px-6 py-1 rounded">Edit</a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>

@endsection
