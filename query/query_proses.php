<?php
session_start();

include '../koneksi/koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $tabel = isset($_POST['tabel']) ? $_POST['tabel'] : '';

switch($tabel){
    case 'siswa':
        $nisn = $_POST['nisn'];
        $nama = $_POST['nama_siswa'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $id_kelas = $_POST['kelas'];
        $no_telepon = $_POST['no_telepon'];
        $password = $_POST['password'];

        if($nisn && $nama && $jenis_kelamin && $alamat && $id_kelas && $no_telepon && $password){

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO siswa (nisn, nama, jenis_kelamin, alamat, id_kelas, no_telepon, `password`) VALUES
            (?,?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("ssssiss", $nisn, $nama, $jenis_kelamin, $alamat, $id_kelas, $no_telepon, $hashed_password);

            if($stmt->execute()){
                   $_SESSION['message'] = "Data berhasil ditambahkan.";
                header("Location: ../viewTabel/TabelSiswa.php");
            } else {
                $_SESSION['message'] = "Gagal menambahkan data.";
            }
        } else {
            echo "Harap isi semua field";
        }
        break;
    case 'guru':
        $nip = $_POST['nip'];
        $nama = $_POST['nama_guru'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $id_mapel = $_POST['mapel'];
        $alamat = $_POST['alamat'];
        $password = $_POST['password'];

        if($nip && $nama && $jenis_kelamin && $jenis_kelamin && $id_mapel && $alamat && $password){

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO guru (nip, nama, jenis_kelamin, id_mapel, alamat, `password`) VALUES
            (?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("sssiss", $nip, $nama, $jenis_kelamin, $id_mapel, $alamat, $hashed_password);

            if($stmt->execute()){
                $_SESSION['message'] = "Data berhasil ditambahkan.";
                header("Location:../table.php");
                exit;
            } else {
                $_SESSION['message'] = "Gagal menambahkan data.";
            }
        } else {
            echo "Harap isi semua field";
        }
        break;
    case 'jadwal':
        $id_hari = $_POST['hari'];
        $id_guru = $_POST['guru'];
        $id_kelas = $_POST['kelas'];
        $id_mapel = $_POST['mapel'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];

        if($id_hari && $id_guru && $id_kelas && $id_mapel && $jam_mulai && $jam_selesai){

            $sql_insert = "INSERT INTO jadwal (id_hari, id_guru, id_kelas, id_mapel, jam_mulai, jam_selesai) VALUES
            (?,?,?,?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("iiiiss", $id_hari, $id_guru, $id_kelas, $id_mapel, $jam_mulai, $jam_selesai);
            if($stmt->execute()){
                   $_SESSION['message'] = "Data berhasil ditambahkan.";
                header("Location:../table.php");
                exit;
            }else{
                $_SESSION['message'] = "Gagal menambahkan data.";
            }
        }else{
            echo "Harap isi semua field";
        }
        break;
        case 'presensi':
            $id_siswa = $_POST['siswa'];
            $id_jadwal = $_POST['jadwal'];
            $waktu = $_POST['waktu'];
            $tanggal = $_POST['tanggal'];
            $keterangan = $_POST['keterangan'];
            
            if($id_siswa && $id_jadwal && $waktu && $tanggal && $keterangan){
                $sql_insert = "INSERT INTO absen (id_siswa, id_jadwal, waktu, tanggal, keterangan) VALUES 
                (?,?,?,?,?)";

                $stmt = $conn->prepare($sql_insert);
                $stmt->bind_param("iisss", $id_siswa, $id_jadwal, $waktu, $tanggal, $keterangan);
                if($stmt->execute()){
                       $_SESSION['message'] = "Data berhasil ditambahkan.";
                    header("Location:../table.php");
                    exit;
                }else{
                    $_SESSION['message'] = "Gagal menambahkan data.";
                }
            }else{
                echo "Harap isi semua field";
            }
}
}
?>