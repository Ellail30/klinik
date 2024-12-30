<div class="p-4 sm:ml-64">
    <nav class="shadow-md bg-white rounded-md p-4 mt-0">
        <div class="max-w-screen-xl flex items-center justify-between mx-auto">
            <!-- Greeting and Real-time Date/Time Section -->
            <div class="flex flex-col" id="navbar-user">
                <div id="greeting" class="mb-2">
                    <!-- Greeting Message -->
                    <div id="indonesian-greeting" class="text-xl font-semibold text-gray-800">
                        <!-- Dynamic Indonesian Greeting -->
                    </div>
                    <!-- Javanese Greeting -->
                    <div id="javanese-greeting" class="text-sm text-gray-500">
                        <!-- Dynamic Javanese Greeting -->
                    </div>
                </div>

                <!-- Real-time Date and Time -->
                <div id="date-time" class="text-sm text-gray-500">
                    <!-- Dynamic Date and Time -->
                </div>
            </div>

            <!-- Avatar and Dropdown -->
            <div class="relative">
                <button
                    id="avatar-button"
                    class="flex items-center focus:outline-none focus:ring-2 focus:ring-blue-500"
                    type="button"
                >
                    <img
                        src="https://via.placeholder.com/40"
                        alt="User Avatar"
                        class="w-10 h-10 rounded-full"
                    />
                    <span class="ml-2 text-sm font-medium text-gray-700">Rani</span>
                    <svg
                        class="w-4 h-4 ml-1 text-gray-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div
                    id="dropdown-menu"
                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg"
                >
                    <a
                        href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    >
                        Ganti Kata Sandi
                    </a>
                    <a
                        href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    >
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Dropdown toggle logic
        const avatarButton = document.getElementById("avatar-button");
        const dropdownMenu = document.getElementById("dropdown-menu");

        avatarButton.addEventListener("click", () => {
            dropdownMenu.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (event) => {
            if (
                !avatarButton.contains(event.target) &&
                !dropdownMenu.contains(event.target)
            ) {
                dropdownMenu.classList.add("hidden");
            }
        });

        // Function to generate greeting based on time of day (in Indonesian)
        function getGreeting() {
            const now = new Date();
            const hours = now.getHours();
            let greeting = "";
            let javaneseGreeting = "";

            if (hours < 12) {
                greeting = "Selamat Pagi! Semoga hari Anda menyenangkan 😊";
                javaneseGreeting =
                    "Sugeng Enjang! Mugi dinten panjenengan saged nyenengaken";
            } else if (hours < 18) {
                greeting = "Selamat Sore! Terus semangat dalam bekerja 💪";
                javaneseGreeting =
                    "Sugeng Sonten! Terus semangat ing ngelampahi karya";
            } else {
                greeting = "Selamat Malam! Waktunya untuk bersantai dan recharge 🌙";
                javaneseGreeting =
                    "Sugeng Wengi! Wektu kanggo santai lan ngisi energi";
            }

            // Set the greeting messages dynamically
            document.getElementById("indonesian-greeting").textContent = greeting;
            document.getElementById("javanese-greeting").textContent =
                javaneseGreeting;
        }

        // Real-time date and time update
        function updateDateTime() {
            const dateTimeElement = document.getElementById("date-time");
            const now = new Date();
            const options = {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit",
            };
            dateTimeElement.textContent = now.toLocaleString("id-ID", options);
        }

        // Update the greeting and date-time
        getGreeting();
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial update
    </script>
</div>
