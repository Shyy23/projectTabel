// // SEARCH
// const search = document.querySelector('.header__search input'),
//       table_rows = document.querySelectorAll('tbody tr');
      
// search.addEventListener('input', searchTable);

// function searchTable(){
//     table_rows.forEach((row,i) => {
//         let table_data = row.textContent.toLowerCase(),
//             search_data = search.value.toLowerCase();

//         row.classList.toggle('hide',table_data.indexOf(search_data) < 0);
//         row.style.setProperty('--delay', i/25 + 's');
//     })

//     document.querySelectorAll("tbody tr:not(.hide)").forEach((visible_row, i)=> {
//         visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : 'hsl(228, 0%, 60%)';
//     });
// }

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

// SEARCH WITH SKELETON LOADER
document.getElementById('header-search').addEventListener('submit', function(e){
    e.preventDefault();

    const searchInput = document.getElementById('search').value;
    const tableType = getTableType();

    // Menampilkan skeleton soldier
    showSkeletonLoader(tableType);

    function showSkeletonLoader(tableType) {
        const tBody = document.getElementById(`table-body-${tableType}`);
        tBody.innerHTML = '';
    
        // Ambil jumlah kolom dari tabel yang sedang digunakan
        const sampleRow = document.querySelector(`#table-${tableType} thead tr`);
        const columnCount = sampleRow ? sampleRow.children.length : 8; // Default ke 7 jika tidak ditemukan
        
        for (let i = 0; i < 5; i++) { // Tampilkan 5 baris skeleton
            let skeletonCells = '';
            for (let j = 0; j < columnCount; j++) {
                skeletonCells += `<td class="table__data skeleton"></td>`;
            }
    
            tBody.innerHTML += `
                <tr class="skeleton-loader">
                    ${skeletonCells}
                </tr>
            `;
        }
    }
    

    fetch('/projectSyahrul/query/query_search.php', {
        method: 'POST',
        body: new URLSearchParams({
            search: searchInput,
            tabel: tableType
        })
    })

   .then(response => response.json())
   .then(data => {
    console.log(data);
    setTimeout(() => updateTableData(tableType, data), 1000);
   })
   .catch(error => {
    console.log('Error: ', error);
    setTimeout(() => updateTableData(tableType, { error: 'Error fetching data' }), 1000);   });
});

function getTableType(){
    if(document.getElementById('table-siswa') !== null){
        return 'siswa';
    } else if(document.getElementById('table-guru') !== null){
        return 'guru';
    } else if(document.getElementById('table-jadwal') !== null){
        return 'jadwal';
    } else if(document.getElementById('table-absen') !== null){
        return 'absen';
    }
    return '';
}



function updateTableData(tableType, data){
    const tBody = document.getElementById(`table-body-${tableType}`);
    tBody.innerHTML = '';

    if(data.error){
        tBody.innerHTML = "<tr><td colspan='7' class='table__data'>Error Fetching Data</td></tr>";
        return;
    }

    let rows = '';
    if(tableType === 'siswa'){
        data.siswa.forEach(row => {
            rows += `
            <tr class="table__row">
                <td class="table__data ">${row.no}</td>
                <td class="table__data ">${row.nama}</td>
                <td class="table__data ">${row.jenis_kelamin}</td>
                <td class="table__data ">${row.nama_kelas_s}</td>
                <td class="table__data ">${row.alamat}</td>
                <td class="table__data "><a class='edit__btn btn' href='../view/viewEdit.php?tabel=siswa&siswa_id=${row.id_siswa}'>EDIT</a></td>
                <td class="table__data "><a class='delete__btn btn' href='../query/query_delete.php?tabel=siswa&id=${row.id_siswa}'>DELETE</a></td>
            </tr>
            `;
        });
    } else if (tableType === 'guru'){
        data.guru.forEach(row => {
            rows += `
                <tr class="table__row">
                    <td class="table__data ">${row.no}</td>
                    <td class="table__data ">${row.nama_guru_g}</td>
                    <td class="table__data ">${row.jenis_kelamin}</td>
                    <td class="table__data ">${row.nama_mapel_g}</td>
                    <td class="table__data ">${row.alamat_guru_g}</td>
                    <td class="table__data "><a class='edit__btn btn' href='../view/viewEdit.php?tabel=guru&guru_id=${row.id_guru}'>EDIT</a></td>
                    <td class="table__data "><a class='delete__btn btn' href='../query/query_delete.php?tabel=guru&id=${row.id_guru}'>DELETE</a></td>
                </tr>
            `;
        });
    } else if (tableType === 'jadwal'){
        data.jadwal.forEach(row => {
        rows += `
        <tr class="table__row">
            <td class="table__data ">${row.no}</td>
            <td class="table__data ">${row.nama_hari_j}</td>
            <td class="table__data ">${row.nama_kelas_j}</td>
            <td class="table__data ">${row.nama_guru_j}</td>
            <td class="table__data ">${row.nama_mapel_j}</td>
            <td class="table__data ">${row.jam_mulai}</td>
            <td class="table__data ">${row.jam_selesai}</td>
            <td class="table__data "><a class='edit__btn btn' href='../view/viewEdit.php?tabel=jadwal&jadwal_id=${row.id_jadwal}'>EDIT</a></td>
                    <td class="table__data "><a class='delete__btn btn' href='../query/query_delete.php?tabel=jadwal&id=${row.id_jadwal}'>DELETE</a></td>
        </tr>
        `;    
        });       
    } else if(tableType === 'absen'){
        data.absen.forEach(row => {
        rows += `
        <tr class="table__row">
            <td class="table__data ">${row.no}</td>
            <td class="table__data ">${row.nama_siswa_a}</td>
            <td class="table__data ">${row.nama_mapel_a}</td>
            <td class="table__data ">${row.waktu}</td>
            <td class="table__data ">${row.tanggal}</td>
            <td class="table__data ">${row.keterangan_a}</td>
            <td class="table__data "><a class='edit__btn btn' href='../view/viewEdit.php?tabel=presensi&presensi_id=${row.id_absen}'>EDIT</a></td>
            <td class="table__data "><a class='delete__btn btn' href='../query/query_delete.php?tabel=presensi&id=${row.id_absen}'>DELETE</a></td>
        </tr>
        `; 
        });
    }
    tBody.innerHTML = rows;

    const table = document.querySelector(`#table-${tableType}`);
    if (table) {
        table.classList.remove('skeleton-loader'); 
    }
}

// PAGINATION
let currentPage = 1;
const rowsPerPage = 5;