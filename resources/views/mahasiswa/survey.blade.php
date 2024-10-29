@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen ">
    <div class="min-h-screen p-6 md:ml-64 block">
      
    <div class="flex-1 p-6 mx-auto max-w-6xl h-screen">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 text-center font-poppins" data-aos="fade-up">SURVEY TERBARU</h1>
            <p class="text-center col-span-3">Tidak ada survei aktif saat ini.</p>
            <!-- Dynamic Slate background box with 3 grid columns -->
            <div class="mt-6 p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" data-aos="fade-up">
                    <!-- Grid item for each survey -->
                    <div class="bg-white p-4 shadow-md rounded-lg h-44 text-center grid items-end" data-aos="zoom-in">
                        <p class="text-gray-700 font-semibold"></p>
                        <p class="text-gray-500"></p>
                        <a href="" class="text-slate-800 font-bold font-poppins bg-yellow-400 rounded-md py-1 tracking-wide hover:bg-yellow-500 hover:text-white">View</a>
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
@endsection
