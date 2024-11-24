<?php
include '../koneksi/koneksi.php';
date_default_timezone_set('Asia/Jakarta');

function fetchData($conn, $sql, $key1 = 'id', $key2 = 'nama'){
    $data = [];
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            $data[] = ['value'=>$row[$key1], 'label'=>$row[$key2]];
        }
    } else {
        $data[] = ['value'=> 'default', 'label' => 'Data tidak ditemukan'];
    }

    return $data;
}

// QUERY

$sql_kelass = "SELECT id_kelas, nama_kelas FROM vKelas ORDER BY id_kelas";
$kelass_data = fetchData($conn, $sql_kelass, 'id_kelas', 'nama_kelas' );


$sql_hari = "SELECT * FROM hari ORDER BY id_hari";
$hari_data = fetchData($conn, $sql_hari, 'id_hari', 'nama_hari');

$sql_mapel = "SELECT * FROM mapel ORDER BY id_mapel";
$mapel_data = fetchData($conn, $sql_mapel, 'id_mapel','nama_mapel'); 

$sql_guruu = "SELECT id_guru, nama_guru_g FROM vGuru ORDER BY id_guru";
$guru_data = fetchData($conn, $sql_guruu, 'id_guru', 'nama_guru_g');

$sql_siswaa = "SELECT id_siswa, nama FROM siswa ORDER BY id_siswa";
$siswa_data = fetchData($conn, $sql_siswaa, 'id_siswa', 'nama'); 

$sql_jadAbsen = "SELECT * FROM vJadAbsen ORDER BY id_jadwal";
$jadAbsen_data = fetchData($conn, $sql_jadAbsen, 'id_jadwal', 'nama_mapel');

$sql_keterangan = "SELECT DISTINCT keterangan_a, keterangan FROM vAbsen ORDER BY keterangan";
$keterangan_data = fetchData($conn, $sql_keterangan, 'keterangan', 'keterangan_a');

$tabel = isset($_GET['tabel']) ? htmlspecialchars($_GET['tabel'], ENT_QUOTES, 'UTF-8') : '';
$formFields=[];

$dataSources= [
  'kelas'=>$kelass_data,
  'hari'=>$hari_data,
  'mapel'=>$mapel_data,
  'guru'=>$guru_data,
  'siswa'=>$siswa_data,
  'jadAbsen'=>$jadAbsen_data,
  'keterangan'=>$keterangan_data,
];
function getFields($tabel, $dataSources){
switch($tabel){
case 'siswa':
    return [
        'nisn' => ['label' => 'NISN', 'type' => 'text'],
        'nama_siswa' => ['label' => 'Nama Siswa', 'type' => 'text'],
        'jenis_kelamin' => ['label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['L' => 'Laki Laki', 'P' => 'Perempuan']],
        'alamat' => ['label' => 'Alamat', 'type' => 'text'],
        'kelas' => ['label' => 'Kelas', 'type' => 'select', 'options' => $dataSources['kelas']],
        'no_telepon' => ['label' => 'No Telepon', 'type' => 'text', ],
        'password' => ['label' => 'Password', 'type' => 'password']

    ];
case 'guru':
    return [
        'nip' => ['label' => 'NIP', 'type' => 'text'],
        'nama_guru' => ['label' => 'Nama Guru', 'type' => 'text'],
        'jenis_kelamin' => ['label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['L' => 'Laki Laki', 'P' => 'Perempuan']],
        'mapel' => ['label' => 'Mapel', 'type' => 'select', 'options' => $dataSources['mapel']],
        'alamat' => ['label' => 'Alamat', 'type' => 'text'],
        'password' => ['label' => 'Password', 'type' => 'password']
    ];
case 'jadwal':
    return [
        'hari' => ['label' => 'Hari', 'type' => 'select', 'options' => $dataSources['hari']],
        'guru' => ['label' => 'Guru', 'type' => 'select', 'options' => $dataSources['guru']],
        'kelas' => ['label' => 'Kelas', 'type' => 'select', 'options' => $dataSources['kelas']],
        'mapel' => ['label' => 'Mata Pelajaran', 'type' => 'select', 'options' => $dataSources['mapel']],
        'jam_mulai' => ['label' => 'Jam Mulai', 'type' => 'time', 'auto' => 'false'],
        'jam_selesai' => ['label' => 'Jam Selesai', 'type' => 'time', 'auto' => 'false']
    ];
case 'presensi':
    return [
        'siswa' => ['label' => 'Nama Siswa', 'type' => 'select', 'options' => $dataSources['siswa']],
        'jadwal' => ['label' => 'Mapel', 'type'=> 'select', 'options'=> $dataSources['jadAbsen']],
        'waktu' => ['label' => 'Waktu', 'type'=> 'time', 'auto'=>'true'],
        'tanggal' => ['label'=> 'Tanggal', 'type'=>'date', 'auto'=>'true'],
        'keterangan' => ['label'=> 'Keterangan', 'type'=> 'select', 'options'=>$dataSources['keterangan']],
    ];
 default:
 die('tabel tidak ditemukan.');
}
}

$formFields = getFields($tabel, $dataSources);
?>

