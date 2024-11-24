<?php
try{
    $pdo = new PDO("mysql:host=localhost;dbname=presensi_syahrull", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo "koneksi gagal: ".$e->getMessage();
    exit();
}
?>