<?php
session_start();
include "../koneksi/koneksi.php";


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
    <title>Data Guru</title>
  
    <!-- ================= FAVICON ===================== -->
    <link rel="shortcut icon" href="../assets/icon/guru/favicon.ico" type="image/x-icon">

    <!-- ================= FONT AWESOME ===================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css?v=<?php echo time();?>">
    <!-- ================= REMIXICON ===================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css?v=<?php echo time();?>">
        
    <!-- ================= Hamburgers ===================== -->
    <link rel="stylesheet" href="../dist/css/hamburgers.css">
    
    <!-- ================= SWIPER CSS ===================== -->
    <link rel="stylesheet" href="../dist/css/swiper-bundle.min.css">

    <!-- ================= CSS ===================== -->
    <link rel="stylesheet" href="../setup/setup.css?v=<?php echo time();?>">
    <link rel="stylesheet" href="../dist/css/table.css?v=<?php echo time();?>">
</head>
<body id="main_guru">
            <!-- ================= HEADER ===================== -->

            <header class="header" id="header">
                <div class="header__container">
                    <a href="" class="header__logo">
                        <i class="fa-solid fa-cloud"></i>
                        <span>cloud</span>
                    </a>
        
                    <div class="header__actions">
                        <i class="fa-regular fa-bell"></i>
                        <i class="ri-account-circle-line"></i>
        
                        <button class="hamburger hamburger--elastic header__toggle" type="button" id="header-toggle">
                            <span class="hamburger-box">
                              <span class="hamburger-inner"></span>
                            </span>
                          </button>
                    </div>
        
                </div>
        
                <form action="" method="POST" class="header__search" id="header-search">
                <input type="hidden" name="tabel" id="table-search-type" value="guru">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="search" placeholder="search" class="header__input" id="search" autocomplete="false" >
                </form>
            </header>
            <!-- ================= SIDEBAR ===================== -->
            <nav class="sidebar" id="sidebar">
                <div class="sidebar__container">
                    <div class="sidebar__user b-bot">
                        <div class="sidebar__image">
                            <img src="../assets/img/pp.jpg" alt="image" class="sidebar__img">
                        </div>
        
                        <div class="sidebar__info">
                            <h3 class="sidebar__name"><?= $_SESSION['nama'];?></h3>
                            <span class="sidebar__email"><?= $_SESSION['nomor_induk'];?></span>
                        </div>
                    </div>
        
                    <div class="sidebar__content">
                        <div>
                            <h3 class="sidebar__title">MANAGE</h3>
                            <div class="sidebar__list b-bot">
                                
                            <a href="../home.php" class="sidebar__link ">
                                <i class="fa-solid fa-chart-pie"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="TabelSiswa.php" class="sidebar__link ">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>Data Siswa</span>
                            </a>
                            <a href="" class="sidebar__link active-link">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <span>Data Guru</span>
                            </a>
                            <a href="TabelJadwal.php" class="sidebar__link">
                                <i class="fa-solid fa-calendar-days"></i>  
                                <span>Data Jadwal</span>
                            </a>
                            <a href="TabelAbsen.php" class="sidebar__link">
                                <i class="fa-solid fa-clipboard-user"></i>
                                <span>Data Presensi</span>
                            </a>
                            <a href="" class="sidebar__link">
                                <i class="fa-regular fa-file"></i>
                                <span>Portfolio</span>
                            </a>
                            </div>
                        </div>
        
                        <div>
                            <h3 class="sidebar__title">SETTINGS</h3>
                            <div class="sidebar__list">
                                
                                <a href="#" class="sidebar__link">
                                    <i class="fa-solid fa-gear"></i>
                                    <span>Setting</span>
                                </a>
                                <a href="#" class="sidebar__link">
                                    <i class="fa-solid fa-envelope-circle-check"></i>
                                    <span>My Messages</span>
                                </a>
                                <a href="#" class="sidebar__link">
                                    <i class="fa-solid fa-bell"></i>
                                    <span>Notification</span>
                                </a>
                            </div>
                        </div>
                    </div>
        
                    <div class="sidebar__actions">
                        <button>
                            <i class="ri-moon-clear-fill sidebar__link sidebar__theme" id="theme-button">
                                
                                <span>Theme</span>
                            </i>
                        </button>
        
                    <button class="sidebar__link" onclick="window.location.href='../logout.php';">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Log Out</span>
                    </button>
                    </div>
                </div>
            </nav>

            <!-- ================= MAIN  ===================== -->
             <main class="main container" id="main">
                <div class="table">

               
                    <section class="table__header">
                        <div class="table__info">
                        <h1 class="title__table">Tabel Daftar Guru</h1>
                        </div>
                        <div class="table__fungsi">
                            <div class="pagination" id="pagination">
                                <a data-fungsi="prev" id="prev-page" href="" class="prev__page"><i class="fa-solid fa-angle-left"></i></a>
                                <div class="page__numbers" id="page-numbers">   </div>
                                <a data-fungsi="next" id="next-page" href="" class="next__page"><i class="fa-solid fa-angle-right"></i></a>
                            </div>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a  data-fungsi="add" href="../view/viewAdd.php?tabel=guru" class="add-btn"><i class="fa-solid fa-plus"></i></a>
                            <?php endif;?>    
                            <div class="export__file">
                                <label data-fungsi="export" for="export-file" class="fungsi"><i class="fa-solid fa-file-pdf"></i></label>
                                <input type="checkbox" id="export-file" name="export-file">
                                <div class="export__file-options">
                                    <label>Export As &nbsp; &#10140;</label>
                                    <label for="export-file" id="toPDF" onclick="window.print()">PDF <i class="fa-solid fa-file-pdf"></i></label>
                                    <label for="export-file">PDF <i class="fa-solid fa-file-pdf"></i></label>
                                    <label for="export-file">PDF <i class="fa-solid fa-file-pdf"></i></label>
                                    <label for="export-file">PDF <i class="fa-solid fa-file-pdf"></i></label>
                                </div>
                            </div>                        </div>
                    </section>
                    <section class="table__body">
                        <table class="table__container" id="table-guru">
                        <thead class="table__head">
                                    <tr class="table__row">
                                        <th class="table__col">No</th>
                                        <th class="table__col" data-sort="nama_guru_g">Nama <i class="sort-icon"></i></th>
                                        <th class="table__col" data-sort="jenis_kelamin">Jenis Kelamin <i class="sort-icon"></i></th>
                                        <th class="table__col" data-sort="nama_mapel_g">Mapel <i class="sort-icon"></i></th>
                                        <th class="table__col" data-sort="alamat_guru_g">Alamat <i class="sort-icon"></i></th>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <th class="table__col">Edit</th>
                                        <th class="table__col">Delete</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class="table__body_1" id="table-body-guru">
                                    
                                </tbody>
                        </table>
                    </section>
                </div>
             

                </div>                        
             </main>
               <!-- ================= FOOTER ===================== -->
            <footer class="footer footer__bottom" id="footer">
                <div class="legal">
                    <span class="footer__CR">© 2024 All Right Shyy Reserved</span>
                </div>

                <div class="footer__social">
                    <a href="https://www.instagram.com/it.s_meshy_y?igsh=M2tvZmxnN3Bycml5" class="footer__social-links">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/+6283820103522" class="footer__social-links">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </footer>

    
    <script src="../dist/js/table.js?v=<?php echo time();?>"></script>
    <script src="../dist/js/global.js?v=<?php echo time();?>"></script>
    
</body>
</html>