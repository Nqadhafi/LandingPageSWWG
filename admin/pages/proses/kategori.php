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
    $query = "DELETE FROM categories WHERE id = $id";
    mysqli_query($conn, $query);
    header('Location: ../../?page=kategori');
}
?>
