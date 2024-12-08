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

// Table
function getTableType() {
    const tableTypes = ['siswa', 'guru', 'jadwal', 'absen'];
    for (const type of tableTypes) {
        if (document.getElementById(`table-${type}`) !== null) {
            return type;
        }
    }
    return '';
}

let fetchedPageData = [];
const searchKeyword = document.getElementById('search').value;
const limitPerPage = 15;

// Variabel global untuk menyimpan nilai role
let userRole = 'user';  // Default role

// Fungsi untuk mengambil nilai role melalui AJAX
function fetchRole() {
    return fetch('/projectSyahrul/role.php')  // Mengakses file PHP untuk mendapatkan role
        .then(response => response.json())  // Mengonversi respon ke JSON
        .then(data => {
            const userRole = data.role;  // Menyimpan nilai role dalam variabel local
            console.log('Role from PHP:', userRole);

            // Menyimpan nilai role ke dalam sessionStorage
            sessionStorage.setItem('role', userRole);  
        })
        .catch(error => console.error('Error fetching role:', error));
}

userRole = sessionStorage.getItem('role');
console.log(userRole);

// Fungsi lain yang membutuhkan nilai role
function checkUserRole() {
    // Menggunakan nilai role dalam fungsi lain
    if (userRole === 'admin') {
        console.log('User is admin');
        // Lakukan sesuatu jika role adalah admin
    } else {
        console.log('User is not admin');
        // Lakukan sesuatu jika role bukan admin
    }
}

// Mengambil role saat halaman dimuat dan kemudian memanggil fungsi lain
fetchRole().then(() => {
    // Setelah role diambil, kita bisa memanggil fungsi lain yang membutuhkan role
    checkUserRole();
});

// SEARCH
// Fungsi untuk menangani pencarian
document.getElementById('header-search').addEventListener('submit', function(event) {
    event.preventDefault();  // Mencegah halaman ter-reload

    const searchKeyword = document.getElementById('search').value;  // Ambil nilai dari input search
    fetchData(1, limitPerPage, currentSort, searchKeyword);  // Panggil fungsi fetchData dengan kata kunci pencarian
});



// SORTING 
function getSortColumn(tableType) {
    const sortColumn = {
        'siswa' : 'id_siswa',
        'guru' : 'id_guru',
        'jadwal' : 'id_hari',
        'absen' : 'id_absen',
    };

    return sortColumn[tableType] || 'id_siswa';
}

// Menyimpan status urutan sort (ASC atau DESC) untuk setiap kolom
let currentSort = 'ASC';
let currentSortColumn = getSortColumn(getTableType());

// Menambahkan event listener pada setiap header tabel <th>
const columnHeaders = document.querySelectorAll('.table__head th');

columnHeaders.forEach(header => {
    header.addEventListener('click', function() {
        const columnName = header.getAttribute('data-sort');
        toggleSortOrder(columnName);
    });
});

// Fungsi untuk membalikkan urutan sort (ASC/DESC) dan mengubah status urutan
function toggleSortOrder(columnName) {
    
    // Reset sorting di semua header tabel
    const columnHeaders = document.querySelectorAll('.table__head th');
    columnHeaders.forEach(header => {
        header.classList.remove('sorting'); // Menghapus kelas sorting dari semua kolom
        const icon = header.querySelector('.sort-icon');
        if (icon) {
            icon.classList.remove('fa-sort-up', 'fa-sort-down'); // Menghapus ikon
            icon.classList.add('fa-sort'); // Menambahkan ikon default
        }
    });

    // Menambahkan kelas sorting ke kolom yang aktif
    const currentColumnHeader = document.querySelector(`th[data-sort="${columnName}"]`);
    currentColumnHeader.classList.add('sorting');

    // Menentukan urutan (ASC/DESC)
    if (currentSortColumn === columnName) {
        currentSort = currentSort === 'ASC' ? 'DESC' : 'ASC';
    } else {
        currentSortColumn = columnName;
        currentSort = 'ASC';
    }

    // Update ikon untuk menunjukkan urutan yang dipilih
    updateSortIcon(currentColumnHeader);

    // Panggil fetchData untuk mengambil data dengan urutan baru
    const searchKeyword = document.getElementById('search').value;
    fetchData(1, limitPerPage, currentSort, searchKeyword, currentSortColumn, userRole);
}
// Fungsi untuk memperbarui ikon sesuai dengan urutan sorting
function updateSortIcon(currentColumnHeader) {
    const icon = currentColumnHeader.querySelector('.sort-icon');

    if (currentSort === 'ASC') {
        icon.classList.remove('fa-sort');
        icon.classList.add('fa-solid'); // Menambahkan ikon urutan ASC
        icon.classList.add('fa-sort-up'); // Menambahkan ikon urutan ASC
    } else {
        icon.classList.remove('fa-sort');
        icon.classList.add('fa-solid'); // Menambahkan ikon urutan DESC
        icon.classList.add('fa-sort-down'); // Menambahkan ikon urutan DESC
    }
}





// Fetch Data
function fetchData(page = 1, limit = limitPerPage, sortOrder = 'ASC', search = searchKeyword, sortColumn = currentSortColumn, role = userRole){
    const tableType = getTableType();

    const url = `/projectSyahrul/query/utility/query_utility.php?tabel=${tableType}&page=${page}&limit=${limit}&sort_by=${sortColumn}&sort_order=${sortOrder}&role=${role}`;
    const requestData = {
        method: 'POST',
        body: new URLSearchParams({
            search: search
        }),
    };

    // Ambil jumlah kolom dari header tabel
    const sampleRow = document.querySelector(`#table-${tableType} thead tr`);
    const columnCount = sampleRow ? sampleRow.children.length : 8;

    const tableBody = document.getElementById(`table-body-${tableType}`);
    tableBody.innerHTML = '';

    // Tampilkan skeleton loader
    let skeletonContent = '';
    for (let i = 0; i < 3; i++) {
        skeletonContent += `
            <tr class="skeleton-loader">
                <td colspan="${columnCount}" class="skeleton"></td>
            </tr>`;
    }
    tableBody.innerHTML = skeletonContent;
    

    // Berikan waktu agar skeleton loader muncul terlebih dahulu
    setTimeout(() => {
        fetch(url, requestData)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched Data:', data); 

            tableBody.innerHTML = '';
            renderTable(tableType, data[tableType], role);
            renderPagination(data.pagination, limit,search);
        })
        .catch(error => {
            // Memberikan pesan error yang lebih jelas
            console.error('Error occurred during fetch operation: ', error.message);
            console.error('URL that caused the error:', url);
            alert('An error occurred while fetching data. Please check the console for details.');
        });
    }, 1000);  // Menunda pengambilan data selama 100ms
}


// Render Table
function renderTable(tableType, data, role){

    const tableBody = document.getElementById(`table-body-${tableType}`);
    tableBody.innerHTML = '';

    data.forEach(item => {
        const row = document.createElement('tr');
        row.classList.add('table__row');


        let editDeleteButtons = '';
        let tambahDataButton = '';
        // Cek apakah user adalah admin atau user
        if (role === 'admin') {
            editDeleteButtons = `
                <td><a class='edit__btn btn' href='../view/viewEdit.php?tabel=${tableType}&${tableType}_id=${item['id_' + tableType]}'>EDIT</a></td>
                <td><a class='delete__btn btn' href='../query/query_delete.php?tabel=${tableType}&id=${item['id_' + tableType]}'>DELETE</a></td>
            `;
        }

        if(role === 'user'){
                    // Cek apakah status aktif dan tambahkan tombol "Tambah Data" jika aktif
        if ((item.aktif === 'aktif' && item.attendance_filled === 1) || (item.aktif === 'tidak aktif' && item.attendance_filled === 1)) {
            tambahDataButton = `<td>Recorded</td>`;
        } else if(item.aktif === 'aktif' && item.attendance_filled === 0){
            tambahDataButton = `
                <td class="aksi"><a class='tambah__btn btn' href='../view/viewAdd.php?tabel=presensi&${tableType}_id=${item['id_' + tableType]}'>Submit Attendance</a></td>
            `; // Opsional: menampilkan pesan jika tidak aktif
        }else{
            tambahDataButton = '<td></td>';
        }
        }


        if(tableType === 'siswa'){
            row.innerHTML = `
            <td>${item.no}</td>
            <td>${item.nama}</td>
            <td>${item.jenis_kelamin}</td>
            <td>${item.nama_kelas_s}</td>
            <td>${item.alamat}</td>
            ${editDeleteButtons}
            `;
        } else if(tableType === 'guru'){
            row.innerHTML = `
            <td>${item.no}</td>
            <td>${item.nama_guru_g}</td>
            <td>${item.jenis_kelamin}</td>
            <td>${item.nama_mapel_g}</td>
            <td>${item.alamat_guru_g}</td>
            ${editDeleteButtons}
            `;
        } else if(tableType === 'jadwal'){
            row.innerHTML = `
            <td>${item.no}</td>
            <td>${item.nama_hari_j}</td>
            <td>${item.nama_guru_j}</td>
            <td>${item.nama_kelas_j}</td>
            <td>${item.nama_mapel_j}</td>
            <td>${item.jam_mulai}</td>
            <td>${item.jam_selesai}</td>
            ${editDeleteButtons}
            `;
        } else if(tableType === 'absen'){
            row.innerHTML = `
            <td>${item.no}</td>
            <td>${item.nama_siswa_a}</td>
            <td>${item.nama_mapel_a}</td>
            <td>${item.waktu}</td>
            <td>${item.tanggal}</td>
            <td>${item.keterangan_a}</td>
            ${editDeleteButtons}
            `;
        }
        tableBody.appendChild(row);
    });

        
       

}

// PAGINATION
function renderPagination(paginationData, limit ,searchKeyword){

    const {currentPage, totalPages} = paginationData;
    const pageNumbersContainer = document.getElementById('page-numbers');
    pageNumbersContainer.innerHTML = '';
// Halaman Pertama (1) jika bukan di halaman pertama
if (currentPage > 1) {
    const firstPageLink = document.createElement('a');
    firstPageLink.href = '#';
    firstPageLink.textContent = '1';
    firstPageLink.classList.add('page__number');
    firstPageLink.setAttribute('data-fungsi', 'page-1');
    firstPageLink.addEventListener('click', (e) => {
        e.preventDefault();
        fetchData(1, limit, currentSort, searchKeyword, currentSortColumn, userRole);
    });
    pageNumbersContainer.appendChild(firstPageLink);
}

// Halaman Sebelumnya
if (currentPage > 2) {
    const prevPageLink = document.createElement('a');
    prevPageLink.href = '#';
    prevPageLink.textContent = currentPage - 1;
    prevPageLink.classList.add('page__number');
    prevPageLink.setAttribute('data-fungsi', `page-${currentPage - 1}`);
    prevPageLink.addEventListener('click', (e) => {
        e.preventDefault();
        fetchData(currentPage - 1, limit, currentSort, searchKeyword, currentSortColumn, userRole);
    });
    pageNumbersContainer.appendChild(prevPageLink);
}

// Halaman Saat Ini
const currentPageLink = document.createElement('a');
currentPageLink.href = '#';
currentPageLink.textContent = currentPage;
currentPageLink.classList.add('page__number', 'active');
currentPageLink.setAttribute('data-fungsi', `page-${currentPage}`);
pageNumbersContainer.appendChild(currentPageLink);

// Halaman Berikutnya
if (currentPage < totalPages - 1) {
    const nextPageLink = document.createElement('a');
    nextPageLink.href = '#';
    nextPageLink.textContent = currentPage + 1;
    nextPageLink.classList.add('page__number');
    nextPageLink.setAttribute('data-fungsi', `page-${currentPage + 1}`);
    nextPageLink.addEventListener('click', (e) => {
        e.preventDefault();
        fetchData(currentPage + 1, limit, currentSort, searchKeyword, currentSortColumn, userRole);
    });
    pageNumbersContainer.appendChild(nextPageLink);
}

// Halaman Terakhir (Last)
if (currentPage !== totalPages) {
    const lastPageLink = document.createElement('a');
    lastPageLink.href = '#';
    lastPageLink.textContent = totalPages;
    lastPageLink.classList.add('page__number');
    lastPageLink.setAttribute('data-fungsi', `page-${totalPages}`);
    lastPageLink.addEventListener('click', (e) => {
        e.preventDefault();
        fetchData(totalPages, limit, currentSort, searchKeyword,currentSortColumn,userRole);
    });
    pageNumbersContainer.appendChild(lastPageLink);
}


    const prevPage = document.getElementById('prev-page');
    const nextPage = document.getElementById('next-page');
    
    prevPage.replaceWith(prevPage.cloneNode(true));
    nextPage.replaceWith(nextPage.cloneNode(true));
    
    // Ambil kembali elemen yang baru
    const newPrevPage = document.getElementById('prev-page');
    const newNextPage = document.getElementById('next-page');

    if (currentPage > 1) {
        newPrevPage.classList.remove('disabled');
        newPrevPage.addEventListener('click', (e) => {
            e.preventDefault();
            fetchData(currentPage - 1);
        });
    } else {
        newPrevPage.classList.add('disabled');
    }

    if (currentPage < totalPages) {
        newNextPage.classList.remove('disabled');
        newNextPage.addEventListener('click', (e) => {
            e.preventDefault();
            fetchData(currentPage + 1);
        });
    } else {
        newNextPage.classList.add('disabled');
    }
}

// Convert To Pdf
const typeTable = getTableType();
const pdf_btn = document.getElementById('toPDF');
const table = document.querySelector(`#main_${typeTable}`);
console.log(typeTable);
console.log(table);
const toPDF = function(table){
    const html_code = `
    <link rel="shortcut icon" href="../assets/icon/siswa/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <link rel="stylesheet" href="../dist/css/hamburgers.
    <link rel="stylesheet" href="../dist/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="../setup/setup.css">
    <link rel="stylesheet" href="../dist/css/table.css">
    <body">${table.innerHTML}</body>
    `;

    const new_window = window.open();
    new_window.document.write(html_code);

    setTimeout(()=>{
        new_window.print();
        new_window.close();
    },1000);
}
pdf_btn.onclick = () => {
    toPDF(table);
}
// fetch awal halaman
document.addEventListener('DOMContentLoaded', () => {
    fetchData(1, limitPerPage, currentSort, searchKeyword, currentSortColumn,userRole);
})

