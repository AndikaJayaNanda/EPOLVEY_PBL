@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="max-w-sm mx-auto bg-gray-800 text-white rounded-lg shadow-lg p-6 relative top-20">
            <!-- Edit Button -->
            <a href="{{ route('mahasiswa.profil_edit', $mahasiswa->id) }}" class="absolute top-10 right-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
                Edit
            </a>
        
            <!-- Profile Image -->
            <div class="w-24 h-24 rounded-full overflow-hidden mx-auto border-4 border-green-500 relative cursor-pointer">
                @if($mahasiswa->foto)
                    <img id="profileImage" src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <img id="profileImage" src="https://via.placeholder.com/150" alt="Foto Profil" class="w-full h-full object-cover">
                @endif
            </div>

            <!-- User Info -->
            <div class="text-center mt-4">
                <h2 class="text-2xl font-semibold">{{ $mahasiswa->name }}</h2>
                <p class="text-gray-400">{{ $mahasiswa->jurusan }}, {{ $mahasiswa->prodi }}</p>
            </div>
        
            <!-- Contact Information -->
            <div class="mt-6 space-y-2 text-center">
                <p><span class="font-bold">Email:</span> {{ $mahasiswa->email }}</p>
                <p><span class="font-bold">Semester:</span> {{ $mahasiswa->semester }}</p>
            </div>            
        </div>
    </div>
</div>

<script>
    function loadFile(event) {
        var image = document.getElementById('profileImage');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.onload = function() {
            URL.revokeObjectURL(image.src); // Free memory
        };
    }
</script>
@endsection
