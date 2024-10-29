@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">

<div class="container mx-auto">
    <h1 class="text-xl font-bold mb-4">Tambah Pertanyaan IKAD</h1>

    <form action="{{ route('admin.store_question_ikad', $survey->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="pertanyaan" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
            <textarea id="pertanyaan" name="pertanyaan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md" required></textarea>
        </div>

        <div class="mb-4">
            <label for="jenis_pertanyaan" class="block text-sm font-medium text-gray-700">Jenis Pertanyaan</label>
            <select id="jenis_pertanyaan" name="jenis_pertanyaan" class="mt-1 block w-full border-gray-300 rounded-md" required>
                <option value="pilihan">Pilihan</option>
                <option value="essay">Essay</option>
            </select>
        </div>

        <input type="hidden" name="kode_matakuliah" value="{{ old('kode_matakuliah') }}">

        <div class="mb-4">
            <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded">Simpan Pertanyaan</button>
        </div>
    </form>
</div>

@endsection
