<?php
include '../../config.php';

$action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

if ($action == 'Tambah Customer') {
    $name = $_POST['name'];
    $reference = $_POST['reference'];

    // Proses upload gambar
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetDir = '../../../assets/client/';
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $imageName;
        } else {
            die('Error saat mengupload gambar.');
        }
    }

    $query = "INSERT INTO customers (name, image, reference) VALUES ('$name', '$image', '$reference')";
    if (mysqli_query($conn, $query)) {
        header('Location: ../../index.php?page=customer');
    } else {
        die('Error: ' . mysqli_error($conn));
    }

} elseif ($action == 'Update Customer') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $reference = $_POST['reference'];

    // Proses upload gambar jika ada
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetDir = '../../../assets/client/';
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Hapus gambar lama jika ada
            $query = "SELECT image FROM customers WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $customer = mysqli_fetch_assoc($result);
            if ($customer && file_exists($targetDir . $customer['image'])) {
                unlink($targetDir . $customer['image']);
            }

            // Update gambar baru
            $query = "UPDATE customers SET image = '$imageName' WHERE id = $id";
            mysqli_query($conn, $query);
        } else {
            die('Error saat mengupload gambar.');
        }
    }

    $query = "UPDATE customers SET name = '$name', reference = '$reference' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: ../../index.php?page=customer');
    } else {
        die('Error: ' . mysqli_error($conn));
    }

} elseif ($action == 'delete') {
    $id = $_GET['id'];

    // Hapus gambar dari server
    $query = "SELECT image FROM customers WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);
    if ($customer && file_exists('../../../assets/client/' . $customer['image'])) {
        unlink('../../uploads/' . $customer['image']);
    }

    $query = "DELETE FROM customers WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: ../../index.php?page=customer');
    } else {
        die('Error: ' . mysqli_error($conn));
    }
} else {
    die('Aksi tidak valid.');
}
