<?php
include 'admin/config.php';

// Menampilkan Artikel
$querry_artikel = mysqli_query($conn, "SELECT * FROM article");
$artikel = mysqli_fetch_assoc($querry_artikel);

// Menampilkan Banner
$querry_banner = mysqli_query($conn, "SELECT * FROM banners");
$banners = mysqli_fetch_all($querry_banner, MYSQLI_ASSOC); // Mengambil semua data banner
?>
