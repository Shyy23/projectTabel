<?php
include '../koneksi/koneksi.php';
function selectQuery($conn, $sql){
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
// Query untuk data tabel siswa

// Main Query View
$sql_siswa = "SELECT * FROM vSiswa ORDER BY id_siswa" ;
$result_siswa = selectQuery($conn, $sql_siswa);

$sql_guru = "SELECT * FROM vGuru ORDER BY id_guru";
$result_guru = selectQuery($conn, $sql_guru);

$sql_jadwal = "SELECT * FROM vJadwal ORDER BY id_hari";
$result_jadwal = selectQuery($conn,$sql_jadwal);

$sql_absen = "SELECT * FROM vAbsen ORDER BY id_absen";
$result_absen = selectQuery($conn, $sql_absen);

?>