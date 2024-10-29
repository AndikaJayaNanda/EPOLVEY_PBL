@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen bg-gray-100">
    <div class="min-h-screen p-6 md:ml-64 block">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
            <div class="p-8">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Edit Profil Mahasiswa</h2>
                <form action="{{ route('mahasiswa.update_profil', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $mahasiswa->name) }}"  class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $mahasiswa->email) }}" required class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Masukkan email Anda">
                        @error('email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                        <input id="jurusan" name="jurusan" type="text" value="Teknik Elektro" required readonly class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your major">
                    </div>

                    <div class="mb-6">
                        <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                        <input id="prodi" name="prodi" type="text" value="Teknik Informatika" required readonly class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your major">
                    </div>

                    <div class="mb-6">
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select id="semester" name="semester" required class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="1" {{ $mahasiswa->semester == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $mahasiswa->semester == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $mahasiswa->semester == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $mahasiswa->semester == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $mahasiswa->semester == '5' ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $mahasiswa->semester == '6' ? 'selected' : '' }}>6</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                        <select id="kelas" name="kelas" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="A" {{ $profil->kelas === 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ $profil->kelas === 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ $profil->kelas === 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ $profil->kelas === 'D' ? 'selected' : '' }}>D</option>
                            <option value="E" {{ $profil->kelas === 'E' ? 'selected' : '' }}>E</option>
                        </select>
                    </div>
                    

                    <div class="mb-6">
                        <label for="foto" class="block text-sm font-medium text-gray-700">Upload Foto Profil</label>
                        <input id="foto" name="foto" type="file" accept="image/*" onchange="validateFile()" class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <script>
                            function validateFile() {
                                const input = document.getElementById('foto');
                                const file = input.files[0];
                                if (file.size > 2048000) { // 2MB
                                    alert('File terlalu besar! Maksimal 2MB.');
                                    input.value = '';
                                }
                            }
                        </script>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
