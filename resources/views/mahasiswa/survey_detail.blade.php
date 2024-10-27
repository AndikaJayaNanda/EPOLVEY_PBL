@extends('layouts.app')

@section('content')

<body class="bg-gray-100">
    <div class="flex-1 p-6 mx-auto max-w-6xl h-screen">
        <h1 class="text-2xl font-bold text-gray-800 text-center font-poppins" data-aos="fade-up">Detail Survei</h1>

        <div class="mt-6 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold">{{ $survey->nama }}</h2>
            <p class="mt-2">Jenis: {{ $survey->jenis }}</p>
            <p class="mt-1">Semester: {{ $survey->semester }}</p>
            <p class="mt-1">Tahun: {{ $survey->tahun }}</p>
            <p class="mt-1">Status: {{ $survey->status }}</p>
        
            @if($survey->deskripsi)
                <h3 class="mt-4 text-lg font-semibold">Deskripsi</h3>
                <p>{{ $survey->deskripsi }}</p>
            @endif
        
            <div class="mt-4 text-center">
                <a href="{{ route('mahasiswa.survey.start', ['surveyId' => $survey->id, 'questionIndex' => 1]) }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Mulai Survei</a>
            </div>
        
            <div class="mt-4 text-center">
                <a href="{{ route('mahasiswa.dashboard') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kembali ke Daftar Survei</a>
            </div>
        </div>
        </div>
    </div>

    <!-- AOS JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init();
    </script>
</body>
</html>
@endsection
