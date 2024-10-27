@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="max-w-sm mx-auto bg-gray-800 text-white rounded-lg shadow-lg p-6 relative top-20">
            <!-- Edit Button -->
            <a href="" class="absolute top-10 right-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
                Edit
            </a>
        
            <!-- Profile Image -->
            <div class="w-24 h-24 rounded-full overflow-hidden mx-auto border-4 border-green-500 relative cursor-pointer" onclick="document.getElementById('profileImageInput').click()">
                <img id="profileImage" src="https://via.placeholder.com/150" alt="Profile" class="w-full h-full object-cover">
                <div class="absolute bottom-0 right-0 bg-green-600 p-1 rounded-full text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884l.993-1.737A8 8 0 118.017 16.13l-1.739-.992a1 1 0 01-.58-.903V9.846a1 1 0 01.37-.779L8.68 7.57a4 4 0 10-1.115-1.18L3.782 9.217a1 1 0 01-.779.37H2.084a1 1 0 01-.58-.903v-2.8c0-.326.156-.632.429-.834l.07-.053z" />
                    </svg>
                </div>
            </div>
            <!-- Hidden File Input -->
            <input type="file" id="profileImageInput" accept="image/*" class="hidden" onchange="loadFile(event)">

            <!-- User Info -->
            <div class="text-center mt-4">
                <h2 class="text-2xl font-semibold">Omotayo Kofoworola</h2>
                <p class="text-gray-400">Lagos, Nigeria</p>
            </div>
        
            <!-- Contact Information -->
            <div class="mt-6 space-y-2 text-center">
                <p><span class="font-bold">Email:</span> kofoworolaomotayo@gmail.com</p>
                <p><span class="font-bold">City:</span> Ikoyi</p>
                <p><span class="font-bold">State:</span> Lagos</p>
                <p><span class="font-bold">Country:</span> Nigeria</p>
                <p><span class="font-bold">Phone:</span> (+234)802-446-8361</p>
            </div>
        
            <!-- Ratings -->
            <div class="text-center mt-6">
                <p class="text-gray-400">RATINGS</p>
                <div class="flex justify-center space-x-1">
                    <!-- Star Icons -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927C9.394 2.118 10.606 2.118 10.951 2.927l1.518 3.86a1 1 0 00.755.555l4.146.569a1 1 0 01.564 1.704l-2.995 2.777a1 1 0 00-.29.917l.712 4.08a1 1 0 01-1.451 1.054l-3.668-1.929a1 1 0 00-.943 0l-3.668 1.929a1 1 0 01-1.451-1.054l.712-4.08a1 1 0 00-.29-.917L2.57 9.61a1 1 0 01.564-1.704l4.146-.57a1 1 0 00.755-.554l1.518-3.859z" />
                    </svg>
                    <!-- Repeat similar icons for other stars -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadFile(event) {
        var image = document.getElementById('profileImage');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.onload = function() {
            URL.revokeObjectURL(image.src); // Free memory
        };
    }
</script>
@endsection
