/* public/assets/js/validation-peminjaman.js */

document.addEventListener('DOMContentLoaded', function() {
    const confirmButtons = document.querySelectorAll('.btn-konfirmasi');

    confirmButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Konfirmasi Peminjaman?',
                text: "Status buku ini akan berubah menjadi DIPINJAM",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2e7d32',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Konfirmasi!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});