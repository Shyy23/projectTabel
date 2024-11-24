// SEARCH
const search = document.querySelector('.header__search input'),
      table_rows = document.querySelectorAll('tbody tr');
      
search.addEventListener('input', searchTable);

function searchTable(){
    table_rows.forEach((row,i) => {
        let table_data = row.textContent.toLowerCase(),
            search_data = search.value.toLowerCase();

        row.classList.toggle('hide',table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i/25 + 's');
    })

    document.querySelectorAll("tbody tr:not(.hide)").forEach((visible_row, i)=> {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : 'hsl(228, 0%, 60%)';
    });
}

// ALERT
window.onload = function() {
    var alertBox = document.getElementById('alert');
    if (alertBox) {
        alertBox.classList.add('show'); // Tambahkan kelas 'show' untuk memunculkan alert
        setTimeout(function() {
            alertBox.style.display = 'none'; // Sembunyikan setelah 5 detik
        }, 5000);
    }
};

// DELETE ALERT
document.querySelectorAll('.delete__btn').forEach(function(button) {
    button.addEventListener('click', function(event) {
        // Munculkan konfirmasi
        const confirmed = confirm('Apakah Anda yakin ingin menghapus data ini?');
        if (!confirmed) {
            // Jika batal, cegah aksi default (navigasi ke link)
            event.preventDefault();
        }
    });
});