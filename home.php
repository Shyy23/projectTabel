<?php
session_start();
include "koneksi/koneksi.php";
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
    <!-- ================= FAVICON ===================== -->
    <link rel="shortcut icon" href="assets/icon/home.ico" type="image/x-icon">
    
    <!-- ================= FONT AWESOME ===================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css?v=<?php echo time();?>">
    <!-- ================= REMIXICON ===================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css?v=<?php echo time();?>">
    
    <!-- ================= Hamburgers ===================== -->
    <link rel="stylesheet" href="dist/css/hamburgers.css?v=<?php echo time ();?>">

     <!-- ================= SWIPER CSS ===================== -->
     <link rel="stylesheet" href="dist/css/swiper-bundle.min.css?v=<?php echo time ();?>">

     <!-- ================= CSS ===================== -->
     <link rel="stylesheet" href="dist/css/style.css?v=<?php echo time ();?>">

     <title>Home</title>
</head>
<body>
    <img src="assets/img/banner.png" alt="image__bg" class="bg__image">
    <div class="bg__blur"></div>
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

        <form action="" class="header__search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="search" class="header__input">
        </form>
    </header>
    <!-- ================= SIDEBAR ===================== -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar__container">
            <div class="sidebar__user b-bot">
                <div class="sidebar__image">
                    <img src="assets/img/pp.jpg" alt="image" class="sidebar__img">
                </div>

                <div class="sidebar__info">
                    <h3 class="sidebar__name"><?= $_SESSION['nama'];?></h3>
                    <span class="sidebar__email">Shyy23@gmail.com</span>
                </div>
            </div>

            <div class="sidebar__content">
                <div>
                    <h3 class="sidebar__title">MANAGE</h3>
                    <div class="sidebar__list b-bot">
                        
                    <a href="" class="sidebar__link  active-link">
                        <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                    </a>
                    <a href="viewTabel/TabelSiswa.php" class="sidebar__link">
                    <i class="fa-solid fa-graduation-cap"></i>
                        <span>Data Siswa</span>
                    </a>
                    <a href="viewTabel/TabelGuru.php" class="sidebar__link ">
                    <i class="fa-solid fa-chalkboard-user"></i>
                        <span>Data Guru</span>
                    </a>
                    <a href="viewTabel/TabelJadwal.php" class="sidebar__link">
                    <i class="fa-solid fa-calendar-days"></i>  
                        <span>Data Jadwal</span>
                    </a>
                    <a href="viewTabel/TabelPresensi.php" class="sidebar__link">
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
    <!-- ============ MAIN DASHBOARD ===================== -->
    <main class="main container" id="main">
        <section class="banner">
            <article class="banner__card">
                <a href="" class="banner__link">
                    <img src="assets/img/banner.png" alt="image__banner" class="banner__img">
                    <div class="banner__shadow"></div>

                        <div class="banner__data">
                            <h2 class="banner__title">Lord Of The Mysteries</h2>
                            <span class="banner__category">Action Mystery Fantasy</span>
                        </div>
                    
                </a>
            </article>
        </section>

        <section class="characters">
            <h3 class="card__title">Character</h3>

            <div class="char__swiper swiper">
                <div class="swiper-wrapper">
                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Moretti.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Moretti</h3>
                                <span class="card__category">MC</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Cattleya.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name"> Catlleya</h3>
                                <span class="card__category">The Hermit</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Leonard.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Leonard</h3>
                                <span class="card__category">The Star</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Fors.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Fors Wall</h3>
                                <span class="card__category">The Magician</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Dwayne.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Dwayne</h3>
                                <span class="card__category">Deputy Director</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Audrey.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Audrey Hall</h3>
                                <span class="card__category">Justice</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Lumian.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Lumian Lee</h3>
                                <span class="card__category">The Chariot</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Amon.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Amon</h3>
                                <span class="card__category">Angel of Time</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>

                    <article class="card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Sharron.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="card__data">
                                <h3 class="card__name">Sharron</h3>
                                <span class="card__category">Temperance</span>
                            </div>

                            <i class="fa-regular fa-heart card__like"></i>
                        </a>
                    </article>
                </div>
            </div>

        </section>

    <!-- ================= PATHWAY ===================== -->
        <section class="path">
            <h3 class="card__title"> Pathway </h3>
            <div class="path__swiper swiper">
                <div class="swiper-wrapper">
                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Fool.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Fool Pathway</h3>
                                <span class="card__category">Dancer Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/error.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Error Pathway</h3>
                                <span class="card__category">Dancer Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Door.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Door Pathway</h3>
                                <span class="card__category">Dancer Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Wheel.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">
                                    <h3 class="card__name">Wheel of Fortune</h3>
                                <span class="card__category">Dancer Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Mother.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Mother Pathway</h3>
                                <span class="card__category">Villain Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Moon.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Moon Pathway</h3>
                                <span class="card__category">Villain Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Abyss.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Abyss Pathway</h3>
                                <span class="card__category">Scrooge Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Chained.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Chained Pathway</h3>
                                <span class="card__category">Scrooge Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Black.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Black Emperor Pathway</h3>
                                <span class="card__category">Broker Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Justiciar.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Justiciar Pathway</h3>
                                <span class="card__category">Broker Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Hermit.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">hermit Pathway</h3>
                                <span class="card__category">Orator Pathway</span>
                            </div>
                        </a>
                    </article>

                    <article class="path__card card__article swiper-slide">
                        <a href="#" class="card__link">
                            <img src="assets/img/Paragon.webp" alt="image" class="card__img">
                            <div class="card__shadow"></div>

                            <div class="path__data card__data">
                                <h3 class="card__name">Paragon Pathway</h3>
                                <span class="card__category">Orator Pathway</span>
                            </div>
                        </a>
                    </article>
                </div>
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </section>
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
    <!-- ================= SCROLL UP ===================== -->

    <!-- ================= SCROLL REVEAL ===================== -->

    <!-- ================= SWIPER JS ===================== -->
    <script src="dist/js/swiper-bundle.min.js?v=<?php echo time();?>"></script>

    <!-- ================= MAIN js ===================== -->
    <script src="dist/js/dashboard.js?v=<?php echo time();?>"></script>
    <script src="dist/js/login.js?v=<?php echo time();?>"></script>
</body>
</html>