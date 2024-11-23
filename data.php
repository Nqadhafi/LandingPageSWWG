<?php
include 'admin/config.php';

// Menampilkan Artikel
$querry_artikel = mysqli_query($conn, "SELECT * FROM article");
$artikel = mysqli_fetch_assoc($querry_artikel);

// Menampilkan Banner
$querry_banner = mysqli_query($conn, "SELECT * FROM banners");
$banners = mysqli_fetch_all($querry_banner, MYSQLI_ASSOC); // Mengambil semua data banner

// Menampilkan Kategori Produk
$query_categories = mysqli_query($conn, "SELECT * FROM categories");
$categories = mysqli_fetch_all($query_categories, MYSQLI_ASSOC); // Mengambil semua kategori

// Menampilkan Produk berdasarkan kategori
$products = [];
foreach ($categories as $category) {
    $category_id = $category['id'];
    $query_products = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $category_id");
    $products[$category['id']] = mysqli_fetch_all($query_products, MYSQLI_ASSOC);
}
?>
