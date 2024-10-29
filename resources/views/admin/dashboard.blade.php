@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">

        <!-- Data Boxes Section -->
        <div class="bg-gray-100 flex items-start justify-center p-4 md:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 w-full max-w-7xl">

                <!-- Box 1 -->
                <div class="bg-white shadow-lg rounded-lg p-4 md:p-6">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-2 md:mb-4">Total Mahasiswa</h3>
                    <p class="text-2xl md:text-3xl font-bold text-blue-600">{{ $totalMahasiswa }}</p>
                    <div class="mt-1 md:mt-2 text-xs md:text-sm text-gray-500">Data Update {{ now()->format('d-m-Y') }}</div>
                </div>

                
                <!-- Box 2: Survey Yang Sudah Diisi -->
                <div class="bg-white shadow-lg rounded-lg p-4 md:p-6">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-2 md:mb-4">Yang Sudah Mengisi</h3>
                    <p class="text-2xl md:text-3xl font-bold text-green-500">{{ $totalSudahMengisi }}</p>
                    <div class="mt-1 md:mt-2 text-xs md:text-sm text-gray-500">Dari {{ $totalMahasiswa }} total Mahasiswa</div>
                </div>



                <!-- Box 3: Survey Yang Belum Diisi -->
                <div class="bg-white shadow-lg rounded-lg p-4 md:p-6">
                    <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-2 md:mb-4">Yang Belum Mengisi</h3>
                    <p class="text-2xl md:text-3xl font-bold text-red-500">{{ $totalBelumMengisi }}</p>
                    <div class="mt-1 md:mt-2 text-xs md:text-sm text-gray-500">Dari {{ $totalMahasiswa }} total Mahasiswa</div>
                </div>


            </div>
        </div>

        <!-- Survey Table Section (Reduced Spacing) -->
        <div class="mt-6 md:mt-10 bg-white p-4 md:p-6 rounded-lg shadow-lg w-full">
            <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-3 md:mb-4">Survey Status</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 text-sm md:text-base">
                    <thead>
                        <tr>
                            <th class="py-2 px-3 md:px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600">No</th>
                            <th class="py-2 px-3 md:px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600">Nama Survey</th>
                            <th class="py-2 px-3 md:px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600">Tanggal Rilis</th>
                            <th class="py-2 px-3 md:px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600">Status</th>
                            <th class="py-2 px-3 md:px-4 bg-gray-200 text-left text-xs md:text-sm font-medium text-gray-600"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surveys as $survey)
                        <tr>
                            <td class="p-3 md:p-5 border-y">{{ $loop->iteration }}</td>
                            <td class="border-y p-3 md:p-5">{{ $survey->nama }}</td>
                            <td class="border-y p-3 md:p-5">{{ $survey->updated_at->format('d M Y') }}</td>
                            <td class="py-2 px-3 md:px-4 border-b">
                                @if($survey->status == 'berlangsung')
                                    <span class="text-green-600 font-semibold">Active</span>
                                @else
                                    <span class="text-red-600 font-semibold">Expired</span>
                                @endif
                            </td>
                            <td class="py-2 px-3 md:px-4 border-b">
                                <button class="text-white hover:bg-blue-800 bg-blue-600 px-4 md:px-6 py-1 rounded w-full sm:w-auto">View</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
