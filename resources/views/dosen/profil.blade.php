@extends('layouts.app')

@section('content')
<div class="sm:ml-[250px] min-h-screen py-8 px-6">
    <div class="max-w-2xl mx-auto text-center mb-12" data-aos="fade-down">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Profil Dosen</h1>
        <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-indigo-50 max-w-2xl mx-auto" data-aos="fade-up">
        <div class="mb-8 text-center">
            @if($dosen->foto)
                <img src="{{ asset('storage/images/foto_profil/' . $dosen->foto) }}" 
                     alt="Foto Profil" 
                     class="relative rounded-full w-32 h-32 object-cover border-4 border-white shadow-md">
            @else
                <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-r from-yellow-100 to-indigo-100 flex items-center justify-center">
                    <ion-icon name="person-circle-outline" class="text-4xl text-gray-400"></ion-icon>
                </div>
            @endif
            <h2 class="mt-4 text-2xl font-bold text-gray-800">{{ $dosen->nama_dosen ?? 'Tidak Ada Data' }}</h2>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                <p class="text-blue-600 font-medium">Email</p>
                <p class="text-gray-800">{{ $dosen->email ?? 'Tidak Ada Data' }}</p>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ isset($dosen->id) ? route('dosen.edit', $dosen->id) : '' }}" 
               class="inline-flex items-center px-5 py-2.5 rounded-xl text-white font-medium 
                      bg-gradient-to-r from-yellow-400 to-yellow-500 
                      hover:from-yellow-500 hover:to-yellow-600 
                      transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg
                      {{ !isset($dosen->id) ? 'opacity-50 cursor-not-allowed' : '' }}">
                <ion-icon name="create-outline" class="mr-2 text-lg"></ion-icon>
                Edit Profil
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true
    });
</script>
@endsection
