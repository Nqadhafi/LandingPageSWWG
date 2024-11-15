<?php
include 'data.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/img/Logo-Single.webp" type="image/x-icon">
    <title>Shabat Printing</title>

    <link rel="stylesheet" href="./lib/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./lib/css/main.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  </head>

  <body>
    <!-- Header Navigation -->
    <nav class="navbar shadow-sm bg-white navbar-expand-md sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img
            src="./assets/img/Logo-Long.webp"
            alt="Logo Shabat Printing"
            id="logo-utama"
          />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link text-dark fw-bold" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fw-bold" href="#produk">Produk</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fw-bold" href="#">Tentang Kami</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fw-bold" href="#order"
                >Order Sekarang</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Banner Slider Section -->
    <div
      id="bannerCarousel"
      class="carousel slide mt-4 container"
      data-bs-ride="carousel"
    >
      <div class="carousel-inner rounded-4">
        <div class="carousel-item active">
          <a href="" target="_blank">
          <img
            src="https://via.placeholder.com/1200x400"
            class="d-block w-100"
            alt="Banner 1"
          />
        </a>
        </div>
        <div class="carousel-item">
          <img
            src="https://via.placeholder.com/1200x400"
            class="d-block w-100"
            alt="Banner 2"
          />
        </div>
        <div class="carousel-item">
          <img
            src="https://via.placeholder.com/1200x400"
            class="d-block w-100"
            alt="Banner 3"
          />
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#bannerCarousel"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#bannerCarousel"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Hero Section -->
    <div class="container mt-5 pb-5">
      <div class="row">
        <div class="col-md-7">
          <h2 class="fw-bold text-blue">
            <?php echo $artikel['title'] ?? ''?>
          </h2>
          <p>
          <?php echo $artikel['content'] ?? ''?>
          </p>
        </div>
        <div class="col-md-5">
          <!-- Placeholder for image -->
          <div class="bg-light" style="width: 100%; height: 20rem">
            <img src="./assets/img/<?php echo $artikel['image'] ?? ''?>" alt="<?php echo $artikel['alt_text'] ?? ''?>" class="img-fluid">
          </div>
        </div>
      </div>
    </div>

    <!-- Kenapa Harus Cetak Di Sahabat Printshop -->
    <div class="container-fluid mt-5 text-center bg-blue text-white py-5">
      <!-- Container -->
      <div class="container">
        <h2 class="fw-bold">KENAPA HARUS CETAK DI SHABAT PRINTING ?</h2>
        <div class="row mt-5">
          <!-- Grup Kiri -->
          <div class="col-md-3 col-sm-6 mt-3">
            <div class="d-flex flex-column align-items-center">
              <div
                class="bg-light border rounded align-content-center"
                style="width: 5rem; height: 5rem"
              >
                <img
                  class="img-fluid"
                  style="width: 3rem"
                  src="assets/icons/pelayanan.png"
                  alt=""
                />
              </div>
              <h5 class="mt-3 fw-bold">Pelayanan Ramah</h5>
              <p>Kami mengutamakan pelanggan, dengan memberikan service exellent.</p>
            </div>
            <div class="d-flex flex-column align-items-center mt-4">
              <div class="bg-light border rounded align-content-center" style="width: 5rem; height: 5rem">
                <img
                  class="img-fluid"
                  style="width: 3rem"
                  src="assets/icons/cepat.png"
                  alt=""
                />
              </div>
              <h5 class="mt-3 fw-bold">Proses Cepat</h5>
              <p>Memastikan pesanan dapat selesai tepat waktu adalah komitmen kami.</p>
            </div>
            <div class="d-flex flex-column align-items-center mt-4">
              <div class="bg-light border rounded align-content-center" style="width: 5rem; height: 5rem">
                <img
                  class="img-fluid"
                  style="width: 3rem"
                  src="assets/icons/harga.png"
                  alt=""
                />
              </div>
              <h5 class="mt-3 fw-bold">Harga Kompetitif</h5>
              <p>Efisiensi dalam operasional, sehingga dapat memberikan harga yang kompetitif.</p>
            </div>
          </div>

          <!-- Grup Tengah -->
          <div class="col-md-6 align-content-center mb-4 d-none d-md-block">
            <div class="d-flex flex-column align-items-center">
              <div
                class="align-content-center"
                style="width: 20rem; height: 25rem"
              >
                <img src="assets/img/Guess.png" alt="" class="img-fluid" />
              </div>
            </div>
          </div>

          <!-- Grup Kanan -->
          <div class="col-md-3 col-sm-6 mt-3">
            <div class="d-flex flex-column align-items-center">
              <div class="bg-light border rounded align-content-center" style="width: 5rem; height: 5rem">
                <img
                  class="img-fluid"
                  style="width: 3rem"
                  src="assets/icons/hasil.png"
                  alt=""
                />
              </div>
              <h5 class="mt-3 fw-bold">Kualitas Terbaik</h5>
              <p>Dukungan mesin teknologi terkini, untuk hasil cetak yang maksimal</p>
            </div>
            <div class="d-flex flex-column align-items-center mt-4">
              <div class="bg-light border rounded align-content-center" style="width: 5rem; height: 5rem">
                <img
                  class="img-fluid"
                  style="width: 3rem"
                  src="assets/icons/custom.png"
                  alt=""
                />
              </div>
              <h5 class="mt-3 fw-bold">Bisa Custom</h5>
              <p>Ingin tampil unik? wujudkan karya impianmu bersama kami</p>
            </div>
            <div class="d-flex flex-column align-items-center mt-4">
              <div class="bg-light border rounded align-content-center" style="width: 5rem; height: 5rem">
                <img
                  class="img-fluid"
                  style="width: 3rem"
                  src="assets/icons/minimal.png"
                  alt=""
                />
              </div>
              <h5 class="mt-3 fw-bold">Tanpa Minimal Order</h5>
              <p>Cetak satuan? atau partai besar? Kami siap melayani</p>
            </div>
          </div>
        </div>
      </div>
      <!-- End Container -->
    </div>

    <!-- Product Categories Section -->
    <div class="container mt-5" id="produk">
      <h3 class="text-center fw-bold">MAU CETAK APA HARI INI?</h3>
  
      <!-- Tabs for Product Categories -->
      <ul class="nav nav-tabs justify-content-center mt-4 gap-5" id="productTab" role="tablist">
          <li class="nav-item">
              <a class="nav-link active" id="brosur-tab" data-bs-toggle="tab" href="#brosur" role="tab">Brosur/Flyer</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="poster-tab" data-bs-toggle="tab" href="#poster" role="tab">Poster</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="banner-tab" data-bs-toggle="tab" href="#banner" role="tab">Banner</a>
          </li>
          <!-- Tambahkan lebih banyak kategori jika diperlukan -->
      </ul>
  
      <!-- Tab Content for Products -->
      <div class="tab-content mt-4" id="productTabContent">
          
          <!-- Brosur/Flyer Content -->
          <div class="tab-pane fade show active" id="brosur" role="tabpanel">
              <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                      <div class="card">
                          <div class="card-body bg-light" style="height: 10rem;"></div>
                          <h5 class="card-title text-center mt-2">Brosur 1</h5>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                      <div class="card">
                          <div class="card-body bg-light" style="height: 10rem;"></div>
                          <h5 class="card-title text-center mt-2">Brosur 2</h5>
                      </div>
                  </div>
              </div>
          </div>
  
          <!-- Poster Content -->
          <div class="tab-pane fade" id="poster" role="tabpanel">
              <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                      <div class="card">
                          <div class="card-body bg-light" style="height: 10rem;"></div>
                          <h5 class="card-title text-center mt-2">Poster 1</h5>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                      <div class="card">
                          <div class="card-body bg-light" style="height: 10rem;"></div>
                          <h5 class="card-title text-center mt-2">Poster 2</h5>
                      </div>
                  </div>
              </div>
          </div>
  
          <!-- Banner Content -->
          <div class="tab-pane fade" id="banner" role="tabpanel">
              <div class="row">
                  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                      <div class="card">
                          <div class="card-body bg-light" style="height: 10rem;"></div>
                          <h5 class="card-title text-center mt-2">Banner 1</h5>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                      <div class="card">
                          <div class="card-body bg-light" style="height: 10rem;"></div>
                          <h5 class="card-title text-center mt-2">Banner 2</h5>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Price List Button -->
      <div class="text-center mt-5">
          <a href="http://" class="btn btn-warning border-black fw-bold" target="_blank">Cek Price List Lengkap Di Sini</a>
      </div>
  </div>
  


    <div style="height: 20rem"></div>
    <!-- Overlayy Section -->
    <div
      class="container-fluid bg-blue position-relative overlay mt-5"
      style="height: 28rem"
    >
      <!-- Order Section -->

      <div
        class="container align-content-center position-absolute pb-5 top-0 start-50 translate-middle"
        id="order"
      >
        <h3 class="text-center fw-bold mb-4">ORDER DI SINI</h3>
        <div class="rounded-3 text-center shadow-lg bg-white py-5">
          <div class="d-grid justify-content-center gap-5">
            <div>
              <h4 class="fw-bold">Admin 1</h4>
              <a
                href="https://wa.me/6281380999999"
                class="btn btn-success d-flex gap-2"
              >
                <i class="bi bi-whatsapp"></i>0813-8099-9999
              </a>
            </div>
            <div>
              <h4 class="fw-bold">Admin 2</h4>
              <a
                href="https://wa.me/6285601367643"
                class="btn btn-success d-flex gap-2"
              >
                <i class="bi bi-whatsapp"></i>0856-0136-7643
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- Clients Section -->
<div
  class="container align-content-center position-absolute top-100 start-50 translate-middle"
  style="height: 18rem"
>
  <h3 class="text-center text-white fw-bold mb-4">KLIEN KAMI</h3>
  <div class="rounded-3 text-center shadow-lg bg-white py-5 mb-5">
    <div class="client-slider m-5 ">
      <div><img src="assets/img/Logo-Long.webp" class="img-fluid" alt="Client 1"></div>
      <div><img src="assets/img/Logo-Single.webp" class="img-fluid" alt="Client 2"></div>
      <div><img src="client3.jpg" class="img-fluid" alt="Client 3"></div>
      <div><img src="client4.jpg" class="img-fluid" alt="Client 4"></div>
      <div><img src="client5.jpg" class="img-fluid" alt="Client 5"></div>
  </div>
  
  </div>
</div>

    </div>
    <div style="height: 20rem"></div>
    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 pt-4 pb-1">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mt-3">
            <h4 class="fw-bold">About Us</h4>
            <hr>
            <img src="assets/img/Logo-Long.webp" alt="Logo Shabat Printing" style="width: 13rem;" class="mb-4">
            <p class="d-flex align-items-center gap-3 fw-bold text-footer">
              <img src="assets/icons/location.png" alt="" style="height: 2rem;">
              JL. Perintis Kemerdekaan No.20 C-F, Kel.Sondakan, Kec.Laweyan, Kota Surakarta
            </p>
            <p class="d-flex align-items-center gap-3 fw-bold text-footer">
              <img src="assets/icons/mail.png" alt="" style="height: 2rem;">
              shabatwarna@gmail.com
            </p>
            <p class="d-flex align-items-center gap-3 fw-bold text-footer">
              <img src="assets/icons/phone.png" alt="" style="height: 2rem;">
              +62 857-1079-9999
            </p>
          </div>
          <div class="col-md-4 mt-3">
            <h4 class="fw-bold">Jam Operasional</h4>
            <hr>
            <table class="text-footer fw-bold">
              <tr>
                <td>Senin s/d Jumat</td>
                <td>: 08.00 - 22.00 WIB</td>
              </tr>
              <tr>
                <td>Sabtu</td>
                <td>: 10.00 - 18.00 WIB</td>
              </tr>
            </table>
          </div>
          
          <div class="col-md-4 mt-3">
            <h4 class="fw-bold">Metode Pembayaran</h4>
            <hr>
            <div class="d-flex gap-2">
              <img src="assets/icons/bca.jpg" alt="" class="img-fluid rounded-1" style="height: 2rem;">
              <img src="assets/icons/bni.png" alt="" class="img-fluid rounded-1" style="height: 2rem;">
              <img src="assets/icons/qris.png" alt="" class="img-fluid rounded-1" style="height: 2rem;">
            </div>
          </div>
          
        </div>
      </div>
      <hr>
      <p class="text-center fw-bold ">
        © 2024 Shabat Printing - All right reserved.
      </p>
    
    </footer>
  </body>
  
    <script src="lib/js/bootstrap.bundle.min.js"></script>
    <script src="lib/js/jquery-3.5.1.slim.min.js"></script>
    <!-- Slick JS -->
    <script src="lib/js/slick-1.8.1.min.js"></script>
    <script src="lib/js/main.js"></script>
</html>
