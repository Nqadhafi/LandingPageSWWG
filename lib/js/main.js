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


    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('#productTab .nav-link');
        const productContainers = document.querySelectorAll('.category-products');

        tabs.forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();

                // Hapus kelas aktif dari semua tab
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Sembunyikan semua produk
                productContainers.forEach(container => container.classList.add('d-none'));

                // Tampilkan produk sesuai kategori
                const categoryId = this.getAttribute('data-category-id');
                document.querySelector(`.category-products[data-category-id="${categoryId}"]`).classList.remove('d-none');
            });
        });
    });

 
    document.addEventListener('DOMContentLoaded', () => {
        const detailButtons = document.querySelectorAll('.btn-detail');
        const modalTitle = document.getElementById('productDetailModalLabel');
        const modalImage = document.getElementById('productImage');
        const modalDescription = document.getElementById('productDescription');
        const modalPriceRange = document.getElementById('productPriceRange');
        const modalLink = document.getElementById('productLink');
    
        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                const name = this.getAttribute('data-name');
                const image = this.getAttribute('data-image');
                const description = this.getAttribute('data-description');
                const priceRange = this.getAttribute('data-price-range');
                const link = this.getAttribute('data-link');
    
                // Isi data ke modal
                modalTitle.textContent = name;
                modalImage.src = image;
                modalImage.alt = name;
    
                // Konversi newline menjadi <br>
                modalDescription.innerHTML = description.replace(/\n/g, '<br>');
    
                modalPriceRange.textContent = priceRange;
                modalLink.href = link;
            });
        });
    });
    



