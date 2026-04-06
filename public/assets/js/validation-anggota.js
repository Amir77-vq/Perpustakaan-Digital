document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    if (!form) return;

    // Ambil semua input yang ada di dalam form
    const inputs = form.querySelectorAll('input[name]');
    const noHpInput = document.getElementById('no_hp_input');

    // 1. FILTER INPUT NO HP (User bener-bener gak bisa ngetik huruf/simbol)
    if (noHpInput) {
        noHpInput.addEventListener('input', function() {
            // Langsung hapus kalau yang diketik bukan angka
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // 2. FUNGSI VALIDASI UTAMA
    const validateInput = (input) => {
        // Cari kontainer .col terdekat agar pesan error tidak nyasar
        const container = input.closest('.col');
        const errorElement = container ? container.querySelector(".error-text-custom") : null;
        
        let isValid = true;
        let message = "";
        const val = input.value.trim();

        // A. Cek Kosong
        if (!val) {
            isValid = false;
            message = "Mohon lengkapi data ini.";
        }
        // B. Validasi Khusus No HP
        else if (input.name === "no_hp") {
            if (!val.startsWith("08")) {
                isValid = false;
                message = "Nomor HP harus diawali dengan 08.";
            } else if (val.length < 10 || val.length > 13) {
                isValid = false;
                message = "Nomor HP harus 10-13 digit.";
            }
        }
        // C. Validasi Email
        else if (input.type === "email") {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(val)) {
                isValid = false;
                message = "Format email tidak valid.";
            }
        }
        // D. Validasi Password
        else if (input.name === "password" && val.length < 6) {
            isValid = false;
            message = "Password minimal harus 6 karakter.";
        }

        // EKSEKUSI TAMPILAN ERROR
        if (!isValid) {
            input.classList.add("is-invalid-custom");
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = "block";
            }
        } else {
            input.classList.remove("is-invalid-custom");
            if (errorElement) {
                errorElement.style.display = "none";
            }
        }
        return isValid;
    };

    // 3. JALANKAN VALIDASI SAAT USER MENGETIK
    inputs.forEach((input) => {
        input.addEventListener("input", () => validateInput(input));
    });

    // 4. PENGUNCI FORM (CEGAT SUBMIT)
    form.addEventListener("submit", function (e) {
        let isFormValid = true;
        
        // Cek semua input sekali lagi sebelum dikirim
        inputs.forEach((input) => {
            if (!validateInput(input)) {
                isFormValid = false;
            }
        });

        // JIKA ADA YANG SALAH, BATALKAN SEMUA PROSES
        if (!isFormValid) {
            e.preventDefault();
            e.stopPropagation();
            
            // Fokus ke input pertama yang bermasalah
            const firstError = form.querySelector(".is-invalid-custom");
            if (firstError) firstError.focus();
            
            return false;
        }
    });
});