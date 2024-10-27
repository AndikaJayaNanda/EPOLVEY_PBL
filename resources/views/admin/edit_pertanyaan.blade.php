@extends('layouts.app')

@section('content')

    <div class="flex flex-col h-screen">
        <div class="flex-1 p-6 md:ml-64">
            <h2 class="text-xl font-bold mb-4">Edit Pertanyaan</h2>

            @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.update_pertanyaan', $pertanyaan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="pertanyaan" class="block text-gray-700">Pertanyaan:</label>
                    <input type="text" name="pertanyaan" id="pertanyaan" value="{{ old('pertanyaan', $pertanyaan->pertanyaan) }}" class="mt-1 block w-full border border-gray-300 rounded p-2" required>
                    @error('pertanyaan')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="jenis" class="block text-gray-700">Jenis:</label>
                    <select name="jenis" id="jenis" class="mt-1 block w-full border border-gray-300 rounded p-2" required>
                        <option value="essay" {{ old('jenis', $pertanyaan->jenis) === 'essay' ? 'selected' : '' }}>Essay</option>
                        <option value="pilihan" {{ old('jenis', $pertanyaan->jenis) === 'pilihan' ? 'selected' : '' }}>Pilihan</option>
                    </select>
                    @error('jenis')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded">Update Pertanyaan</button>
                    <a href="{{ route('admin.pertanyaan', $pertanyaan->survey_id) }}" class="py-2 px-4 bg-gray-300 rounded">Batal</a>
                </div>
            </form>
        </div>
    </div>

@endsection
