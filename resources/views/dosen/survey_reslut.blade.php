@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 bg-blue-400 w-full h-20 rounded-xl flex justify-center items-center mb-4">
                    <h1 class="my-4 text-2xl font-bold text-white ">{{ $survey->nama }}</h1>
                </div>

                <div class="col-md-12">
                    @if (empty($data))
                        <div class="alert alert-warning text-center">
                            No responses found for this survey.
                        </div>
                    @else
                        <div class="table-responsive bg-white rounded-lg shadow p-4">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center align-middle border-r-2 border-slate-400 p-2 border-b-2">Matakuliah</th>
                                        @foreach (array_unique(array_merge(...array_column($data, 'questions'))) as $question)
                                            <th class="text-center align-middle px-3 border-r-2 border-slate-400 border-b-2">{{ $question }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $matakuliah => $info)
                                        <tr>
                                            <td class="text-center font-semibold align-middle">{{ $matakuliah }}</td>
                                            @foreach ($info['questions'] as $question)
                                                <td class="text-center align-middle">
                                                    @if (isset($info['responses'][$question]) && count($info['responses'][$question]) > 0)
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($info['responses'][$question] as $response)
                                                                <li>{{ $response }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-gray-500">No responses</span>
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
    </div>
</div>

@endsection
