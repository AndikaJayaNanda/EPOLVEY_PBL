<div class="relative z-10">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-10">
        <div class="w-64 h-screen bg-white shadow-md">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-purple-600 rounded-br-3xl">
                <div class="flex items-center">
                    @php
                        $profile = Auth::user()->profilMahasiswa; // Retrieve the profile
                    @endphp
                    <img src="{{ asset('storage/images/foto_profil/' . $profile->foto) }}" alt="User Image" class="w-16 h-16 rounded-full border-white ">
                    <div class="ml-4">
                        <h2 class="text-white text-xl font-semibold">{{ Auth::user()->name }}</h2>
                        <p class="text-purple-200 text-sm">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <nav class="mt-8">
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                            <ion-icon name="easel-outline"></ion-icon>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href={{ route('mahasiswa.survey') }} class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                            <ion-icon name="create-outline"></ion-icon>
                            <span class="ml-4">Surveys</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('mahasiswa.profil', auth()->user()->id) }}"class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                            <ion-icon name="person-outline"></ion-icon>
                            <span class="ml-4">Profil</span>
                        </a>
                    </li>
                    <div class="flex items-center justify-center">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="bg-teal-500 text-white px-5 py-2 flex items-center rounded hover:bg-teal-600">
                            Logout
                        </a>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Hamburger Icon, initially placed beside the sidebar -->
    <div class="fixed z-20 top-0 left-0 transition-transform duration-300 ease-in-out transform lg:hidden" id="hamburger-container">
        <button id="hamburger" class="text-gray-500 p-4 focus:outline-none focus:text-gray-700">
            <ion-icon name="menu-outline" class="text-3xl"></ion-icon>
        </button>
    </div>
</div>

<!-- JavaScript to toggle sidebar and hamburger position -->
<script>
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const hamburgerContainer = document.getElementById('hamburger-container');
    let sidebarOpen = false;

    hamburger.addEventListener('click', () => {
        sidebarOpen = !sidebarOpen;
        if (sidebarOpen) {
            sidebar.classList.remove('-translate-x-full');  // Show the sidebar
            hamburgerContainer.style.transform = 'translateX(16rem)'; // Move hamburger to the right (width of sidebar)
        } else {
            sidebar.classList.add('-translate-x-full');  // Hide the sidebar
            hamburgerContainer.style.transform = 'translateX(0)'; // Move hamburger back to original position
        }
    });

    // Close sidebar when clicking outside of it
    window.addEventListener('click', (event) => {
        if (sidebarOpen && !sidebar.contains(event.target) && !hamburger.contains(event.target)) {
            sidebar.classList.add('-translate-x-full');
            hamburgerContainer.style.transform = 'translateX(0)';
            sidebarOpen = false;
        }
    });
</script>
