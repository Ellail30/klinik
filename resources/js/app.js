import './bootstrap';
import Swal from 'sweetalert2';

// Menampilkan notifikasi
function showNotification(message, type) {
  Swal.fire({
    title: type === 'success' ? 'Berhasil!' : 'Gagal!',
    text: message,
    icon: type,
    confirmButtonText: 'Tutup',
  });
}

window.showNotification = showNotification; // Ekspor untuk akses global
