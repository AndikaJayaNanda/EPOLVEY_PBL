@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-gray-100">
        <h1 class="text-2xl font-bold mb-4">{{ $survey->nama }}</h1>

        <form id="surveyForm" action="{{ route('mahasiswa.survey.submit', $survey->id) }}" method="POST">
            @csrf
            @if ($errors->any())
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach($survey->questions as $question)
                <div class="bg-white p-4 rounded-lg shadow mb-4">
                    <h2 class="font-semibold break-words relative">{{ $question->pertanyaan }}</h2> {{-- Tambahkan kelas break-words --}}
        
                    @if($question->jenis === 'pilihan')
                        @for($i = 1; $i <= 5; $i++)
                            <label class="block mt-2">
                                <input type="radio" name="answers[{{ $question->id }}][jawaban]" value="{{ $i }}" class="form-radio"
                                       onchange="saveAnswer({{ $question->id }}, this.value)"
                                       {{ isset($answers[$question->id]) && $answers[$question->id]->skor == $i ? 'checked' : '' }}>
                                <span class="ml-2">{{ $i }}:
                                    @if($i == 1) Sangat Tidak Puas
                                    @elseif($i == 2) Tidak Puas
                                    @elseif($i == 3) Cukup Puas
                                    @elseif($i == 4) Puas
                                    @elseif($i == 5) Sangat Puas
                                    @endif
                                </span>
                            </label>
                        @endfor
                    @elseif($question->jenis === 'essay')
                        <textarea name="answers[{{ $question->id }}][jawaban]" class="form-textarea mt-1 block w-full" rows="3"
                                  onchange="saveAnswer({{ $question->id }}, this.value)"
                                  placeholder="Tulis jawaban Anda di sini...">{{ isset($answers[$question->id]) ? $answers[$question->id]->jawaban : '' }}</textarea>
                    @endif
        
                    <!-- Pastikan untuk menyertakan question_id -->
                    <input type="hidden" name="answers[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                </div>
            @endforeach

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kirim Jawaban</button>
            </div>
        </form>
    </div>

    <script>
        // Simpan jawaban ke local storage
        function saveAnswer(questionId, answer) {
            let answers = JSON.parse(localStorage.getItem('surveyAnswers')) || {};
            answers[questionId] = { jawaban: answer };
            localStorage.setItem('surveyAnswers', JSON.stringify(answers));
        }

        // Ambil jawaban dari local storage saat halaman dimuat
        window.onload = function() {
            let answers = JSON.parse(localStorage.getItem('surveyAnswers')) || {};
            for (let questionId in answers) {
                let answer = answers[questionId].jawaban;
                let input = document.querySelector(`input[name="answers[${questionId}][jawaban]"][value="${answer}"]`);
                if (input) {
                    input.checked = true;
                } else {
                    let textarea = document.querySelector(`textarea[name="answers[${questionId}][jawaban]"]`);
                    if (textarea) {
                        textarea.value = answer;
                    }
                }
            }
        }
    </script>
@endsection
