<?php
include 'admin/config.php';
//Menampilkan Artikel
$querry_artikel = mysqli_query($conn, "SELECT * FROM article");
$artikel = mysqli_fetch_assoc($querry_artikel);

?>