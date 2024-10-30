@extends('layouts.app')
@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-6 md:ml-64 block">

        {{-- Dropdown Jenis Survey --}}
        <div class="mb-6">
            
            <select id="jenis-survey" class="form-select mt-1 block w-48 p-3 rounded-lg" onchange="window.location.href = '?jenis=' + this.value">
                <option value="">Pilih Jenis Survey</option>
                @foreach ($surveyTypes as $type)
                    <option value="{{ $type->jenis }}" {{ $selectedType == $type->jenis ? 'selected' : '' }}>{{ $type->jenis }}</option>
                @endforeach
            </select>
        </div>

        {{-- Grafik --}}
        <div x-data="app({{ json_encode($chartData) }})" x-cloak class="px-4">
            <div class="w-full max-w-4xl mx-auto py-10">
                <div class="shadow p-6 rounded-lg bg-white">
                    <div class="md:flex md:justify-between md:items-center">
                        <div>
                            <h2 class="text-xl text-gray-800 font-bold leading-tight">Analisis Rata-rata Skor Survey</h2>
                            <p class="mb-2 text-gray-600 text-sm">Rata-rata Skor Berdasarkan Survey (1-5)</p>
                        </div>
                    </div>
                    <div class="line my-8 relative">
                        <div class="flex -mx-2 items-end mb-2">
                            <template x-for="(data, index) in chartData" :key="index">
                                <div class="px-2 w-1/6">
                                    <div :style="`height: ${((data.average_score - 1) / 4) * 100}px`" 
                                         class="transition ease-in duration-200 bg-blue-600 hover:bg-blue-400 relative"
                                         @mouseenter="showTooltip($event, data)" 
                                         @mouseleave="hideTooltip()"
                                         @click="fetchResponses(data.judul)">
                                        <div x-text="data.average_score" 
                                             class="text-center absolute top-0 left-0 right-0 -mt-6 text-gray-800 text-sm"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="border-t border-gray-400 mx-auto" :style="`height: 1px; width: ${100 - 1/chartData.length*100 + 3}%`"></div>
                        <div class="flex -mx-2 items-end">
                            <template x-for="data in chartData" :key="data.judul">
                                <div class="px-2 w-1/6">
                                    <div class="text-center text-gray-700 text-sm" 
                                         x-text="data.judul + ' ' + data.tahun"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- Tabel Responden -->
                    <div class="mt-6" x-show="responses.length > 0">
                        <h3 class="text-lg font-semibold text-gray-800">Detail Responden</h3>
                        <table class="min-w-full leading-normal mt-4">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <template x-for="question in questions" :key="question.id">
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" x-text="question.pertanyaan"></th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="response in responses" :key="response.user_id">
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm" x-text="response.user_name"></td>
                                        <template x-for="question in questions" :key="question.id">
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm" x-text="response.answers[question.id]"></td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function app(chartData) {
        return {
            chartData: chartData,
            questions: [],
            responses: [],
            tooltipContent: '',
            tooltipOpen: false,
            showTooltip(e, data) {
                this.tooltipContent = data.average_score;
            },
            hideTooltip() {
                this.tooltipContent = '';
                this.tooltipOpen = false;
            },
            fetchResponses(surveyTitle) {
                // Fetch responses based on the survey title (use AJAX to get data)
                fetch(`/api/responses?survey=${surveyTitle}`)
                    .then(response => response.json())
                    .then(data => {
                        this.responses = data.responses; // set responses
                        this.questions = data.questions; // set questions
                    })
                    .catch(error => console.error('Error fetching responses:', error));
            },
        }
    }
</script>
@endsection
