<?php
include '../../config.php'; // Pastikan path ini benar ke file config Anda

$action = $_POST['action'] ?? $_GET['action'] ?? null;

// Tambah atau Update Banner
if ($action === 'Tambah Banner' || $action === 'Update Banner') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $link_reference = mysqli_real_escape_string($conn, $_POST['link_reference']);
    $id = $_POST['id'] ?? null;

    // Handle upload gambar
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $imageName = time() . '_' . basename($image['name']);
        $targetPath = '../../../assets/banner/' . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
            die("Gagal mengupload gambar.");
        }
    }

    if ($action === 'Tambah Banner') {
        // Insert banner baru
        $query = "INSERT INTO banners (title, image, link_reference) VALUES ('$title', '$imageName', '$link_reference')";
    } else {
        // Update banner yang ada
        $query = "UPDATE banners SET title='$title', link_reference='$link_reference'";
        if (!empty($imageName)) {
            // Update gambar jika ada file yang baru diupload
            $query .= ", image='$imageName'";
        }
        $query .= " WHERE id=$id";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: ../../?page=banner");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}

// Hapus Banner
if ($action === 'delete') {
    $id = $_GET['id'];
    // Mengambil gambar lama dan menghapus dari folder jika ada
    $query = "SELECT image FROM banners WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $banner = mysqli_fetch_assoc($result);

    if ($banner && file_exists('../../../assets/banner/' . $banner['image'])) {
        unlink('../../../assets/banner/' . $banner['image']);
    }

    // Hapus banner dari database
    $query = "DELETE FROM banners WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        header("Location: ../../?page=banner");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    exit;
}
?>
