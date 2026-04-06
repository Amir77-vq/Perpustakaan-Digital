/**
 * Logika Konfirmasi Hapus & Alert Sukses Universal
 * Projek: Perpustakaan Digital
 */

document.addEventListener('DOMContentLoaded', function () {

    // Menggunakan Event Delegation agar tidak bentrok saat ada perubahan DOM
    document.addEventListener('click', function (e) {
        
        // Cek apakah yang diklik adalah tombol hapus atau icon di dalamnya
        const btnHapus = e.target.closest('.btn-hapus');
        
        if (btnHapus) {
            e.preventDefault();
            
            // Ambil ID dari atribut data-id
            const id = btnHapus.getAttribute('data-id');
            const form = document.getElementById('form-hapus-' + id);

            if (!form) return; // Guard clause jika form tidak ditemukan

            // Tampilkan SweetAlert Konfirmasi
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: "Apakah Anda yakin ingin menghapus data ini secara permanen?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f44335', // Merah (Hapus)
                cancelButtonColor: '#2152ff',  // Biru (Batal)
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batalkan',
                reverseButtons: true, 
                customClass: {
                    popup: 'border-radius-15'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // kirim form hapus ke server
                    form.submit();
                }
            });
        }
    });
});

/**
 * Menampilkan alert sukses universal
 */
function showSuccessAlert(message) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: message,
        showConfirmButton: false,
        timer: 1500, 
        timerProgressBar: true,
        customClass: {
            popup: 'border-radius-15'
        }
    });
}