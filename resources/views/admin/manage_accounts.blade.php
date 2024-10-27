@extends('layouts.app')

@section('content')

<div class="antialiased sans-serif min-h-screen">
    <div class="min-h-screen p-6 md:ml-64 block">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Akun Mahasiswa</h1>
            </div>

            <!-- Search Bar and Buttons -->
            <div class="mb-4 flex justify-between items-center space-x-4">
                <input type="text" id="searchInput" class="px-4 py-2 rounded-lg border border-gray-300" placeholder="Cari Nama atau Email..." onkeyup="filterTable()" />
                
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.account_create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Account</a>
                    <!-- Import from Excel Button -->
                    <button type="button" onclick="document.getElementById('excelFileInput').click()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Import from Excel
                    </button>
                    <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;" onchange="uploadExcelFile()">
                </div>

                <select id="sortOptions" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-600" onchange="applySort()">
                    <option value="">Sort By</option>
                    <option value="last_update">Last Update</option>
                    <option value="oldest_update">Oldest Update</option>
                    <option value="az">A-Z (Nama Mahasiswa)</option>
                    <option value="za">Z-A (Nama Mahasiswa)</option>
                </select>
            </div>

            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table id="studentTable" class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profils as $profil)
                        <tr>
                            <td class="px-4 py-4 border-b border-gray-200">{{ $profil->id }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">{{ $profil->name }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">{{ $profil->role }}</td>
                            <!-- Hidden cell for updated_at to use in sorting -->
                            <td class="px-4 py-4 border-b border-gray-200 hidden" data-updated="{{ $profil->updated_at }}">{{ $profil->updated_at }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <a href="{{ route('admin.account_edit', $profil->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.account_delete', $profil->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline px-2">Delete</button>
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
        return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.');
    }

    // Search function
    function filterTable() {
        var input, filter, table, tr, tdName, i, txtValueName;
        input = document.getElementById("searchInput");
        filter = input.value.toLowerCase();
        table = document.getElementById("studentTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "none";
            tdName = tr[i].getElementsByTagName("td")[1]; // Name column

            if (tdName) {
                txtValueName = tdName.textContent || tdName.innerText;

                if (txtValueName.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                }
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
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;

                // Sorting by last_update or oldest_update
                if (sortType === "last_update" || sortType === "oldest_update") {
                    x = rows[i].querySelector("td[data-updated]").dataset.updated;
                    y = rows[i + 1].querySelector("td[data-updated]").dataset.updated;

                    if (sortType === "last_update" && new Date(x) < new Date(y)) {
                        shouldSwitch = true;
                        break;
                    } else if (sortType === "oldest_update" && new Date(x) > new Date(y)) {
                        shouldSwitch = true;
                        break;
                    }
                }

                // Sorting A-Z or Z-A by name
                if (sortType === "az" || sortType === "za") {
                    x = rows[i].getElementsByTagName("TD")[1].innerHTML.toLowerCase();
                    y = rows[i + 1].getElementsByTagName("TD")[1].innerHTML.toLowerCase();
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
