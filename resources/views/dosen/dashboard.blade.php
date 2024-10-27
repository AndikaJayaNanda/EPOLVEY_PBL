@extends('layouts.app')
@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">

        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 text-slate-700 drop-shadow-md">
            <!-- Total Survey Box -->
            <div class="bg-white rounded-lg p-4 sm:p-3 md:p-4">
                <h2 class="font-poppins text-lg md:text-xl font-bold mb-6 md:mb-4 drop-shadow-md">Total Survey</h2>
                <div class="text-xl md:text-2xl font-extrabold text-blue-600">12%</div>
            </div>

            <!-- Percentage Completed Survey Box -->
            <div class="bg-white rounded-lg p-4 sm:p-3 md:p-4">
                <h2 class="font-poppins text-lg md:text-xl font-bold mb-6 md:mb-4 drop-shadow-md">Percentage of Completed Surveys</h2>
                <div class="text-xl md:text-2xl font-extrabold text-green-600">85%</div>
            </div>

            <!-- Number of Respondents Box -->
            <div class="bg-white rounded-lg p-4 sm:p-3 md:p-4">
                <h2 class="font-poppins text-lg md:text-xl font-bold mb-6 md:mb-4 drop-shadow-md">Number of Respondents</h2>
                <div class="text-xl md:text-2xl font-extrabold text-yellow-600">320</div>
            </div>
        </div>
    </div>
</div>
@endsection
