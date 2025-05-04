<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Default Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.css" rel="stylesheet" />


    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')

    <style>
        /* Sidebar */
        .sidebar {
            min-height: 120vh;
            background: linear-gradient(to top, #49A8E8 10%, #247ADC 100%);
            padding: 5px;
            text-align: center;
            /* Pusatkan konten */
        }

        .logo img {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
            border-radius: 10px;
            align-items: center;
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 20px;
        }

        .sidebar a:hover {
            background-color: rgb(11, 180, 226, 0.5);
        }

        .content-table {
            background: whitesmoke;
            color: #49A8E8;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .content {
            padding: 40px;
            margin-left: 64px;
        }

        /* Konten utama */
        .obat-header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
        }

        /* Styling Tabel */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th {
            background-color: #ffffff;
        }

        .action-btn {
            cursor: pointer;
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 5px;
        }

        .edit-btn {
            background-color: #247ADC;
            color: white;
        }

        .view-btn {
            background-color: #5cb85c;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>


<body>
    <!-- Flash Message Containers (Hidden) -->
    @if (session('success'))
        <div id="flash-success-message" class="hidden">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div id="flash-error-message" class="hidden">{{ session('error') }}</div>
    @endif

    @if (session('warning'))
        <div id="flash-warning-message" class="hidden">{{ session('warning') }}</div>
    @endif

    @if (session('info'))
        <div id="flash-info-message" class="hidden">{{ session('info') }}</div>
    @endif


    <nav>
        @include('layouts.navbar')
    </nav>
    <div class="container-fluid">

        <div class="row">
            <!-- Sidebar -->
            @include('layouts.sidebar')
        </div>
        <!-- Konten -->
        @yield('content')
    </div>

    <!-- Global Delete Confirmation Script -->
    <script>
        // Sweet Alert Global Delete Confirmation Script
        function showDeleteConfirmation(options) {
            const {
                title,
                text = "Tindakan ini tidak dapat dibatalkan!",
                itemName = '',
                route,
                onConfirm = null
            } = options;

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (onConfirm) {
                        // Custom confirmation handler
                        onConfirm();
                    } else {
                        // Default form submission
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = route;

                        // CSRF Token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        form.appendChild(csrfToken);

                        // Method Spoofing for DELETE
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            });
        }

        // Initialize delete buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Universal delete button handler
            const deleteBtns = document.querySelectorAll('.delete-btn');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    // Get data attributes
                    const route = btn.getAttribute('data-route') || btn.getAttribute('data-action');
                    const itemName = btn.getAttribute('data-name') || btn.getAttribute(
                        'data-title');
                    const itemType = btn.getAttribute('data-type') || 'item';

                    // Prepare confirmation options
                    const confirmOptions = {
                        title: `Apakah Anda yakin ingin menghapus ${itemType} "${itemName}"?`,
                        route: route
                    };

                    // Show delete confirmation
                    showDeleteConfirmation(confirmOptions);
                });
            });
        });

      // Global Notification Function
function showNotification(options) {
    // Default options
    const defaultOptions = {
        title: 'Notifikasi',
        text: '',
        icon: 'info',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        position: 'top-end'
    };

    // Merge default options with provided options
    const mergedOptions = { ...defaultOptions, ...options };

    // Mapping of icon types
    const iconMap = {
        success: 'success',
        error: 'error',
        warning: 'warning',
        info: 'info'
    };

    // Ensure icon is valid
    mergedOptions.icon = iconMap[mergedOptions.icon] || 'info';

    // Show SweetAlert
    Swal.fire({
        title: mergedOptions.title,
        text: mergedOptions.text,
        icon: mergedOptions.icon,
        toast: true,
        position: mergedOptions.position,
        showConfirmButton: mergedOptions.showConfirmButton,
        timer: mergedOptions.timer,
        timerProgressBar: mergedOptions.timerProgressBar,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}

// Initialize flash notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check for success message
    const successMessage = document.getElementById('flash-success-message');
    if (successMessage) {
        showNotification({
            title: 'Berhasil',
            text: successMessage.textContent.trim(),
            icon: 'success'
        });
    }

    // Check for error message
    const errorMessage = document.getElementById('flash-error-message');
    if (errorMessage) {
        showNotification({
            title: 'Kesalahan',
            text: errorMessage.textContent.trim(),
            icon: 'error'
        });
    }

    // Check for warning message
    const warningMessage = document.getElementById('flash-warning-message');
    if (warningMessage) {
        showNotification({
            title: 'Peringatan',
            text: warningMessage.textContent.trim(),
            icon: 'warning'
        });
    }

    // Check for info message
    const infoMessage = document.getElementById('flash-info-message');
    if (infoMessage) {
        showNotification({
            title: 'Informasi',
            text: infoMessage.textContent.trim(),
            icon: 'info'
        });
    }

    // Test Trigger Button for Development
    
});

// Expose function globally for manual use
window.showNotification = showNotification;
    </script>

    @stack('scripts')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
