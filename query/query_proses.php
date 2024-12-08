<?php
session_start();

include '../koneksi/koneksi.php';
date_default_timezone_set('Asia/Jakarta');

function redirectWithMessage($message, $location){
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit;
}

function insertData($sql, $params, $types){
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    return $stmt->execute();
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $tabel = $_POST['tabel'] ?? '';


switch ($tabel) {
    // Siswa
        case 'siswa':
            $nisn = $_POST['nisn'];
            $nama = $_POST['nama_siswa'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $alamat = $_POST['alamat'];
            $id_kelas = $_POST['kelas'];
            $no_telepon = $_POST['no_telepon'];
            $password = $_POST['password'];

            if ($nisn && $nama && $jenis_kelamin && $alamat && $id_kelas && $no_telepon && $password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql_insert = "INSERT INTO siswa (nisn, nama, jenis_kelamin, alamat, id_kelas, no_telepon, password) VALUES (?,?,?,?,?,?,?)";
                if (insertData($sql_insert, [$nisn, $nama, $jenis_kelamin, $alamat, $id_kelas, $no_telepon, $hashed_password], "ssssiss")) {
                    redirectWithMessage("Data berhasil ditambahkan.", "../viewTabel/TabelSiswa.php");
                } else {
                    redirectWithMessage("Gagal menambahkan data.", "../view/viewAdd.php?tabel=siswa");
                }
            } else {
                echo "Harap isi semua field";
            }
            break;
    // Guru
            case 'guru':
                $nip = $_POST['nip'];
                $nama = $_POST['nama_guru'];
                $jenis_kelamin = $_POST['jenis_kelamin'];
                $id_mapel = $_POST['mapel'];
                $alamat = $_POST['alamat'];
                $password = $_POST['password'];
                $id_kelas = $_POST['kelas'];
    
                if ($nip && $nama && $jenis_kelamin && $id_mapel && $alamat && $password) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql_insert = "INSERT INTO guru (nip, nama, jenis_kelamin, id_mapel, id_kelas, alamat, password) VALUES (?,?,?,?,?,?,?)";
                    if (insertData($sql_insert, [$nip, $nama, $jenis_kelamin, $id_mapel, $id_kelas, $alamat, $hashed_password], "sssiiss")) {
                        redirectWithMessage("Data berhasil ditambahkan.", "../viewTabel/TabelGuru.php");
                    } else {
                        redirectWithMessage("Gagal menambahkan data.", "../view/viewAdd.php?tabel=guru");
                    }
                } else {
                    echo "Harap isi semua field";
                }
                break;
    // Jadwal 
                case 'jadwal':
                    $id_hari = $_POST['hari'];
                    $id_guru = $_POST['guru'];
                    $id_kelas = $_POST['kelas'];
                    $id_mapel = $_POST['mapel'];
                    $jam_mulai = $_POST['jam_mulai'];
                    $jam_selesai = $_POST['jam_selesai'];
        
                    if ($id_hari && $id_guru && $id_kelas && $id_mapel && $jam_mulai && $jam_selesai) {
                        $sql_insert = "INSERT INTO jadwal (id_hari, id_guru, id_kelas, id_mapel, jam_mulai, jam_selesai) VALUES (?,?,?,?,?,?)";
                        if (insertData($sql_insert, [$id_hari, $id_guru, $id_kelas, $id_mapel, $jam_mulai, $jam_selesai], "iiiiss")) {
                            redirectWithMessage("Data berhasil ditambahkan.", "../viewTabel/TabelJadwal.php");
                        } else {
                            redirectWithMessage("Gagal menambahkan data.", "../view/viewAdd.php?tabel=jadwal");
                        }
                    } else {
                        echo "Harap isi semua field";
                    }
                    break;
    // Presensi
                case 'presensi':
                    $id_siswa = ($_SESSION['role'] === 'user') ? $_SESSION['id_sg'] : ($_SESSION['role'] === 'admin' ? ($_POST['siswa'] ?? '') : '');
                    $id_jadwal = $_POST['jadwal'];
                    $waktu = $_POST['waktu'];
                    $tanggal = $_POST['tanggal'];
                    $keterangan = $_POST['keterangan'];
                    $jadwal_id = $_POST['jadwal_id'] ?? '';

                    if ($id_siswa && $id_jadwal && $waktu && $tanggal && $keterangan) {
                        $sql_insert = "INSERT INTO absen (id_siswa, id_jadwal, waktu, tanggal, keterangan) VALUES (?,?,?,?,?)";
                        if (insertData($sql_insert, [$id_siswa, $id_jadwal, $waktu, $tanggal, $keterangan], "iisss")) {
                           
                                redirectWithMessage("Data berhasil ditambahkan.", "../viewTabel/TabelAbsen.php");
                        } else {
                            redirectWithMessage("Gagal menambahkan data.", "../viewAdd.php?tabel=presensi");
                        }
                    } else {
                        echo "Harap isi semua field";
                    }
                break;
            }
    }
?>