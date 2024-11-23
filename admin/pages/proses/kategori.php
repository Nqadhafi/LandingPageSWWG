<?php
include '../../config.php';
session_start();

// Ambil aksi dari request
$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action === 'Tambah Kategori') {
    // Validasi dan sanitasi input
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

    // Gunakan prepared statement untuk menambahkan kategori
    $query = "INSERT INTO categories (name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $name);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../?page=kategori');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menambahkan kategori.");
    }
} elseif ($action === 'Update Kategori') {
    // Validasi dan sanitasi input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

    if (!$id) {
        die("ID tidak valid.");
    }

    // Gunakan prepared statement untuk memperbarui kategori
    $query = "UPDATE categories SET name = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $name, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../?page=kategori');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat memperbarui kategori.");
    }
} elseif ($action === 'delete') {
    // Validasi ID
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if (!$id) {
        die("ID tidak valid.");
    }

    // Cek apakah kategori memiliki produk tertaut
    $checkQuery = "SELECT COUNT(*) AS total FROM products WHERE category_id = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['total'] > 0) {
        // Jika masih ada produk tertaut, tampilkan pesan error
        echo "<script>
                alert('Kategori ini tidak dapat dihapus karena masih memiliki produk tertaut.');
                window.location.href = '../../?page=kategori';
              </script>";
    } else {
        // Gunakan prepared statement untuk menghapus kategori
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../../?page=kategori');
            exit();
        } else {
            error_log("Query Error: " . mysqli_error($conn));
            die("Terjadi kesalahan saat menghapus kategori.");
        }
    }
} else {
    die("Aksi tidak valid.");
}
?>
