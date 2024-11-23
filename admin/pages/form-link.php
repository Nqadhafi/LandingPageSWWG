<?php
include './config.php';

// Cek apakah ini aksi edit
$query = "SELECT * FROM links LIMIT 1"; // Mengambil data link yang sudah ada
$result = mysqli_query($conn, $query);
$links = mysqli_fetch_assoc($result);
?>
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manajemen Link</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Link</h3>
            </div>
            <div class="card-body">
                <form action="./pages/proses/link.php" method="POST">

                    <div class="form-group">
                        <label>Link Pricelist:</label>
                        <input type="url" name="pricelist" class="form-control" value="<?php echo isset($links['pricelist']) ? htmlspecialchars($links['pricelist']) : ''; ?>" >
                    </div>

                    <div class="form-group">
                        <label>Link Admin 1:</label>
                        <input type="url" name="admin1" class="form-control" value="<?php echo isset($links['admin1']) ? htmlspecialchars($links['admin1']) : ''; ?>" >
                    </div>

                    <div class="form-group">
                        <label>Link Admin 2:</label>
                        <input type="url" name="admin2" class="form-control" value="<?php echo isset($links['admin2']) ? htmlspecialchars($links['admin2']) : ''; ?>" >
                    </div>

                    <button type="submit" name="action" value="Update Links" class="btn btn-primary">Update Links</button>
                </form>
            </div>
        </div>
    </div>
</section>
