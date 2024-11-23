<?php
include '../../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi dan sanitasi input
    $pricelist = filter_var($_POST['pricelist'], FILTER_SANITIZE_URL);
    $admin1 = filter_var($_POST['admin1'], FILTER_SANITIZE_URL);
    $admin2 = filter_var($_POST['admin2'], FILTER_SANITIZE_URL);

    // Gunakan prepared statement untuk menghindari SQL Injection
    $query = "SELECT id FROM links LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika data ada, update
        $query = "UPDATE links SET pricelist = ?, admin1 = ?, admin2 = ? WHERE id = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $pricelist, $admin1, $admin2);
    } else {
        // Jika data tidak ada, insert
        $query = "INSERT INTO links (pricelist, admin1, admin2) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $pricelist, $admin1, $admin2);
    }

    // Eksekusi statement
    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../index.php?page=link');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menyimpan data.");
    }
}
?>
