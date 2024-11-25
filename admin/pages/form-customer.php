<?php
include './config.php';
include './auth.php';

// Cek apakah ini aksi edit
$isEdit = isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']);
$customer = null;

if ($isEdit) {
    $id = $_GET['id'];
    $query = "SELECT * FROM customers WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);
}
?>
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manajemen Customer</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $isEdit ? 'Edit Customer' : 'Tambah Customer'; ?></h3>
            </div>
            <div class="card-body">
                <form action="./pages/proses/customer.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $isEdit ? $customer['id'] : ''; ?>">

                    <div class="form-group">
                        <label>Nama Customer:</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($customer['name']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Gambar Customer:</label>
                        <?php if ($isEdit && $customer['image']): ?>
                            <div>
                                <img src="../assets/client/<?php echo htmlspecialchars($customer['image']); ?>" alt="Customer Image" class="img-thumbnail mb-2" style="max-width: 150px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control" <?php echo $isEdit ? '' : 'required'; ?>>
                    </div>

                    <div class="form-group">
                        <label>Link Referensi:</label>
                        <input type="url" name="reference" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($customer['reference']) : ''; ?>" required>
                    </div>

                    <button type="submit" name="action" value="<?php echo $isEdit ? 'Update Customer' : 'Tambah Customer'; ?>" class="btn btn-primary">
                        <?php echo $isEdit ? 'Update Customer' : 'Tambah Customer'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Section untuk menampilkan daftar customer -->
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Daftar Customer</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $query = "SELECT * FROM customers";
                    $result = mysqli_query($conn, $query);

                    while ($customer = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <h5 class="card-title text-center mt-3"><?php echo htmlspecialchars($customer['name']); ?></h5>
                                <div class="card-body text-center">
                                    <?php if ($customer['image']): ?>
                                        <img src="../assets/client/<?php echo htmlspecialchars($customer['image']); ?>" alt="Customer Image" class="img-thumbnail mb-3" style="max-height: 15rem;">
                                    <?php endif; ?>
                                    <p><a href="<?php echo htmlspecialchars($customer['reference']); ?>" target="_blank">Link Referensi</a></p>
                                    <a href="?page=customer&action=edit&id=<?php echo $customer['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="./pages/proses/customer.php?action=delete&id=<?php echo $customer['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus customer ini?');" class="btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>
