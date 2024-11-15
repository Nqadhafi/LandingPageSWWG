<?php
include '../../config.php';
// Periksa koneksi ke database
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;
var_dump($_POST);
var_dump($_GET);
if ($action === 'Tambah Artikel') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $alt_text = mysqli_real_escape_string($conn, $_POST['alt_text']);

    // Upload gambar
    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageName = time() . '_' . basename($image['name']);
        $targetPath = '../../../assets/img/' . $imageName;
        
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            // Insert artikel ke database
            $query = "INSERT INTO article (title, content, image, alt_text) 
                      VALUES ('$title', '$content', '$imageName', '$alt_text')";
            if (mysqli_query($conn, $query)) {
                header("Location: ../../?page=artikel");
                exit;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal mengupload gambar.";
        }
    }
}

if ($action === 'Update Artikel') {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $alt_text = mysqli_real_escape_string($conn, $_POST['alt_text']);

    // Update gambar jika ada file yang diupload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image'];
        $imageName = time() . '_' . basename($image['name']);
        $targetPath = '../assets/img/' . $imageName;
        
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            // First, check if there's an existing image and remove it
            $query = "SELECT image FROM article WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $article = mysqli_fetch_assoc($result);
            if ($article && file_exists('../assets/img/' . $article['image'])) {
                unlink('../assets/img/' . $article['image']);
            }

            // Update artikel dengan gambar baru
            $query = "UPDATE article SET title = '$title', content = '$content', image = '$imageName', alt_text = '$alt_text' WHERE id = $id";
        } else {
            echo "Gagal mengupload gambar.";
            exit;
        }
    } else {
        // Update artikel tanpa gambar baru
        $query = "UPDATE article SET title = '$title', content = '$content', alt_text = '$alt_text' WHERE id = $id";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: ../../?page=artikel");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if ($action === 'delete') {
    $id = $_GET['id'];

    // First, retrieve the image associated with the article
    $query = "SELECT image FROM article WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $article = mysqli_fetch_assoc($result);

    if ($article && file_exists('../assets/img/' . $article['image'])) {
        unlink('../assets/img/' . $article['image']); // Delete the image
    }

    // Delete the article from the database
    $query = "DELETE FROM article WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: ../../?page=artikel");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
