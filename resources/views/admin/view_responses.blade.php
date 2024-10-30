@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="container mx-auto p-4"> 
            <h2 class="text-xl font-semibold mb-9">Responses</h2>
            <div class="flex justify-between">

            {{-- !-- Tabel Respon untuk Pertanyaan Pilihan Ganda --> --}}
            <h3 class="text-lg font-semibold">Responses (Pilihan Ganda)</h3>

            <!-- Tambahkan tombol untuk ekspor -->
            <a href="{{ route('responses.export', $surveyId) }}" class="bg-green-500   rounded mb-4 p-3 px-6 text-center text-white">Export All</a>
        </div>
            <table class="min-w-full bg-white border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        @foreach($questions as $question)
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan {{ $question->id }}</th>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Respon</th>
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
