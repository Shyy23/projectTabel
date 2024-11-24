<?php
include '../koneksi/koneksi.php';
function selectQuery($conn, $tabel, $col){
    $sql = "SELECT * FROM $tabel ORDER BY $col";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
// Query untuk data tabel siswa

// Main Query View
$sql_siswa = selectQuery($conn, 'vSiswa', 'id_siswa');
$sql_guru = selectQuery($conn, 'vGuru', 'id_guru');
$sql_jadwal = selectQuery($conn,'vJadwal', 'id_hari');
$sql_absen = selectQuery($conn, 'vAbsen', 'id_absen');

// Additional Query
$sql_kelass = selectQuery($conn, 'vKelas', 'id_kelas');
$sql_kelas = selectQuery($conn, 'kelas', 'id_kelas');
$sql_siswaa = selectQuery($conn, 'siswa', 'id_siswa');
$sql_mapel = selectQuery($conn, 'mapel', 'id_mapel');
$sql_guruu = selectQuery($conn, 'guru', 'id_guru');
$sql_hari = selectQuery($conn, 'hari', 'id_hari');
$sql_absenn = selectQuery($conn, 'absen', 'id_absen');


?>