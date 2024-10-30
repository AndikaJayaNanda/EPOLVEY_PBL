@extends('layouts.app')
@section('content')

    <div class="flex flex-col h-screen">

        <!-- Main content -->
        <div class="flex-1 p-4 md:p-6 md:ml-64">
            <div class="mb-4">
                <a href="{{ route('admin.add_survey') }}">
                    <button class="py-2 px-4 bg-green-500 text-white rounded w-full md:w-auto">
                        Create Survey
                    </button>
                </a>
            </div>

            <div class="bg-white p-10 rounded-lg drop-shadow-lg">
                <div class="overflow-x-auto bg-white rounded-lg">
                    <table id="studentTable" class="min-w-full bg-white ">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Survey</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ">Last Submit</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">View</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surveys as $survey)
                                <tr>
                                    <td class=" p-4 px-4 py-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                                    <td class=" p-4 px-4 py-4 border-b border-gray-200">{{ $survey->nama }}</td>
                                    <td class=" p-4 px-4 py-4 border-b border-gray-200 ">{{ $survey->updated_at->format('d M Y') }}</td>
                                    <td class=" p-2 px-4 py-4 border-b border-gray-200"">
                                        @if($survey->jenis == 'IKAD')
                                            <a href="{{ route('admin.add_question_ikad', $survey->id) }}">
                                                <button class="py-1 px-3 bg-blue-500 text-white rounded ">Tambah Pertanyaan IKAD</button>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.pertanyaan', $survey->id) }}">
                                                <button class="py-1 px-3 bg-blue-500 text-white rounded">Tambah Pertanyaan</button>
                                            </a>
                                        @endif
                                    </td>
                                    <td class=" p-2 px-4 py-4 border-b border-gray-200"">
                                        <a href="{{ route('admin.edit_survey', $survey->id) }}">
                                            <button class="py-1 px-3 bg-green-500 text-white rounded">
                                                <ion-icon name="create-outline"></ion-icon>Edit
                                            </button>
                                        </a>
                                        <form action="{{ route('admin.delete_survey', $survey->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="py-1 px-3 bg-red-500 text-white rounded">
                                                <ion-icon name="close-outline"></ion-icon>Delete
                                            </button>
                                        </form>
                                    </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
           
        </div>
    </div>

@endsection
