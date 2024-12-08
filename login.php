<?php
session_start();
include "koneksi/koneksi.php";


if (isset($_SESSION['user_id'])) {
    // Jika sudah login, arahkan ke dashboard
    header('Location: home.php');
    exit();
}


if (isset($_SESSION['message'])) {
    echo "
    <div id='alert' class='alert'>
        <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span> 
        {$_SESSION['message']}
    </div>";
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- ================= FONT AWESOME ===================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css?v=<?php echo time();?>">

    <!-- ================= CSS ===================== -->
    <link rel="stylesheet" href="dist/css/crud.css?v=<?= filemtime('dist/css/crud.css')?>">
    <link rel="stylesheet" href="dist/css/login.css?v=<?= filemtime('dist/css/login.css')?>">
</head>
<body>
    <div class="form__container__login">
        <div class="col col-1">
            <div class="text-content">
            <h2 class="title">Yo Hallo</h2>
            <span class="description">Login Untuk melanjutkan atau Hubungi Admin untuk info akun</span>    
            </div>
            <div class="image__layer">
                <img src="assets/login/img/char.png" alt="image" class="form-image char">
            </div>
            
        </div>
        <div class="col col-2">
            <!-- Login Form -->
            <div class="login__form" id="login-form">
                <div class="form__title">
                    <span>Sign In</span>
                </div>
                <form method="POST" action="query/query_login.php" class="form__inputs">
                    <div class="input__box">
                        <input type="text"  class="input__field" placeholder="Username / NISN" id="username" name="username" required>
                        <i class="fa-solid fa-user icon"></i>
                    </div>
                    <div class="input__box">
                        <input type="password" placeholder="Password" name="password" id="password" class="input__field" required>
                        <i class="fa-solid fa-lock icon"></i>
                    </div>
                    <div class="forget__pass">
                        <a href="#">forget Password?</a>
                    </div>
                    <div class="input__box">
                        <button type="submit" class="input__submit">
                            <span>Sign In</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="dist/js/login.js?v=<?= filemtime('dist/js/login.js')?>"></script>
</body>
</html>