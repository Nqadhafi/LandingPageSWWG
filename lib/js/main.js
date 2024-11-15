$(document).ready(function(){
    $('.client-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        dots: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});

// Animasi Preloader
window.addEventListener('load', function() {
    var preloader = document.getElementById('preloader');

    // Pastikan preloader tampil minimal 3 detik
    setTimeout(function() {
        preloader.classList.add('hide'); // Tambahkan kelas untuk memulai animasi tirai ke atas

        // Hapus elemen preloader dari DOM setelah animasi selesai
        setTimeout(function() {
            preloader.style.display = 'none';
        }, 1000); // Durasi sama dengan animasi CSS (1s)
    }, 2000); // Minimum waktu preloader tampil ( detik)
});


