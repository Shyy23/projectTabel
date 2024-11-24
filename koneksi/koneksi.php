<?php 
$conn = new mysqli("localhost", "root", "", "presensi_syahrull");
if($conn->connect_error){
    die("Koneksi Gagal" . $conn->connect_error);
}
?>