<?php
include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pricelist = mysqli_real_escape_string($conn, $_POST['pricelist']);
    $admin1 = mysqli_real_escape_string($conn, $_POST['admin1']);
    $admin2 = mysqli_real_escape_string($conn, $_POST['admin2']);

    // Cek apakah data sudah ada
    $query = "SELECT * FROM links LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika data ada, update
        $query = "UPDATE links SET pricelist = '$pricelist', admin1 = '$admin1', admin2 = '$admin2' WHERE id = 1";
    } else {
        // Jika data tidak ada, insert
        $query = "INSERT INTO links (pricelist, admin1, admin2) VALUES ('$pricelist', '$admin1', '$admin2')";
    }

    if (mysqli_query($conn, $query)) {
        header('Location: ../../index.php?page=link');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
