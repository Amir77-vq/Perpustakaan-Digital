document.addEventListener('DOMContentLoaded', function() {
    // Sesuaikan ID dengan yang ada di Blade: 'historySearch'
    const searchInput = document.getElementById('historySearch'); 
    const table = document.getElementById('historyTable');
    
    if (searchInput && table) {
        const tbody = table.querySelector('tbody');
        const rows = tbody.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();

            for (let i = 0; i < rows.length; i++) {
                if (rows[i].cells.length < 2) continue;

                const cellJudul = rows[i].querySelector('.judul-buku-bold');
                
                if (cellJudul) {
                    const textValue = cellJudul.textContent || cellJudul.innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        });
    }
});