@extends('layouts.app')

@section('content')

<div class="flex flex-col h-screen">
    <div class="flex-1 p-6 md:ml-64">
        <h2 class="text-2xl font-bold mb-6">Edit Pertanyaan</h2>

        <form action="{{ route('admin.update_question', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <input type="text" name="pertanyaan" value="{{ $question->pertanyaan }}" placeholder="Pertanyaan" class="w-full p-2 border rounded mb-2" required>
                <select name="jenis_pertanyaan" class="w-full p-2 border rounded" required>
                    <option value="essay" {{ $question->jenis_pertanyaan == 'essay' ? 'selected' : '' }}>Essay</option>
                    <option value="pilihan" {{ $question->jenis_pertanyaan == 'pilihan' ? 'selected' : '' }}>Pilihan</option>
                </select>
            </div>

            <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded">Update Pertanyaan</button>
            <a href="{{ route('admin.add_question_ikad', $question->survey_id) }}" class="py-2 px-4 bg-gray-500 text-white rounded">Kembali</a>
        </form>
    </div>
</div>

@endsection
