document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formUser");
    if (!form) return;

    const inputs = form.querySelectorAll('input[required], select[required]');

    const validateField = (input, isSubmitAction = false) => {
        const container = input.closest('.col-md-6');
        const errorElement = container.querySelector(".error-text-custom");
        let isValid = true;
        let message = "";
        const val = input.value.trim();

        if (!val) {
            isValid = false;
            message = input.tagName === "SELECT" ? "Silakan pilih hak akses pengguna." : "Data ini wajib diisi.";
        } 
        
        if (isValid && input.type === "email" && isSubmitAction) {
            const emailRegex = /^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{3,}$/;
            
            if (!emailRegex.test(val)) {
                isValid = false;
                message = "Format alamat email tidak valid. Pastikan menggunakan huruf kecil dan format yang benar.";
            }
        }

        if (!isValid) {
            input.style.borderColor = "#dc3545";
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = "block";
            }
        } else {
            input.style.borderColor = "#d2d6da";
            if (errorElement) {
                errorElement.style.display = "none";
            }
        }
        return isValid;
    };

    inputs.forEach(input => {
        input.addEventListener("input", () => validateField(input, false));
    });

    form.addEventListener("submit", function (e) {
        let isFormValid = true;
        inputs.forEach(input => {
            if (!validateField(input, true)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            e.preventDefault();
        }
    });
});