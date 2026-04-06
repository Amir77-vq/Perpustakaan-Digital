document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-peminjaman');
    const tableRows = document.querySelectorAll('.table-peminjaman tbody tr');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const value = this.value.toLowerCase().trim();

            tableRows.forEach(row => {
                if (row.cells.length < 2) return;

                const text = row.textContent.toLowerCase();
                
                if (text.indexOf(value) > -1) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    }
});