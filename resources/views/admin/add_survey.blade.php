@extends('layouts.app')
@section('content')

    <div class="min-h-screen flex items-start justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 font-poppins">Create a New Survey</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    
                </p>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display error message -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                        
            <!-- Form for creating new survey -->
            <form action="{{ route('admin.store_survey') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="mb-6">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Judul Survey</label>
                        <input id="nama" name="nama" type="text" autocomplete="off" required class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Enter survey title">
                    </div>

                    <div class="mb-6">
                        <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis Survey</label>
                        <select id="jenis" name="jenis" required class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="IKAD">IKAD</option>
                            <option value="Survey kepuasan">Survey Kepuasan</option>
                            <option value="Jenis Baru">Jenis Baru</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select id="semester" name="semester" required class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <input id="tahun" name="tahun" type="number" autocomplete="off" required class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Enter year">
                    </div>

                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" required class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="berlangsung">Berlangsung</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <!-- Submit button -->
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Survey
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</div>
</div>

@endsection
