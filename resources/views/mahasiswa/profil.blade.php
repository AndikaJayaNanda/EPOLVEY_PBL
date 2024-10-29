@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
    @vite('resources/css/app.css')

    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Icons -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="ml-[250px] min-h-screen py-8 px-6">
        <div class="max-w-2xl mx-auto text-center mb-12" data-aos="fade-down">
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 font-poppins">Profil Mahasiswa</h1>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-indigo-50 max-w-2xl mx-auto" data-aos="fade-up">
            <!-- Foto Profile Section -->
            <div class="mb-8 text-center">
                @if($mahasiswa->foto)
                    <div class="relative inline-block">
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-200 to-yellow-400 rounded-full blur-xl opacity-20"></div>
                        <img src="{{ asset('storage/images/foto_profil/' . $mahasiswa->foto) }}" 
                             alt="Foto Profil" 
                             class="relative rounded-full w-32 h-32 object-cover border-4 border-white shadow-md">
                    </div>
                @else
                    <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-r from-yellow-100 to-indigo-100 flex items-center justify-center">
                        <ion-icon name="person-circle-outline" class="text-4xl text-gray-400"></ion-icon>
                    </div>
                @endif
                <h2 class="mt-4 text-2xl font-bold text-gray-800">{{ $mahasiswa->name }}</h2>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 gap-4 mb-6">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                    <p class="text-blue-600 font-medium">Email</p>
                    <p class="text-gray-800">{{ $mahasiswa->email }}</p>
                </div>
                <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 p-4 rounded-xl border border-indigo-200">
                    <p class="text-indigo-600 font-medium">Jurusan</p>
                    <p class="text-gray-800">{{ $mahasiswa->jurusan }}</p>
                </div>
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-xl border border-purple-200">
                    <p class="text-purple-600 font-medium">Prodi</p>
                    <p class="text-gray-800">{{ $mahasiswa->prodi }}</p>
                </div>
                <div class="bg-gradient-to-r from-violet-50 to-violet-100 p-4 rounded-xl border border-violet-200">
                    <p class="text-violet-600 font-medium">Semester</p>
                    <p class="text-gray-800">{{ $mahasiswa->semester }}</p>
                </div>
                <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                    <p class="text-green-600 font-medium">Kelas</p>
                    <p class="text-gray-800">{{ $mahasiswa->kelas }}</p>
                </div>
            </div>


            <!-- Edit Button -->
            <div class="text-center">
                <a href="{{ route('mahasiswa.profil_edit', $mahasiswa->id) }}" 
                   class="inline-flex items-center px-5 py-2.5 rounded-xl text-white font-medium
                          bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 
                          transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                    <ion-icon name="create-outline" class="mr-2 text-lg"></ion-icon>
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- AOS JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });
    </script>
</body>
</html>
@endsection