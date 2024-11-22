<?php
include './config.php';

// Cek apakah ini aksi edit
$isEdit = isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']);
$category = null;

if ($isEdit) {
    $id = $_GET['id'];
    $query = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);
}
?>
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manajemen Kategori</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $isEdit ? 'Edit Kategori' : 'Tambah Kategori'; ?></h3>
            </div>
            <div class="card-body">
                <form action="./pages/proses/kategori.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $isEdit ? $category['id'] : ''; ?>">

                    <div class="form-group">
                        <label>Nama Kategori:</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($category['name']) : ''; ?>" required>
                    </div>

                    <button type="submit" name="action" value="<?php echo $isEdit ? 'Update Kategori' : 'Tambah Kategori'; ?>" class="btn btn-primary">
                        <?php echo $isEdit ? 'Update Kategori' : 'Tambah Kategori'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Section untuk menampilkan daftar kategori -->
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Daftar Kategori</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $query = "SELECT * FROM categories";
                    $result = mysqli_query($conn, $query);

                    while ($category = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <h5 class="card-title text-center mt-3"><?php echo htmlspecialchars($category['name']); ?></h5>
                                <div class="card-body text-center">
                                    <a href="?page=kategori&action=edit&id=<?php echo $category['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="./pages/proses/kategori.php?action=delete&id=<?php echo $category['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>
