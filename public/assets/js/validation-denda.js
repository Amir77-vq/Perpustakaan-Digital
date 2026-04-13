document.addEventListener('DOMContentLoaded', function() {
    const inputBayar = document.getElementById('input_bayar');
    const inputDenda = document.getElementById('input_total_denda');
    const textKembalian = document.getElementById('text_kembalian');
    const btnSubmit = document.getElementById('btn_submit');

    if (inputBayar) {
        inputBayar.addEventListener('input', function() {
            // Pastikan nilai adalah angka murni, buang karakter aneh
            const totalDenda = parseInt(inputDenda.value.replace(/[^0-9]/g, '')) || 0;
            const jumlahBayar = parseInt(this.value.replace(/[^0-9]/g, '')) || 0;
            
            const selisih = jumlahBayar - totalDenda;

            if (this.value === "") {
                textKembalian.innerText = "Rp 0";
                textKembalian.style.color = "#344767";
                btnSubmit.disabled = true;
            } else if (selisih >= 0) {
                // Format ke rupiah Indonesia (Rp 5.000)
                textKembalian.innerText = "Rp " + selisih.toLocaleString('id-ID');
                textKembalian.style.color = "#344767";
                btnSubmit.disabled = false;
            } else {
                textKembalian.innerText = "Uang Kurang!";
                textKembalian.style.color = "#ea0606";
                btnSubmit.disabled = true;
            }
        });
    }
});

// Fungsi global untuk blokir panah keyboard
function disableArrowKeys(e) {
    if (e.which === 38 || e.which === 40) {
        e.preventDefault();
        return false;
    }
}