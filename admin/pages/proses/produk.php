<?php
include '../../config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action === 'Tambah Produk') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $price_range = $_POST['price_range'];
    $description = $_POST['description'];
    $link_reference = $_POST['link_reference'];

    // Upload Gambar
    $image = $_FILES['image']['name'];
    $target = "../../../assets/product/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $query = "INSERT INTO products (category_id, name, price_range, description, link_reference, image) 
                  VALUES ('$category_id', '$name', '$price_range', '$description', '$link_reference', '$image')";
        mysqli_query($conn, $query);
    }
    header('Location: ../../?page=produk');
} elseif ($action === 'Update Produk') {
    $id = $_POST['id'];
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $price_range = $_POST['price_range'];
    $description = $_POST['description'];
    $link_reference = $_POST['link_reference'];

    // Upload Gambar
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../../../assets/product/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        // Hapus gambar lama
        $oldQuery = "SELECT image FROM products WHERE id = $id";
        $oldResult = mysqli_query($conn, $oldQuery);
        $oldImage = mysqli_fetch_assoc($oldResult)['image'];
        if ($oldImage && file_exists("../../assets/products/" . $oldImage)) {
            unlink("../../../assets/products/" . $oldImage);
        }

        $query = "UPDATE products SET 
                  category_id = '$category_id', name = '$name', price_range = '$price_range', 
                  description = '$description', link_reference = '$link_reference', image = '$image'
                  WHERE id = $id";
    } else {
        $query = "UPDATE products SET 
                  category_id = '$category_id', name = '$name', price_range = '$price_range', 
                  description = '$description', link_reference = '$link_reference'
                  WHERE id = $id";
    }
    mysqli_query($conn, $query);
    header('Location: ../../?page=produk');
} elseif ($action === 'delete') {
    $id = $_GET['id'];

    // Hapus gambar
    $query = "SELECT image FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $image = mysqli_fetch_assoc($result)['image'];
    if ($image && file_exists(".../../../assets/products/" . $image)) {
        unlink("../../../assets/products/" . $image);
    }

    $query = "DELETE FROM products WHERE id = $id";
    mysqli_query($conn, $query);
    header('Location: ../../?page=produk');
}
?>
