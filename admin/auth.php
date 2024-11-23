<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: ../login.php");
    exit();
}
?>
