<?php
session_start();
include "../koneksi/koneksi.php";
include "../query/query.php";
include "../query/query_search.php";

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
    <title>Data Jadwal</title>
  
    <!-- ================= FAVICON ===================== -->
    <link rel="shortcut icon" href="../assets/icon/jadwal/favicon.ico" type="image/x-icon">

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
<body>
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
                <input type="hidden" name="tabel" id="table-search-type" value="jadwal">
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
                            <h3 class="sidebar__name">Shyy</h3>
                            <span class="sidebar__email">Shyy23@gmail.com</span>
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
                            <a href="TabelGuru.php" class="sidebar__link ">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <span>Data Guru</span>
                            </a>
                            <a href="" class="sidebar__link  active-link">
                                <i class="fa-solid fa-calendar-days"></i>  
                                <span>Data Jadwal</span>
                            </a>
                            <a href="TabelPresensi.php" class="sidebar__link ">
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
        
                        <button class="sidebar__link">
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
                        <h1 class="title__table">Tabel Daftar Jadwal</h1>
                        </div>
                        <div class="table__fungsi">
                            <a  data-fungsi="add" href="../view/viewAdd.php?tabel=jadwal" class="add-btn"><i class="fa-solid fa-plus"></i></a>
                            <a  data-fungsi="print" href=""><i class="fa-solid fa-file-pdf"></i></a>
                        </div>
                    </section>
                    <section class="table__body">
                        <table class="table__container" id="table-jadwal">
                        <thead class="table__head">
                                    <tr class="table__row">
                                        <th class="table__col">No</th>
                                        <th class="table__col">Hari</th>
                                        <th class="table__col">Nama Guru</th>
                                        <th class="table__col">Kelas</th>
                                        <th class="table__col">Mapel</th>
                                        <th class="table__col">Jam Mulai</th>
                                        <th class="table__col">Jam Selesai</th>
                                        <th class="table__col">Edit</th>
                                        <th class="table__col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="table__body_1" id="table-body-jadwal">
                                        <?php
                                        if($result_jadwal->num_rows > 0){
                                            $no = 1;
        
                                            while($row = $result_jadwal->fetch_assoc()){
                                                echo "<tr class='table__row'>";
                                                echo "<td class='table__data'>" . $no++ . "</td>";
                                                echo "<td class='table__data'>" . $row['nama_hari_j'] . "</td>";
                                                echo "<td class='table__data'>" . $row['nama_guru_j'] . "</td>";
                                                echo "<td class='table__data'>" . $row['nama_kelas_j'] . "</td>";
                                                echo "<td class='table__data'>" . $row['nama_mapel_j'] . "</td>";
                                                echo "<td class='table__data'>" . $row['jam_mulai'] . "</td>";
                                                echo "<td class='table__data'>" . $row['jam_selesai'] . "</td>";
                                                echo "<td class='table__data'>";
                                                echo "<a class='edit__btn btn' href='../view/viewEdit.php?tabel=jadwal&jadwal_id=". $row['id_jadwal'] ."'>EDIT</a>";
                                                echo "</td>";
                                                echo "<td class='table__data'>";
                                                echo "<a class='delete__btn btn' href='../query/query_delete.php?tabel=jadwal&id=". $row['id_jadwal'] ."'>DELETE</a>";                                       
                                                echo "</td>";
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo "<tr><td class='colspan-5'>Belum ada Catatan</td></tr>";
                                        }
                                        
                                        ?>
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