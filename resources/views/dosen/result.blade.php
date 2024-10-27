@extends('layouts.app')
@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-4 md:p-6 md:ml-64 block">
        <div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <h1 class="text-xl font-semibold text-gray-700">Table Data Survey</h1>
                
                <!-- Sorting Filter Dropdown -->
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
                    <tr class="border-b border-gray-200">
                        <td class="py-4 text-gray-700 font-medium">Survey Kepuasan</td>
                        <td class="py-4 text-sm text-gray-500">ADMIN</td>
                        <td class="py-4">
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 rounded-full px-2 py-1">Active</span>
                        </td>
                        <td class="py-4 text-sm text-gray-500">Last Update: 14/APR/2020</td>
                        <td class="py-4 text-sm text-gray-500">Due: 15/APR/2020</td>
                        <td class="py-4 text-blue-600 hover:text-blue-800 cursor-pointer">View More</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="py-4 text-gray-700 font-medium">Survey Pemasaran</td>
                        <td class="py-4 text-sm text-gray-500">ADMIN</td>
                        <td class="py-4">
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 rounded-full px-2 py-1">Active</span>
                        </td>
                        <td class="py-4 text-sm text-gray-500">Last Update: 14/APR/2020</td>
                        <td class="py-4 text-sm text-gray-500">Due: 15/APR/2020</td>
                        <td class="py-4 text-blue-600 hover:text-blue-800 cursor-pointer">View More</td>
                    </tr>
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
