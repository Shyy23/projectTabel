<?php
session_start();
include '../koneksi/koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if($_SERVER["REQUEST_METHOD"]== "POST"){
    if(isset($_POST['id_siswa'])){
        // Ambil data
        $id_siswa = $_POST['id_siswa'];
        $nama_siswa = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $id_kelas = $_POST['kelas'];
        $alamat = $_POST['alamat'];

        // Update data
        $query = "UPDATE siswa SET nama = ?, jenis_kelamin = ?, id_kelas = ?, alamat = ? WHERE id_siswa = ?";
        if($stmt = $conn->prepare($query)){
            $stmt->bind_param("ssisi", $nama_siswa, $jenis_kelamin, $id_kelas, $alamat, $id_siswa);
            if($stmt->execute()){
                $_SESSION['message'] = "Data Berhasil diedit";
                header("Location: ../viewTabel/TabelSiswa.php");
                exit;
            } else {
                $_SESSION['message'] = "Gagal Memperbarui Data";
            }
        }
    } else if(isset($_POST['id_guru'])){
        // Ambil Data
        $id_guru = $_POST['id_guru'];
        $nama_guru = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $id_mapel = $_POST['mapel'];
        $alamat = $_POST['alamat'];

        // Update data
        $query = "UPDATE guru SET nama = ?, jenis_kelamin = ?, id_mapel = ?, alamat = ? WHERE id_guru = ?";
        if($stmt = $conn->prepare($query)){
            $stmt->bind_param("ssisi", $nama_guru, $jenis_kelamin, $id_mapel, $alamat, $id_guru);
            if($stmt->execute()){
                $_SESSION['message'] = "Data Berhasil diedit";
                header("Location:../viewTabel/TabelGuru.php");
                exit;
            } else{
                $_SESSION['message'] = "Gagal Memperbarui Data";
            }
    }
} else if(isset($_POST['id_jadwal'])){
    // Ambil data
    $id_jadwal = $_POST['id_jadwal'];
    $id_hari = $_POST['hariJ'];
    $id_guru = $_POST['guruJ'];
    $id_kelas = $_POST['kelasJ'];
    $id_mapel = $_POST['mapelJ'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    

    $query = "UPDATE jadwal SET id_hari = ?, id_guru = ?, id_kelas = ?, id_mapel = ?, jam_mulai = ?, jam_selesai = ? WHERE id_jadwal = ?";
    if($stmt = $conn->prepare($query)){
        $stmt->bind_param("iiiissi", $id_hari, $id_guru, $id_kelas, $id_mapel, $jam_mulai, $jam_selesai, $id_jadwal);
        if($stmt->execute()){
            $_SESSION['message'] = "Data Berhasil diedit";
            header("Location:../viewTabel/TabelJadwal.php");
            exit;
        } else {
            $_SESSION['message'] = "Gagal Memperbarui Data";
        }
    }
} else if(isset($_POST['id_absen'])){
    // Ambil data
    $id_absen = $_POST['id_absen'];
    $keterangan = $_POST['ket'];
    $waktu = date('H:i');
    $tanggal = date('Y-m-d');

    echo "ID Absen: $id_absen <br>";
    echo "Keterangan: $keterangan <br>";
    echo "Waktu: $waktu <br>";
    echo "Tanggal: $tanggal <br>";

    $query = "UPDATE absen SET keterangan = ?, waktu = ?, tanggal = ? WHERE id_absen = ?";
    if($stmt = $conn->prepare($query)){
        $stmt->bind_param("sssi", $keterangan, $waktu, $tanggal, $id_absen);
        if($stmt->execute()){
            $_SESSION['message'] = "Data Berhasil diedit";
            header("Location: ../viewTabel/TabelPresensi.php");
            die();

        } else{
            echo "Execute Error: " . $stmt->error;
            $_SESSION['message'] = "Gagal Memperbarui Data";
        }
    } else {
        $_SESSION['message'] = "Query Error: " . $conn->error;
    }
    
}  
} else {
    echo "Data Tidak terkirim";
}
?>