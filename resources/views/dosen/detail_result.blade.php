@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="p-6 space-y-10 bg-gray-100 min-h-screen">

            <!-- Chart Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Donut Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col items-center">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">Content Distribution</h2>
                    <canvas id="donutChart" width="200" height="200"></canvas>
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-blue-500 rounded-full"></span>
                            <span>Content 1</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-pink-500 rounded-full"></span>
                            <span>Content 2</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-4 h-4 bg-purple-500 rounded-full"></span>
                            <span>Content 3</span>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart with Summary -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">Chart Title</h2>
                    <div class="text-3xl font-bold text-blue-500 mb-2">5,000.00</div>
                    <div class="text-gray-500">50 Orders</div>
                    <canvas id="barChart" width="400" height="200" class="mt-6"></canvas>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-purple-100 text-gray-700">
                        <tr>
                            <th class="p-4">No</th>
                            <th class="p-4">Pertanyaan</th>
                            <th class="p-4">Jawaban</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-purple-50 transition duration-200">
                            <td class="p-4">1</td>
                            <td class="p-4">APAKAH ANDA SUKA MEMBANTU ORANG?</td>
                            <td class="p-4 flex space-x-2">
                                @for ($i = 1; $i <= 5; $i++)
                                <button 
                                    onclick="showPercentage({{ $i }})"
                                    class="relative bg-gray-200 w-14 h-14 rounded-full flex items-center justify-center font-semibold text-gray-700"
                                >
                                    {{ $i }}
                                    <span 
                                        class="absolute top-full mt-1 text-xs text-gray-600 opacity-0 transition-all duration-500"
                                        id="percentage-{{ $i }}">
                                        10%
                                    </span>
                                </button>
                            @endfor
                                
                            </td>
                        </tr>
                        <tr class="hover:bg-purple-50 transition duration-200">
                            <td class="p-4">2</td>
                            <td class="p-4">Nanda Ikhwanul Nadlirin</td>
                            <td class="p-4">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Percentage Display below Buttons -->
            <div id="percentageDisplay" class="mt-4 text-2xl font-bold text-blue-500"></div>

        </div>

        <!-- Include Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Donut and Bar Chart Initialization -->
        <script>
            // Donut Chart
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Content 1', 'Content 2', 'Content 3'],
                    datasets: [{
                        data: [50, 15, 35],
                        backgroundColor: ['#3b82f6', '#ec4899', '#8b5cf6']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Bar Chart
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Content 1',
                        data: [20, 40, 35, 60, 20, 50],
                        backgroundColor: '#3b82f6'
                    }, {
                        label: 'Content 2',
                        data: [15, 30, 25, 45, 15, 35],
                        backgroundColor: '#ec4899'
                    }, {
                        label: 'Content 3',
                        data: [10, 20, 15, 30, 10, 25],
                        backgroundColor: '#8b5cf6'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });

            function showPercentage(index) {
        // Reset all percentages
        for (let i = 1; i <= 5; i++) {
            document.getElementById(`percentage-${i}`).style.opacity = '0';
            document.getElementById(`percentage-${i}`).style.transform = 'translateY(0px)';
        }
        
        // Show selected percentage with animation
        const percentage = document.getElementById(`percentage-${index}`);
        percentage.style.opacity = '1';
        percentage.style.transform = 'translateY(-5px)';
    }
        </script>

    </div>
</div>

@endsection
