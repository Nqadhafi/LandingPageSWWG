<?php
include '../../config.php';
session_start();

// Pastikan koneksi database berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil tindakan dari request
$action = $_POST['action'] ?? $_GET['action'] ?? null;

// Tambah atau Update Banner
if ($action === 'Tambah Banner' || $action === 'Update Banner') {
    // Validasi dan sanitasi input
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $link_reference = htmlspecialchars($_POST['link_reference'], ENT_QUOTES, 'UTF-8');
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

    // Validasi file gambar
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $image = $_FILES['image'];
        $fileType = mime_content_type($image['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            die("Format file tidak didukung. Hanya JPEG, PNG, dan GIF yang diperbolehkan.");
        }

        $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($image['name']));
        $targetPath = '../../../assets/banner/' . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
            die("Gagal mengupload gambar.");
        }
    }

    if ($action === 'Tambah Banner') {
        // Gunakan prepared statement untuk menambahkan banner
        $query = "INSERT INTO banners (title, image, link_reference) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $title, $imageName, $link_reference);
    } else {
        // Gunakan prepared statement untuk memperbarui banner
        $query = "UPDATE banners SET title = ?, link_reference = ?";
        if ($imageName) {
            $query .= ", image = ?";
        }
        $query .= " WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($imageName) {
            mysqli_stmt_bind_param($stmt, "sssi", $title, $link_reference, $imageName, $id);
        } else {
            mysqli_stmt_bind_param($stmt, "ssi", $title, $link_reference, $id);
        }
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../../?page=banner");
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menyimpan data.");
    }
}

// Hapus Banner
if ($action === 'delete') {
    // Validasi ID
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        die("ID tidak valid.");
    }

    // Hapus gambar terkait jika ada
    $query = "SELECT image FROM banners WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $banner = mysqli_fetch_assoc($result);

    if ($banner && file_exists('../../../assets/banner/' . $banner['image'])) {
        unlink('../../../assets/banner/' . $banner['image']);
    }

    // Gunakan prepared statement untuk menghapus banner
    $query = "DELETE FROM banners WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../../?page=banner");
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menghapus data.");
    }
}
?>
