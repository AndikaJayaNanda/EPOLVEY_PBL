@extends('layouts.app')

@section('content')
<div class="sm:ml-[250px] min-h-screen py-8 px-6">
    <!-- Welcome Section -->
    <div class="flex items-center justify-center mb-12 ">
        <div class="text-center max-w-md p-6 ">
            <!-- Illustration Placeholder -->
            <div class="flex justify-center mb-6">

                <img src="{{ asset('images/undraw.png') }}" alt="Illustration" class="max-w-full h-auto">


    
            </div>
            
            <!-- Welcome Text -->
            <h2 class="text-2xl font-bold mb-2">Selamat datang, {{ $dosen->nama_dosen }}!</h2>
            <p class="text-gray-700 mb-4">
                Anda dapat melihat hasil survei mahasiswa dan mendapatkan wawasan tentang pandangan mereka.
                Kami menghargai partisipasi Anda dalam mendukung peningkatan kualitas pendidikan di kampus.
            </p>

            <!-- Button -->
            <a href="{{ route('dosen.result') }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">
                Lihat Hasil Survey
            </a>
        </div>
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
