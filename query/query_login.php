<?php
session_start();
include '../koneksi/koneksi.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM vuser WHERE (username = ? OR nomor_induk = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_type'] = $user['user_type'];
        $user_type = $_SESSION['user_type'];
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['id_sg'] = ($user_type == 'siswa') ? $user['id_user_siswa'] :
                             (($user_type == 'guru') ? $user['id_user_guru'] : 'id tidak dikenal');
        $_SESSION['jurusan'] = $user['jurusan'];
        $_SESSION['role'] = $user['role_name'];
        $_SESSION['nomor_induk'] = $user['nomor_induk'];
        $_SESSION['nama'] =  $user['username'];            // Pastikan nama_kelas ada dalam data user
        $_SESSION['id_kelas'] = $user['id_kelas'];
        $_SESSION['kelas'] = isset($user['nama_kelas']) ? $user['nama_kelas'] : 'Tidak Diketahui';                  
        // var_dump($user);


        header("Location: ../home.php");
        $_SESSION['message'] = "Berhasil Login";
        
        exit();
    } else {
        header('Location: ../login.php');
        $_SESSION['message'] = "Gagal Login Periksa Kata sandi dan Username";
        exit();
    };
}

?>