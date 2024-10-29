{{-- resources/views/dosen/survey_reslut.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-9">
                <h1 class="my-4">Survey Results for: {{ $survey->title }}</h1>

                @if (empty($data))
                    <div class="alert alert-warning">
                        No responses found for this survey.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Matakuliah</th>
                                    @foreach (array_unique(array_merge(...array_column($data, 'questions'))) as $question)
                                        <th>{{ $question }}</th> {{-- Question as header --}}
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $matakuliah => $info)
                                    <tr>
                                        <td>{{ $matakuliah }}</td> {{-- Matakuliah name --}}
                                        @foreach ($info['questions'] as $question)
                                            <td>
                                                @if (isset($info['responses'][$question]))
                                                    @foreach ($info['responses'][$question] as $response)
                                                        <p>{{ $response }}</p> {{-- Displaying all responses for the question --}}
                                                    @endforeach
                                                @else
                                                    No responses
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
