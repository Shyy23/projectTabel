<?php
include '../koneksi/koneksi.php';
function fetchDataEdit($conn, $tabell = '', $colId, $id, $keys = []) {
    $validTables = ['vGuru', 'vSiswa', 'vJadwal', 'vAbsen']; // Tabel valid
    if (!in_array($tabell, $validTables)) {
        throw new Exception("Tabel tidak valid.");
    }

    $sql = "SELECT * FROM $tabell WHERE $colId = ?";
    $data = [];
    $defaultKeys = array_merge([$colId], $keys);
    $defaultValues = array_fill_keys($defaultKeys, '');

    // Siapkan statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparing SQL: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $entry = $defaultValues;
            foreach ($defaultKeys as $key) {
                $entry[$key] = isset($row[$key]) ? $row[$key] : '';
            }
            $data[] = $entry;
        }
    } else {
        $data[] = $defaultValues;
    }

    return $data;
}




function fetchSelected($conn, $sql, $key1 = '', $key2 = '', $selectedId = '') {
    $options = ''; // Variabel untuk menampung string opsi
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selected = ($row[$key1] == $selectedId) ? 'selected' : '';
                $options .= '<option class="option" value="' . htmlspecialchars($row[$key1]) . '" ' . $selected . '>'
                            . htmlspecialchars($row[$key2]) . '</option>';
            }
        } else {
            $options = '<option class="option" value="">Tidak ada data</option>';
        }
        $stmt->close();
    }
    return $options; // Mengembalikan opsi sebagai string
}

// QUERY
$sql_kelas = "SELECT * FROM vKelas ORDER BY id_kelas";
$sql_mapel = "SELECT * FROM mapel ORDER BY id_mapel";
$sql_hari = "SELECT * FROM hari ORDER BY id_hari";
$sql_guruJ = "SELECT * FROM vGuru ORDER BY id_guru";
$sql_keterangan = "SELECT DISTINCT keterangan_a, keterangan FROM vAbsen ORDER BY keterangan";

// Guru
$guru_id = isset($_GET['guru_id']) ? $_GET['guru_id'] : null;
$guru_data = fetchDataEdit($conn, 'vGuru', 'id_guru', $guru_id, ['nama_guru_g', 'alamat_guru_g', 'jenis_kelamin', 'id_mapel']);
$mapelId = $guru_data[0]['id_mapel'];
$selectedMapel = fetchSelected($conn, $sql_mapel, 'id_mapel', 'nama_mapel', $mapelId);


// var_dump($guru_data);
// $dataEditSources = [
//     'guru'=>$guru_data
// ];

// siswa
$siswa_id = isset($_GET['siswa_id']) ? $_GET['siswa_id'] : null;
$siswa_data = fetchDataEdit($conn, 'vSiswa', 'id_siswa', $siswa_id,['nama', 'alamat', 'jenis_kelamin', 'id_kelas']);

$kelasId = $siswa_data[0]['id_kelas'];
$selectedKelas = fetchSelected($conn, $sql_kelas, 'id_kelas', 'nama_kelas', $kelasId);

// Jadwal
$jadwal_id = isset($_GET['jadwal_id']) ? $_GET['jadwal_id'] : null;
$jadwal_data = fetchDataEdit($conn, 'vJadwal', 'id_jadwal', $jadwal_id, ['id_hari','jam_mulai','jam_selesai','id_guru','id_kelas','id_mapel'] );


$kelasJ = $jadwal_data[0]['id_kelas'];
$guruJ = $jadwal_data[0]['id_guru'];
$mapelJ = $jadwal_data[0]['id_mapel'];
$hariJ = $jadwal_data[0]['id_hari'];

$selectedKelasJ = fetchSelected($conn, $sql_kelas, 'id_kelas', 'nama_kelas', $kelasJ);
$selectedMapelJ = fetchSelected($conn, $sql_mapel, 'id_mapel', 'nama_mapel', $mapelJ);
$selectedGuruJ = fetchSelected($conn, $sql_guruJ, 'id_guru', 'nama_guru_g', $guruJ);
$selectedHariJ = fetchSelected($conn, $sql_hari, 'id_hari', 'nama_hari', $hariJ);

// Absen

$presensi_id = isset($_GET['absen_id']) ? $_GET['absen_id'] : '';
$presensi_data = fetchDataEdit($conn, 'vAbsen', 'id_absen', $presensi_id, ['nama_siswa_a','tanggal','nama_mapel_a','keterangan','keterangan_a','waktu']); 
$keterangan = $presensi_data[0]['keterangan'];
$selectedKet = fetchSelected($conn, $sql_keterangan, 'keterangan', 'keterangan_a', $keterangan);

$dataEditSources=[
    'guru'=>$guru_data,
    'siswa'=>$siswa_data,
    'jadwal'=> $jadwal_data,
    'presensi'=> $presensi_data
    ];
// var_dump($selectedMapel);
$tabel = isset($_GET['tabel']) ? htmlspecialchars($_GET['tabel'], ENT_QUOTES, 'UTF-8'): '';
$editFields=[];

function getEditFields($tabel, $dataEditSources){
    switch($tabel){
        case 'guru':
            return [
                'id_guru' => ['value'=> $dataEditSources['guru'], 'type'=>'hidden', 'label'=>'Id Guru'],
                'nama' => ['value'=>$dataEditSources['guru'], 'label' => 'Nama Guru', 'type'=>'text', 'status'=>'req', 'col'=>'nama_guru_g'],
                'jenis_kelamin' => ['value'=>$dataEditSources['guru'],'label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['L' => 'Laki-Laki', 'P' => 'Perempuan']],
                'mapel'=>['label'=>'Mapel', 'type'=>'select', 'col'=>'mapel'],
                'kelas'=>['label'=>'Kelas', 'type'=>'select', 'col'=>'kelas'],
                'alamat' => ['value'=>$dataEditSources['guru'], 'label' => 'Alamat', 'type'=>'text', 'status'=>'req', 'col'=>'alamat_guru_g'],
                
            ];
            case 'siswa':
                return [
                'id_siswa' => ['value' => $dataEditSources['siswa'], 'type' => 'hidden', 'label'=>'Id Siswa'],
                'nama' => ['value' => $dataEditSources['siswa'], 'label' => 'Nama Siswa', 'type' => 'text', 'status' => 'req', 'col'=>'nama'],
                'jenis_kelamin' => ['value'=>$dataEditSources['siswa'] , 'label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['L' => 'Laki-Laki', 'P' => 'Perempuan']],
                'kelas' => ['label' => 'Kelas', 'type' => 'select', 'col' => 'kelas'],
                'alamat' => ['value' => $dataEditSources['siswa'], 'label' => 'Alamat', 'type' => 'text', 'status' => 'req', 'col'=>'alamat'],            
            ];
            case 'jadwal':
                return [
                    'id_jadwal'=>['value'=>$dataEditSources['jadwal'], 'type'=>'hidden', 'label'=>'Id Jadwal'],
                    'hariJ'=>['label'=>'Hari', 'type'=>'select', 'col'=>'hariJ'],
                    'guruJ'=>['label'=>'Nama Guru', 'type'=>'select', 'col'=>'guruJ'],
                    'kelasJ'=>['label'=>'Kelas', 'type'=>'select', 'col'=>'kelasJ'],
                    'mapelJ'=>['label'=>'Mapel', 'type'=>'select','col'=>'mapelJ'],
                    'jam_mulai'=>['value'=>$dataEditSources['jadwal'], 'label' => 'Jam Mulai', 'type' => 'time', 'status'=>'req'],
                    'jam_selesai'=>['value'=>$dataEditSources['jadwal'], 'label'=>'Jam Selesai', 'type'=>'time', 'status'=>'req'],
                ];
            case 'absen':
                return [
                    'id_absen'=>['value' => $dataEditSources['presensi'], 'type'=>'hidden', 'label'=>'Id Absen'],
                    'nama'=>['value'=>$dataEditSources['presensi'], 'label'=>'Nama Siswa','type'=>'text', 'col' => 'nama_siswa_a', 'status' =>'read'],
                    'mapel'=>['value'=>$dataEditSources['presensi'], 'label'=>'Mapel','type'=>'text', 'col'=>'nama_mapel_a', 'status' => 'read'],
                    'waktu'=>['value'=>$dataEditSources['presensi'], 'label'=>'Waktu', 'type'=>'time', 'col'=>'waktu', 'status'=>'read'],
                    'tanggal'=>['value'=>$dataEditSources['presensi'], 'label'=>'Tanggal', 'type'=>'date', 'col'=>'tanggal', 'status'=>'read'],
                    'ket'=>['label'=>'Keterangan', 'type'=>'select', 'col'=>'ket', 'status'=>'req']
                ];
    }
}

$editFields = getEditFields($tabel, $dataEditSources);
// var_dump($editFields);

?>