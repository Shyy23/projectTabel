/**  ========================= SHOW SIDEBAR ==================================*/
const showSidebar = (toggleId, sidebarId, headerId, mainId, footerId) => {
    const toggle = document.getElementById(toggleId);
          sidebar = document.getElementById(sidebarId),
          header = document.getElementById(headerId),
          main = document.getElementById(mainId);
          footer = document.getElementById(footerId);

    if(toggle && sidebar && header && main && footer){
        toggle.addEventListener('click', ()=>{
            /** Show-sidebar */
            sidebar.classList.toggle('show-sidebar')
            /** Add Padding header */
            header.classList.toggle('left-pd');
            /** Add Padding main */
            main.classList.toggle('left-pd');
            /** Add Padding footer */
            footer.classList.toggle('left-pd');
        })
    }
}
showSidebar('header-toggle', 'sidebar', 'header', 'main', 'footer');

/**  ========================= ACTIVE LINK ==================================*/
const sidebarLink = document.querySelectorAll('.sidebar__list a');

function linkColor(){
    sidebarLink.forEach(l => l.classList.remove('active-link'));
    this.classList.add('active-link');
}

sidebarLink.forEach(l => l.addEventListener('click', linkColor));

/**  ========================= DARK LIGHT THEME ==================================*/
const themeButton = document.getElementById('theme-button');
const darkTheme = 'dark-theme';
const iconTheme = 'ri-sun-line';

// Memilih topik sebelumnya (jika user memilih)
const selectedTheme = localStorage.getItem('selected-theme');
const selectedIcon = localStorage.getItem('selected-icon');

// Mengambil tema sekarang dan menampilkannya dengan validasi dark theme
const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light';
const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'ri-moon-clear-fill' : 'ri-sun-line';

//  Validasi pilihan user sebelumnya
if(selectedTheme){
        // Jika validasi terpenuhi maka kita perlu mengetahui apakah menambah atau menghapus the dark
    document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme);
    themeButton.classList[selectedIcon === 'ri-moon-clear-fill' ? 'add' : 'remove'](iconTheme);
}

// Aktivasi dan nonaktif manual dengan button
themeButton.addEventListener('click', () => {
    // Mengubah tema ke gelap dan terang
    document.body.classList.toggle(darkTheme);
    themeButton.classList.toggle(iconTheme);

    // menyimpan tema sekarang yang dipilih user
    localStorage.setItem('selected-theme', getCurrentTheme());
    localStorage.setItem('selected-icon', getCurrentIcon());
})

/**  ========================= HAMBURGERS ==================================*/
var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

var hamburgers = document.querySelectorAll(".hamburger");
if (hamburgers.length > 0) {
  forEach(hamburgers, function(hamburger) {
    hamburger.addEventListener("click", function() {
      this.classList.toggle("is-active");
    }, false);
  });
}

/**  ========================= SWIPER CHAR ==================================*/
let swiperChar = new Swiper('.char__swiper', {
    loop: true,
    grabCursor: true,
    slidesPerView: 2,
    spaceBetween: 24,

    breakpoints:{
        440:{
            slidesPerView: 'auto',
        },
        768:{
            slidesPerView: 4,
        },
        1200:{
            slidesPerView: 5,
        }
        
    }
  });

  /**  ========================= ADD BLUR HEADER ==================================*/
const blurHeader = () => {
    const header = document.getElementById('header');
    // nambah class jika bottom offset melebihi 50
    this.scrollY >= 50 ? header.classList.add('blur-header')
                       : header.classList.remove('blur-header');
                       
}
window.addEventListener('scroll', blurHeader);

/**  ========================= SWIPER PATH ==================================*/
let swiperPath = new Swiper('.path__swiper', {
    loop: true,
    grabCursor: true,
    slidesPerView: 2,
    centeredSlides: true,

    // Pagination
    pagination: {
    el: '.swiper-pagination',
    clickable: true,
    },

    breakpoints:{
        440:{
            slidesPerView: 'auto',
            
        },
        768:{
            slidesPerView: 4,
            centeredSlides: false,
        },
        1200:{
            slidesPerView: 5,
            centeredSlides: false,
        }
        
    }
  });


