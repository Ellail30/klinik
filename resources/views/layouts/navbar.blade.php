<div class="p-4 sm:ml-64">
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex items-center justify-between mx-auto px-8">
            <!-- Greeting and Real-time Date/Time Section -->
            <div class="flex justify-between items-center w-full" id="navbar-user">
                <!-- Greeting Message -->
                <div class="flex flex-col items-start" id="greeting">
                    <div id="indonesian-greeting" class="text-xl font-semibold text-gray-900 dark:text-white mb-1">
                        <!-- Dynamic Indonesian Greeting will be inserted here -->
                    </div>

                    <!-- Javanese Greeting -->
                    <div id="javanese-greeting" class="text-sm text-gray-500 dark:text-gray-400">
                        <!-- Dynamic Javanese Greeting will be inserted here -->
                    </div>
                </div>

                <!-- Real-time Date and Time -->
                <div id="date-time" class="text-sm text-gray-500 dark:text-gray-400 ml-6">
                    <!-- Dynamic Date and Time will be inserted here -->
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Function to generate greeting based on time of day (in Indonesian)
        function getGreeting() {
            const now = new Date();
            const hours = now.getHours();
            let greeting = '';
            let javaneseGreeting = '';

            if (hours < 12) {
                greeting = 'Selamat Pagi! Semoga hari Anda menyenangkan 😊';
                javaneseGreeting = 'Sugeng Enjang! Mugi dinten panjenengan saged nyenengaken';
            } else if (hours < 18) {
                greeting = 'Selamat Sore! Terus semangat dalam bekerja 💪';
                javaneseGreeting = 'Sugeng Sonten! Terus semangat ing ngelampahi karya';
            } else {
                greeting = 'Selamat Malam! Waktunya untuk bersantai dan recharge 🌙';
                javaneseGreeting = 'Sugeng Wengi! Wektu kanggo santai lan ngisi energi';
            }

            // Set the greeting messages dynamically
            document.getElementById('indonesian-greeting').textContent = greeting;
            document.getElementById('javanese-greeting').textContent = javaneseGreeting;
        }

        // Real-time date and time update
        function updateDateTime() {
            const dateTimeElement = document.getElementById('date-time');
            const now = new Date();
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            dateTimeElement.textContent = now.toLocaleString('id-ID', options);
        }

        // Update the greeting and date-time
        getGreeting();
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial update
    </script>
</div>
