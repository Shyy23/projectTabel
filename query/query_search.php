<?php
include '../koneksi/koneksi.php';


function cari($conn, $tabel, $cols, $keyword){
$conditions = array_map( function($col){
    return "$col LIKE ?";
},$cols);

$sql = "SELECT * FROM $tabel WHERE " . implode(' OR ', $conditions);
$stmt = $conn->prepare($sql);

$likeKeyword = "%{$keyword}%";
$params = array_fill(0, count($cols), $likeKeyword);

$stmt->bind_param(str_repeat("s", count($cols)),...$params);
$stmt->execute();
$result = $stmt->get_result();
return $result;
}

// Handle search ketika dikirim melalui form
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])){
    $keyword = $_POST['search'];

// Kolom yang akan dicari
$cols_siswa = ['nama', 'jenis_kelamin', 'nama_kelas_s', 'alamat', 'nisn', 'no_telepon'];
$cols_guru = ['nama_guru_g', 'jenis_kelamin', 'nama_mapel_g', 'alamat_guru_g', 'nip'];
$cols_jadwal = ['jam_mulai', 'jam_selesai', 'nama_hari_j', 'nama_guru_j', 'nama_kelas_j', 'nama_mapel_j'];
$cols_absen = ['nama_siswa_a', 'nama_mapel_a', 'waktu', 'tanggal', 'keterangan_a'];

$result_siswa = cari($conn, 'vSiswa', $cols_siswa, $keyword);
$result_guru = cari($conn, 'vGuru', $cols_guru, $keyword);
$result_jadwal = cari($conn, 'vJadwal', $cols_jadwal, $keyword);
$result_absen = cari($conn, 'vAbsen', $cols_absen, $keyword);

// data dari tabel
$data =
[
    'siswa' => [],
    'guru' => [],
    'jadwal' => [],
    'absen' => [],
];

$no= 1;
// mengumpulkan hasil setiap tabel
while($row = $result_siswa->fetch_assoc()){
    $row['no'] = $no++;
    $data['siswa'][] = $row;
}
while($row = $result_guru->fetch_assoc()){
    $row['no'] = $no++;
    $data['guru'][] = $row;
}
while($row = $result_jadwal->fetch_assoc()){
    $row['no'] = $no++;
    $data['jadwal'][] = $row;
}
while($row = $result_absen->fetch_assoc()){
    $row['no'] = $no++;
    $data['absen'][] = $row;
}

echo json_encode($data);
}


?>