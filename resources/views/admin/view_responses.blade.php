@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="container mx-auto p-4">
            <h2 class="text-xl font-semibold mb-4">Responses</h2>

            <!-- Tambahkan tombol untuk ekspor -->
            <a href="{{ route('responses.export', $surveyId) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Export to Excel</a>

            <!-- Tabel Respon untuk Pertanyaan Pilihan Ganda -->
            <h3 class="text-lg font-semibold mb-2">Responses (Pilihan Ganda)</h3>
            <table class="min-w-full bg-white border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-3 border-b">Name</th>
                        <th class="py-2 px-3 border-b">Nama Lengkap</th>
                        @foreach($questions as $question)
                            <th class="py-2 px-3 border-b">Pertanyaan {{ $question->id }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($scores as $userId => $userScore)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="border-b py-2 px-3">{{ $userScore['name'] }}</td>
                            <td class="border-b py-2 px-3">{{ $userScore['mahasiswa_name'] }}</td>
                            @foreach($questions as $question)
                                <td class="border-b py-2 px-3 text-center">
                                    @php
                                        // Mencari skor berdasarkan id pertanyaan
                                        $score = collect($userScore['scores'])->firstWhere('question_number', $question->id);
                                    @endphp
                                    {{ $score ? $score['score'] : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tabel Respon untuk Pertanyaan Esai -->
            <h3 class="text-lg font-semibold mb-2 mt-6">Responses (Esai)</h3>
            <table class="min-w-full bg-white border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-2 px-3 border-b">Name</th>
                        <th class="py-2 px-3 border-b">Nama Lengkap</th>
                        <th class="py-2 px-3 border-b">Respon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($essayResponses as $response)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="border-b py-2 px-3">{{ $response['name'] }}</td>
                            <td class="border-b py-2 px-3">{{ $response['mahasiswa_name'] }}</td>
                            <td class="border-b py-2 px-3">{{ $response['response'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection
