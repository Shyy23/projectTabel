<?php
session_start();
include '../koneksi/koneksi.php';


// Ambil tabel dan ID dari parameter GET
$tabel = isset($_GET['tabel']) ? $_GET['tabel'] : null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$originalTable = $tabel;

// Pemetaan tabel jika diperluka
// Validasi parameter
if ($tabel && $id) {
    // Tentukan nama kolom primary key untuk masing-masing tabel
    $primaryKeys = [
        'siswa' => 'id_siswa',
        'guru' => 'id_guru',
        'absen' => 'id_absen',
        'jadwal' => 'id_jadwal',
    ];

    // Cek apakah tabel valid
    if (array_key_exists($tabel, $primaryKeys)) {
        // Primary key sesuai tabel
        $primaryKey = $primaryKeys[$tabel];

        // Query untuk menghapus data
        $sql = "DELETE FROM $tabel WHERE $primaryKey = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        // Eksekusi query
        if ($stmt->execute()) {
            $_SESSION['message'] = "Data dari tabel $originalTable berhasil dihapus.";
            header("Location: ../viewTabel/Tabel".ucfirst($originalTable).".php");
            
        } else {
            echo "Gagal menghapus data: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Tabel tidak valid.";
    }
} else {
    echo "Parameter tabel atau ID tidak ditemukan.";
}

// Tutup koneksi
$conn->close();




?>