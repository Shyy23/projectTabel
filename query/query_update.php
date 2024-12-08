<?php
session_start();
include '../koneksi/koneksi.php';
date_default_timezone_set('Asia/Jakarta');

function updateData($conn, $sql, $types, $params, $redirectUrl, $editUrl){
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param($types, ...$params); // Gunakan ... untuk menguraikan array
        if($stmt->execute()){
            $_SESSION['message'] = "Data berhasil diupdate";
            header("Location: $redirectUrl");
            exit;
        } else {
            $_SESSION['message'] = "Gagal Memperbarui Data: ". $stmt->error;
            header("Location: $editUrl");
            exit;
        }
    } else {
        $_SESSION['message'] = "Query Error: " . $conn->error;
        header("Location: $editUrl"); // Redirect ke halaman edit jika terjadi error pada query
        exit;
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['id_siswa'])){
        // Update Siswa
        $id_siswa = $_POST['id_siswa'];
        
        $query_siswa = "UPDATE siswa SET nama = ?, jenis_kelamin = ?, id_kelas = ?, alamat = ? WHERE id_siswa = ?";
        $types = "ssisi";
        $params = [$_POST['nama'], $_POST['jenis_kelamin'], $_POST['kelas'], $_POST['alamat'], $id_siswa];
        $redirectUrl = "../viewTabel/TabelSiswa.php";
        $editUrl = "../view/viewEdit.php?tabel=siswa&siswa_id=".$id_siswa;
        updateData($conn, $query_siswa, $types, $params, $redirectUrl, $editUrl);
         
    } else if(isset($_POST['id_guru'])){
        // Update Guru
        $id_guru = $_POST['id_guru'];
        $query_guru = "UPDATE guru SET nama = ?, jenis_kelamin = ?, id_mapel = ?, id_kelas = ?, alamat = ? WHERE id_guru = ?";
        $types = "ssiisi";
        $params = [$_POST['nama'],$_POST['jenis_kelamin'],$_POST['mapel'], $_POST['kelas'], $_POST['alamat'], $id_guru];
        $redirectUrl = "../viewTabel/TabelGuru.php";
        $editUrl = "../view/viewEdit.php?tabel=guru&guru_id=".$id_guru;
        updateData($conn, $query_guru, $types, $params, $redirectUrl, $editUrl);
    
    } else if(isset($_POST['id_jadwal'])){
        // Update Jadwal
        $id_jadwal = $_POST['id_jadwal'];
        $query_jadwal = "UPDATE jadwal SET id_hari = ?, id_guru = ?, id_kelas = ?, id_mapel = ?, jam_mulai = ?, jam_selesai = ? WHERE id_jadwal = ?";
        $types = "iiiissi";
        $params = [$_POST['hariJ'], $_POST['guruJ'], $_POST['kelasJ'], $_POST['mapelJ'], $_POST['jam_mulai'], $_POST['jam_selesai'], $id_jadwal];
        $redirectUrl = "../viewTabel/TabelJadwal.php";
        $editUrl = "../view/viewEdit.php?tabel=jadwal&jadwal_id=".$id_jadwal;
        updateData($conn, $query_jadwal, $types, $params, $redirectUrl, $editUrl);
        
    } else if(isset($_POST['id_absen'])){
        // Update Absen
        $id_absen = $_POST['id_absen'];
        $query_absen = "UPDATE absen SET keterangan = ?, waktu = ?, tanggal = ? WHERE id_absen = ?";
        $types = "sssi";
        $params = [$_POST['ket'], date('H:i'), date('Y-m-d'), $id_absen];
        $redirectUrl = "../viewTabel/TabelAbsen.php";
        $editUrl = "../view/viewEdit.php?tabel=absen&absen_id=".$id_absen;
        updateData($conn, $query_absen, $types, $params, $redirectUrl, $editUrl);

    } else {
        echo "Data Tidak terkirim";
    }
}
?>
