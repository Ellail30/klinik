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
                <img src="images/clinic.png" alt="clinic logo" class="w-20 h-20 rounded-full shadow-md">
                <h1 class="text-xl font-semibold">Klinik PKU Berbah</h1>
            </div>
            <!-- Navigation -->
            <ul class="space-y-4 font-medium">
                <!-- General Section -->
                <li>
                    <button
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-700 focus:outline-none transition">
                        <span class="flex items-center space-x-3">
                            <i class='bx bxs-dashboard text-2xl'></i>
                            <span class="text-base">General</span>
                        </span>
                        <i class='bx bx-chevron-down'></i>
                    </button>
                    <ul class="hidden space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out opacity-0 translate-y-[-10px]">
                        <li>
                            <a href="{{ url('/dashboard') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ url('/config_user') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700">Config User</a>
                        </li>
                    </ul>
                </li>
                <!-- Inventory Section -->
                <li>
                    <button
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-700 focus:outline-none transition">
                        <span class="flex items-center space-x-3">
                            <i class='bx bxs-capsule text-2xl'></i>
                            <span class="text-base">Inventory</span>
                        </span>
                        <i class='bx bx-chevron-down'></i>
                    </button>
                    <ul class="hidden space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out opacity-0 translate-y-[-10px]">
                        <li>
                            <a href="{{ url('/obat') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Obat</a>
                        </li>
                        <li>
                            <a href="{{ url('/supplier') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-700">Supplier</a>
                        </li>
                        <li>
                            <a href="{{ url('/pasien') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Pasien</a>
                        </li>
                        <li>
                            <a href="{{ url('/obatmasuk') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Obat Masuk</a>
                        </li>
                        <li>
                            <a href="{{ url('/obatkeluar') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Obat Keluar</a>
                        </li>
                    </ul>
                </li>

                <!-- Reports Section -->
                <li>
                    <button
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-700 focus:outline-none transition">
                        <span class="flex items-center space-x-3">
                            <i class='bx bxs-file text-2xl'></i>
                            <span class="text-base">Laporan</span>
                        </span>
                        <i class='bx bx-chevron-down'></i>
                    </button>
                    <ul class="hidden space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out opacity-0 translate-y-[-10px]">
                        <li>
                            <a href="{{ url('/laporan_keluar') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Laporan Obat Keluar</a>
                        </li>
                        <li>
                            <a href="{{ url('/laporan_masuk') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Laporan Obat Masuk</a>
                        </li>
                        <li>
                            <a href="{{ url('/laporan_persediaan') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Laporan Persediaan</a>
                        </li>
                    </ul>
                </li>
                <!-- Account Section -->
                <li>
                    <button
                        class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-700 focus:outline-none transition">
                        <span class="flex items-center space-x-3">
                            <i class='bx bxs-lock-alt text-2xl'></i>
                            <span class="text-base">Akun</span>
                        </span>
                        <i class='bx bx-chevron-down'></i>
                    </button>
                    <ul class="hidden space-y-2 pl-6 mt-2 transition-all duration-300 ease-in-out opacity-0 translate-y-[-10px]">
                        <li>
                            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-blue-700">Change Password</a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }} "
                                class="block px-4 py-2 rounded-lg hover:bg-blue-700">Logout</a>
                        </li>
                    </ul>
                </li>
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
    document.querySelectorAll("aside button").forEach((button) => {
        button.addEventListener("click", () => {
            const dropdown = button.nextElementSibling;
            if (dropdown.classList.contains("hidden")) {
                dropdown.classList.remove("hidden");
                dropdown.classList.add("opacity-0", "translate-y-[-10px]");
                setTimeout(() => {
                    dropdown.classList.add("opacity-100", "translate-y-0");
                    dropdown.classList.remove("opacity-0", "translate-y-[-10px]");
                }, 10);
            } else {
                dropdown.classList.add("opacity-0", "translate-y-[-10px]");
                dropdown.classList.remove("opacity-100", "translate-y-0");
                setTimeout(() => {
                    dropdown.classList.add("hidden");
                    dropdown.classList.remove("opacity-0", "translate-y-[-10px]");
                }, 300);
            }

            // Menambahkan scroll ke dalam dropdown jika perlu
            if (dropdown.scrollHeight > dropdown.clientHeight) {
                dropdown.style.overflowY = 'auto'; // Memastikan overflow dapat terjadi
            } else {
                dropdown.style.overflowY = 'hidden'; // Menyembunyikan scrollbar jika tidak diperlukan
            }
        });
    });
</script>
