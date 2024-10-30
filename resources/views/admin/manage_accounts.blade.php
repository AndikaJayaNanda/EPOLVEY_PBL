@extends('layouts.app')

@section('content')
<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-6 md:ml-64 block">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Data Akun Mahasiswa</h1>
                <!-- Add and Import Buttons -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.account_create') }}" class="px-4 py-2 bg-gray-300 text-gray-800 font-medium rounded-lg hover:bg-gray-400">ADD</a>
                    <button type="button" onclick="document.getElementById('excelFileInput').click()" class="px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700">Import</button>
                    <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;" onchange="uploadExcelFile()">
                </div>
            </div>

            <!-- Search Bar and Sorting -->
            <div class="mb-4 flex justify-between items-center">
                <div class="relative">
                    <input type="text" id="searchInput" class="px-7 py-2 rounded-lg border border-gray-300 w-72" placeholder="Search..." onkeyup="filterTable()" />
                    <ion-icon name="search-outline" class="absolute right-3 top-3"></ion-icon>
                </div>
                <select id="sortOptions" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 border border-gray-300" onchange="applySort()">
                    <option value="newest_update">Newest</option>
                    <option value="oldest_update">Oldest</option>
                    <option value="az">A-Z (Nama Mahasiswa)</option>
                    <option value="za">Z-A (Nama Mahasiswa)</option>
                </select>
            </div> 

            <!-- Table -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table id="studentTable" class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profils as $index => $profil)
                        <tr data-updated="{{ $profil->updated_at }}">
                            <td class="px-4 py-4 border-b border-gray-200"><td class="px-4 py-4 border-b border-gray-200">{{ $loop->iteration }}</td></td>
                            <td class="px-4 py-4 border-b border-gray-200">{{ $profil->username }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                @if($profil->role === 'Mahasiswa')
                                    {{ $profil->mahasiswa_name }}
                                @elseif($profil->role === 'Dosen')
                                    {{ $profil->dosen_name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200">{{ $profil->role }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <a href="{{ route('admin.account_edit', $profil->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.account_delete', $profil->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

           
        </div>
    </div>
</div>

<script>
    // Confirmation before deletion
    function confirmDelete() {
        return confirm('Are you sure you want to delete this account? This action cannot be undone.');
    }

    // Search function
    function filterTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toLowerCase();
        table = document.getElementById("studentTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "none";
            let match = false;

            // Loop through columns: ID (col 0), Username (col 1), Nama Lengkap (col 2), Role (col 3)
            for (j = 0; j < 4; j++) {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }

            // Show the row if any column matches the filter
            if (match) {
                tr[i].style.display = "";
            }
        }
    }

    // Sorting function
    function applySort() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("studentTable");
        switching = true;
        var sortType = document.getElementById("sortOptions").value;

        while (switching) {
            switching = false;
            rows = Array.from(table.rows).slice(1); // Exclude header row

            for (i = 0; i < (rows.length - 1); i++) {
                shouldSwitch = false;

                // Sorting by last_update or oldest_update
                if (sortType === "newest_update" || sortType === "oldest_update") {
                    x = rows[i].getAttribute("data-updated");
                    y = rows[i + 1].getAttribute("data-updated");

                    if (sortType === "newest_update" && new Date(x) < new Date(y)) {
                        shouldSwitch = true;
                        break;
                    } else if (sortType === "oldest_update" && new Date(x) > new Date(y)) {
                        shouldSwitch = true;
                        break;
                    }
                }

                // Sorting A-Z or Z-A by name
                if (sortType === "az" || sortType === "za") {
                    x = rows[i].getElementsByTagName("TD")[1].innerText.toLowerCase();
                    y = rows[i + 1].getElementsByTagName("TD")[1].innerText.toLowerCase();
                    if ((sortType === "az" && x > y) || (sortType === "za" && x < y)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
</script>

@endsection
