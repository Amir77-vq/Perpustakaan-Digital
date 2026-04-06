document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('historyTable');
    
    if (searchInput && table) {
        const tbody = table.getElementsByTagName('tbody')[0];
        const rows = tbody.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            let ditemukan = false;

            for (let i = 0; i < rows.length; i++) {

                if (rows[i].cells.length < 2) continue;

                const judulBuku = rows[i].querySelector('.judul-buku').textContent.toLowerCase();
                
                if (judulBuku.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                    ditemukan = true;
                } else {
                    rows[i].style.display = "none";
                }
            }
            
        });
    }
});