<?php
include '../../config.php';
session_start();

// Ambil aksi dari request
$action = $_POST['action'] ?? $_GET['action'] ?? null;

// Direktori target untuk upload file
$targetDir = '../../../assets/client/';

if ($action == 'Tambah Customer') {
    // Validasi dan sanitasi input
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $reference = filter_var($_POST['reference'], FILTER_SANITIZE_URL);

    // Validasi file upload
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
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

    // Gunakan prepared statement untuk menyimpan data
    $query = "INSERT INTO customers (name, image, reference) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $name, $imageName, $reference);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../index.php?page=customer');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menyimpan data.");
    }
} elseif ($action == 'Update Customer') {
    // Validasi dan sanitasi input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $reference = filter_var($_POST['reference'], FILTER_SANITIZE_URL);

    if (!$id) {
        die("ID tidak valid.");
    }

    // Validasi file upload jika ada
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $image = $_FILES['image'];
        $fileType = mime_content_type($image['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            die("Hayo mau upload apa?.");
        }

        $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($image['name']));
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Hapus gambar lama jika ada
            $query = "SELECT image FROM customers WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $customer = mysqli_fetch_assoc($result);

            if ($customer && file_exists($targetDir . $customer['image'])) {
                unlink($targetDir . $customer['image']);
            }

            // Update data dengan gambar baru
            $query = "UPDATE customers SET image = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $imageName, $id);
            mysqli_stmt_execute($stmt);
        } else {
            die("Gagal mengupload gambar.");
        }
    }

    // Update data pelanggan
    $query = "UPDATE customers SET name = ?, reference = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $reference, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../index.php?page=customer');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat memperbarui data.");
    }
} elseif ($action == 'delete') {
    // Validasi ID
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        die("ID tidak valid.");
    }

    // Hapus gambar terkait jika ada
    $query = "SELECT image FROM customers WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $customer = mysqli_fetch_assoc($result);

    if ($customer && file_exists($targetDir . $customer['image'])) {
        unlink($targetDir . $customer['image']);
    }

    // Hapus data pelanggan dari database
    $query = "DELETE FROM customers WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../index.php?page=customer');
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menghapus data.");
    }
} else {
    die("Aksi tidak valid.");
}
