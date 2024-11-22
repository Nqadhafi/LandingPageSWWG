<?php
include '../../config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action === 'Tambah Kategori') {
    $name = $_POST['name'];
    $query = "INSERT INTO categories (name) VALUES ('$name')";
    mysqli_query($conn, $query);
    header('Location: ../../?page=kategori');
} elseif ($action === 'Update Kategori') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $query = "UPDATE categories SET name = '$name' WHERE id = $id";
    mysqli_query($conn, $query);
    header('Location: ../../?page=kategori');
} elseif ($action === 'delete') {
    $id = $_GET['id'];

    // Cek apakah kategori memiliki produk tertaut
    $checkQuery = "SELECT COUNT(*) AS total FROM products WHERE category_id = $id";
    $result = mysqli_query($conn, $checkQuery);
    $row = mysqli_fetch_assoc($result);

    if ($row['total'] > 0) {
        // Jika masih ada produk tertaut, tampilkan pesan error
        echo "<script>
                alert('Kategori ini tidak dapat dihapus karena masih memiliki produk tertaut.');
                window.location.href = '../../?page=kategori';
              </script>";
    } else {
        $query = "DELETE FROM categories WHERE id = $id";
        mysqli_query($conn, $query);
        header('Location: ../../?page=kategori');
    }
}

?>
