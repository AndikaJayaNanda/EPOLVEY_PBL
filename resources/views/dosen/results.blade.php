@extends('layouts.app')
@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <h1 class="text-xl font-semibold text-gray-700">Table Data Survey</h1>
                <div class="relative">
                    <select id="sortFilter" class="text-sm font-medium text-blue-600 bg-blue-100 rounded-lg px-4 py-2 hover:bg-blue-200 focus:outline-none">
                        <option value="">Sort By</option>
                        <option value="name">Name</option>
                        <option value="status">Status</option>
                        <option value="last_update">Last Update (Newest)</option>
                        <option value="oldest_update">Last Update (Oldest)</option>
                    </select>
                </div>
            </div>
        
            <table id="surveyTable" class="w-full mt-4">
                <tbody>
                    @forelse($surveys as $survey)
                        <tr class="border-b border-gray-200">
                            <td class="py-4 text-gray-700 font-medium">{{ $survey->nama }}</td>
                            <td class="py-4 text-sm text-gray-500">{{ $survey->creator }}</td>
                            <td class="py-4">
                                <span class="text-xs font-semibold text-blue-600 bg-blue-100 rounded-full px-2 py-1">{{ $survey->status }}</span>
                            </td>
                            <td class="py-4 text-sm text-gray-500">Last Update: {{ $survey->updated_at->format('d/M/Y') }}</td>
                            <td class="py-4 text-sm text-gray-500">Due: {{ $survey->created_at->format('d/M/Y') }}</td>
                            <td class="py-4 text-blue-600 hover:text-blue-800 cursor-pointer">
                                <a href="{{ route('dosen.survey_result', $survey->id) }}">View More</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No surveys available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById("sortFilter").addEventListener("change", function() {
        sortTable(this.value);
    });

    function sortTable(sortType) {
        const table = document.getElementById("surveyTable");
        const rows = Array.from(table.rows);
        
        rows.sort((a, b) => {
            let x, y;
            
            switch (sortType) {
                case "name":
                    x = a.cells[0].innerText.toLowerCase();
                    y = b.cells[0].innerText.toLowerCase();
                    return x.localeCompare(y);

                case "status":
                    x = a.cells[2].innerText.toLowerCase();
                    y = b.cells[2].innerText.toLowerCase();
                    return x.localeCompare(y);
                    
                case "last_update":
                    x = new Date(a.cells[3].innerText.replace("Last Update: ", ""));
                    y = new Date(b.cells[3].innerText.replace("Last Update: ", ""));
                    return y - x;  // Newest first
                    
                case "oldest_update":
                    x = new Date(a.cells[3].innerText.replace("Last Update: ", ""));
                    y = new Date(b.cells[3].innerText.replace("Last Update: ", ""));
                    return x - y;  // Oldest first
                    
                default:
                    return 0;
            }
        });

        // Reorder rows in the table
        rows.forEach(row => table.appendChild(row));
    }
</script>

@endsection
