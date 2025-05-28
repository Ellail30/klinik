<!-- Hamburger button (for small screens) -->
<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<div class="flex flex-col sm:flex-row min-h-screen">
    <!-- Sidebar -->
    <aside id="default-sidebar"
        class="fixed sm:relative w-64 sm:w-72 bg-blue-500 text-white shadow-lg sm:translate-x-0 transform transition-transform duration-300 z-50 h-full overflow-y-auto hidden sm:block">
        <div class="h-full flex flex-col px-6 py-4">
            <!-- Logo and Title -->
            <div class="flex items-center space-x-3 mb-6">
                <img src="{{ asset('images/clinic.png') }}" alt="clinic logo" class="w-20 h-20 rounded-full shadow-md">
                <h1 class="text-xl font-semibold">Klinik PKU Berbah</h1>
            </div>
            <!-- Navigation -->
            @php
$role = Auth::user()->role;
            @endphp
            
            <ul class="space-y-4 font-medium">
                {{-- DASHBOARD --}}
                <li>
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center w-full px-4 py-3 rounded-lg transition {{ request()->is('dashboard') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                        <i class='bx bxs-dashboard text-2xl mr-3'></i>
                        Dashboard
                    </a>
                </li>
            
                {{-- GENERAL (PIMPINAN) --}}
                @if ($role == 'pimpinan')
                    <li>
                        @php
    $isActive = request()->is('dashboard') || request()->is('config_user');
                        @endphp
                        <button
                            class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition {{ $isActive ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                            <span class="flex items-center space-x-3">
                                <i class='bx bxs-cog text-2xl'></i>
                                <span class="text-base">General</span>
                            </span>
                            <i class='bx bx-chevron-down'></i>
                        </button>
                        <ul
                            class="{{ $isActive ? '' : 'hidden' }} space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out {{ $isActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-[-10px]' }}">
                            <li>
                                <a href="{{ url('/dashboard') }}"
                                    class="block px-4 py-2 rounded-lg {{ request()->is('dashboard') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ url('/config_user') }}"
                                    class="block px-4 py-2 rounded-lg {{ request()->is('config_user') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Config
                                    User</a>
                            </li>
                        </ul>
                    </li>
                @endif
            
                {{-- DATA MASTER --}}
                @if (in_array($role, ['dokter', 'apoteker']))
                    @php
    $isActive = request()->is('obat') || request()->is('supplier*') || request()->is('pasien*');
                    @endphp
                    <li>
                        <button
                            class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition {{ $isActive ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                            <span class="flex items-center space-x-3">
                                <i class='bx bxs-capsule text-2xl'></i>
                                <span class="text-base">Data Master</span>
                            </span>
                            <i class='bx bx-chevron-down'></i>
                        </button>
                        <ul
                            class="{{ $isActive ? '' : 'hidden' }} space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out {{ $isActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-[-10px]' }}">
                            @if ($role != 'admin')
                                <li>
                                    <a href="{{ url('/obat') }}"
                                        class="block px-4 py-2 rounded-lg {{ request()->is('obat') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Obat</a>
                                </li>
                            @endif
                            @if ($role == 'apoteker')
                                <li>
                                    <a href="{{ url('/supplier') }}"
                                        class="block px-4 py-2 rounded-lg {{ request()->is('supplier*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Supplier</a>
                                </li>
                            @endif
                            @if (in_array($role, ['dokter', 'admin']))
                                <li>
                                    <a href="{{ url('/pasien') }}"
                                        class="block px-4 py-2 rounded-lg {{ request()->is('pasien*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Pasien</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            
                {{-- TRANSAKSI (APOTEKER) --}}
                @if ($role == 'apoteker')
                    @php
    $isActive = request()->is('obat-masuk*') || request()->is('apoteker*');
                    @endphp
                    <li>
                        <button
                            class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition {{ $isActive ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                            <span class="flex items-center space-x-3">
                                <i class='bx bxs-inbox text-2xl'></i>
                                <span class="text-base">Transaksi</span>
                            </span>
                            <i class='bx bx-chevron-down'></i>
                        </button>
                        <ul
                            class="{{ $isActive ? '' : 'hidden' }} space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out {{ $isActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-[-10px]' }}">
                            <li>
                                <a href="{{ route('obat-masuk.index') }}"
                                    class="block px-4 py-2 rounded-lg {{ request()->is('obat-masuk*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Obat
                                    Masuk</a>
                            </li>
                            <li>
                                <a href="{{ route('apoteker.index') }}"
                                    class="block px-4 py-2 rounded-lg {{ request()->is('apoteker*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Obat
                                    Keluar</a>
                            </li>
                        </ul>
                    </li>
                @endif
            
                {{-- RESEP (DOKTER) --}}
                @if ($role == 'dokter')
                    <li>
                        <a href="{{ route('dokter.index')}}"
                            class="flex items-center w-full px-4 py-3 rounded-lg transition {{ request()->is('dokter*') || request()->is('resep*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                            <i class='bx bxs-book-content text-2xl mr-3'></i>
                            Antrian
                        </a>
                    </li>
                @endif
            
                {{-- INPUT PENDAFTARAN (ADMIN) --}}
                @if ($role == 'admin')
                    <li>
                        <a href="{{ route('pendaftaran.index')}}"
                            class="flex items-center w-full px-4 py-3 rounded-lg transition {{ request()->is('pendaftaran*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                            <i class='bx bxs-user-plus text-2xl mr-3'></i>
                            Pendaftaran
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pasien.index')}}"
                            class="flex items-center w-full px-4 py-3 rounded-lg transition {{ request()->is('pasien*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                            <i class='bx bxs-user text-2xl mr-3'></i>
                            Pasien
                        </a>
                    </li>
                @endif
@if ($role == 'pimpinan')
    @php
        $isActive = request()->is('obat-masuk*') || request()->is('apoteker*');
    @endphp
    <li>
        <button
            class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition {{ $isActive ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
            <span class="flex items-center space-x-3">
                <i class='bx bxs-inbox text-2xl'></i>
                <span class="text-base">Laporan</span>
            </span>
            <i class='bx bx-chevron-down'></i>
        </button>
        <ul
            class="{{ $isActive ? '' : 'hidden' }} space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out {{ $isActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-[-10px]' }}">
            <li>
                <a href="{{ route('obat-masuk.index') }}"
                    class="block px-4 py-2 rounded-lg {{ request()->is('obat-masuk*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Obat
                    Masuk</a>
            </li>
            <li>
                <a href="{{ route('apoteker.index') }}"
                    class="block px-4 py-2 rounded-lg {{ request()->is('apoteker*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Obat
                    Keluar</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ route('persediaan.index') }}"
            class="block px-4 py-2 rounded-lg {{ request()->is('laporan-persediaan*') ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">Persediaan</a>
    </li>
    </ul>
    </li>
@endif
                {{-- AKUN --}}
                {{-- <li>
                    @php
                        $isActive = request()->is('logout') || request()->is('change-password');
                    @endphp
                    <button
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition {{ $isActive ? 'bg-blue-700 text-white' : 'hover:bg-blue-700' }}">
                        <span class="flex items-center space-x-3">
                            <i class='bx bxs-lock-alt text-2xl'></i>
                            <span class="text-base">Akun</span>
                        </span>
                        <i class='bx bx-chevron-down'></i>
                    </button>
                    <ul
                        class="{{ $isActive ? '' : 'hidden' }} space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out {{ $isActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-[-10px]' }}">
                        <li>
                            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-700">Change Password</a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Logout</a>
                        </li>
                    </ul>
                </li> --}}
                </ul>
                
                </div>
                </aside>
                </div>
                
                <script>
                    // Get the hamburger button and sidebar
                    const hamburgerButton = document.querySelector("[data-drawer-toggle]");
                    const sidebar = document.getElementById("default-sidebar");

                    // Toggle sidebar visibility when the hamburger button is clicked
                    hamburgerButton.addEventListener("click", () => {
                        sidebar.classList.toggle("hidden"); // Toggle the visibility of the sidebar
                    });

                    // For toggling dropdowns in the sidebar
                    document.addEventListener("DOMContentLoaded", () => {
                        document.querySelectorAll("aside button").forEach((button) => {
                            button.addEventListener("click", () => {
                                const dropdown = button.nextElementSibling;
                                if (dropdown.classList.contains("hidden")) {
                                    dropdown.classList.remove("hidden");
                                    setTimeout(() => {
                                        dropdown.classList.add("opacity-100", "translate-y-0");
                                        dropdown.classList.remove("opacity-0", "translate-y-[-10px]");
                                    }, 10);
                                } else {
                                    dropdown.classList.add("opacity-0", "translate-y-[-10px]");
                                    dropdown.classList.remove("opacity-100", "translate-y-0");
                                    setTimeout(() => {
                                        dropdown.classList.add("hidden");
                                    }, 300);
                                }
                            });
                        });
                    });
                </script>