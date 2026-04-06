document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const bookItems = document.querySelectorAll('.book-item');
    const jsNoResults = document.getElementById('jsNoResults');
    const searchForm = document.getElementById('searchForm');

    if (searchInput) {
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => e.preventDefault());
        }

        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            let adaBuku = false;

            bookItems.forEach(item => {
                const textBase = item.querySelector('.judul-buku').textContent.toLowerCase() + 
                                item.querySelector('.penulis-buku').textContent.toLowerCase();

                if (textBase.includes(filter)) {
                    // MUNCULKAN
                    item.classList.remove('is-hidden');
                    // RequestAnimationFrame buat mastiin browser sempet render display dulu
                    requestAnimationFrame(() => {
                        item.classList.remove('fade-out');
                    });
                    adaBuku = true;
                } else {
                    // HILANGKAN
                    item.classList.add('fade-out');
                    // Kasih waktu pudar sebentar (200ms) baru hilangkan dari grid
                    setTimeout(() => {
                        if (item.classList.contains('fade-out')) {
                            item.classList.add('is-hidden');
                        }
                    }, 200); 
                }
            });

            // Munculkan pesan kosong kalau beneran nggak ada
            if (!adaBuku && filter !== "") {
                jsNoResults.classList.remove('d-none');
            } else {
                jsNoResults.classList.add('d-none');
            }
        });
    }
});