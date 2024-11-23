<?php
include '../../config.php';
session_start();

// Ambil aksi dari request
$action = $_POST['action'] ?? $_GET['action'] ?? null;

// Direktori target untuk upload gambar
$targetDir = "../../../assets/product/";

if ($action === 'Tambah Produk') {
    // Validasi dan sanitasi input
    $category_id = filter_var($_POST['category_id'], FILTER_VALIDATE_INT);
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $price_range = htmlspecialchars($_POST['price_range'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $link_reference = filter_var($_POST['link_reference'], FILTER_SANITIZE_URL);

    // Validasi file upload
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $image = $_FILES['image'];
        $fileType = mime_content_type($image['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            die("Format file tidak didukung. Hanya JPEG, PNG, dan GIF yang diperbolehkan.");
        }

        $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($image['name']));
        $targetFile = $targetDir . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
            die("Gagal mengupload gambar.");
        }
    }

    // Gunakan prepared statement untuk menyimpan produk
    $query = "INSERT INTO products (category_id, name, price_range, description, link_reference, image) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isssss", $category_id, $name, $price_range, $description, $link_reference, $imageName);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../?page=produk');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menyimpan data produk.");
    }
} elseif ($action === 'Update Produk') {
    // Validasi dan sanitasi input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $category_id = filter_var($_POST['category_id'], FILTER_VALIDATE_INT);
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $price_range = htmlspecialchars($_POST['price_range'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $link_reference = filter_var($_POST['link_reference'], FILTER_SANITIZE_URL);

    if (!$id || !$category_id) {
        die("ID atau kategori tidak valid.");
    }

    // Validasi file upload jika ada
    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $image = $_FILES['image'];
        $fileType = mime_content_type($image['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            die("Format file tidak didukung.");
        }

        $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($image['name']));
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Hapus gambar lama
            $oldQuery = "SELECT image FROM products WHERE id = ?";
            $stmt = mysqli_prepare($conn, $oldQuery);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $oldImage = mysqli_fetch_assoc($result)['image'];

            if ($oldImage && file_exists($targetDir . $oldImage)) {
                unlink($targetDir . $oldImage);
            }

            // Update data produk dengan gambar baru
            $query = "UPDATE products SET 
                      category_id = ?, name = ?, price_range = ?, description = ?, link_reference = ?, image = ? 
                      WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "isssssi", $category_id, $name, $price_range, $description, $link_reference, $imageName, $id);
        } else {
            die("Gagal mengupload gambar.");
        }
    } else {
        // Update data produk tanpa mengganti gambar
        $query = "UPDATE products SET 
                  category_id = ?, name = ?, price_range = ?, description = ?, link_reference = ? 
                  WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "issssi", $category_id, $name, $price_range, $description, $link_reference, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../?page=produk');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat memperbarui data produk.");
    }
} elseif ($action === 'delete') {
    // Validasi ID
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        die("ID tidak valid.");
    }

    // Hapus gambar terkait jika ada
    $query = "SELECT image FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $image = mysqli_fetch_assoc($result)['image'];

    if ($image && file_exists($targetDir . $image)) {
        unlink($targetDir . $image);
    }

    // Gunakan prepared statement untuk menghapus produk
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../?page=produk');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menghapus produk.");
    }
}
?>
