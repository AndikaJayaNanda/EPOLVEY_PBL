<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-x-hidden"> <!-- Added overflow-x-hidden here -->
        <!-- Sidebar -->
        @if (Auth::user()->role == 'Admin')
            @include('layouts.sidebars.sidebar-admin')
        @elseif (Auth::user()->role == 'Dosen')
            @include('layouts.sidebars.sidebar-dosen')
        @elseif (Auth::user()->role == 'Mahasiswa')
            @include('layouts.sidebars.sidebar-mahasiswa')
        @else
            {{-- Default sidebar if necessary --}}
        @endif

        <!-- Content -->
        <div class="flex-1 p-6 overflow-x-hidden"> <!-- Added overflow-x-hidden here -->
            @yield('content')
        </div>
    </div>
</body>
</html>
