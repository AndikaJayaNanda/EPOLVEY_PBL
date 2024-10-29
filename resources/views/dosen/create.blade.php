@extends('layouts.app')

@section('content')
<div class="ml-[250px] min-h-screen py-8 px-6">
    <div class="max-w-2xl mx-auto text-center mb-12" data-aos="fade-down">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Tambah Dosen</h1>
        <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
    </div>

    <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-lg border border-indigo-50 max-w-2xl mx-auto">
        @csrf
        <div class="mb-4">
            <label for="nama_dosen" class="block text-gray-700">Nama Dosen</label>
            <input type="text" name="nama_dosen" id="nama_dosen" class="mt-1 block w-full p-2 border rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full p-2 border rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="foto" class="block text-gray-700">Foto</label>
            <input type="file" name="foto" id="foto" class="mt-1 block w-full p-2 border rounded-md" accept="image/*">
        </div>
        <div class="text-center">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-xl text-white font-medium bg-gradient-to-r from-yellow-400 to-yellow-500">Tambah Dosen</button>
        </div>
    </form>
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
