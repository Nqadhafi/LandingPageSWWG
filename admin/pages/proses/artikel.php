<?php
include '../../config.php';
session_start();

// Pastikan koneksi database berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil tindakan dari request
$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action === 'Tambah Artikel') {
    // Sanitasi input
    $title = $_POST['title'];
    $content = $_POST['content'];
    $alt_text = htmlspecialchars($_POST['alt_text'], ENT_QUOTES, 'UTF-8');

    // Validasi dan upload file gambar
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $image = $_FILES['image'];
    $fileType = mime_content_type($image['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        die("Hayo mau upload apa?.");
    }

    $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($image['name']));
    $targetPath = '../../../assets/img/' . $imageName;

    if (move_uploaded_file($image['tmp_name'], $targetPath)) {
        // Gunakan prepared statement untuk menyimpan data
        $query = "INSERT INTO article (title, content, image, alt_text) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $title, $content, $imageName, $alt_text);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../../?page=artikel");
            exit();
        } else {
            error_log("Query Error: " . mysqli_error($conn));
            die("Terjadi kesalahan saat menyimpan data.");
        }
    } else {
        die("Gagal mengupload gambar.");
    }
}

if ($action === 'Update Artikel') {
    // Validasi dan sanitasi input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        die("ID tidak valid.");
    }

    $title = $_POST['title'];
    $content = $_POST['content'];
    $alt_text = htmlspecialchars($_POST['alt_text'], ENT_QUOTES, 'UTF-8');
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    // Update gambar jika ada file baru
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $fileType = mime_content_type($image['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
            die("Format file tidak didukung.");
        }

        $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', basename($image['name']));
        $targetPath = '../../../assets/img/' . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            // Hapus gambar lama jika ada
            $query = "SELECT image FROM article WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $article = mysqli_fetch_assoc($result);

            if ($article && file_exists('../../../assets/img/' . $article['image'])) {
                unlink('../../../assets/img/' . $article['image']);
            }

            // Update data dengan gambar baru
            $query = "UPDATE article SET title = ?, content = ?, image = ?, alt_text = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssi", $title, $content, $imageName, $alt_text, $id);
        } else {
            die("Gagal mengupload gambar.");
        }
    } else {
        // Update data tanpa mengganti gambar
        $query = "UPDATE article SET title = ?, content = ?, alt_text = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $alt_text, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../../?page=artikel");
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat memperbarui data.");
    }
}

if ($action === 'delete') {
    // Validasi ID
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        die("ID tidak valid.");
    }

    // Hapus gambar terkait
    $query = "SELECT image FROM article WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $article = mysqli_fetch_assoc($result);

    if ($article && file_exists('../../../assets/img/' . $article['image'])) {
        unlink('../../../assets/img/' . $article['image']);
    }

    // Hapus artikel dari database
    $query = "DELETE FROM article WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../../?page=artikel");
        exit();
    } else {
        error_log("Query Error: " . mysqli_error($conn));
        die("Terjadi kesalahan saat menghapus data.");
    }
}
?>
