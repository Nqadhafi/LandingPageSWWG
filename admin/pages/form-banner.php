<?php
include './config.php';
include './auth.php';

// Cek apakah ini aksi edit
$isEdit = isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']);
$banner = null;

if ($isEdit) {
    $id = $_GET['id'];
    $query = "SELECT * FROM banners WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $banner = mysqli_fetch_assoc($result);
}
?>
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manajemen Banner</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $isEdit ? 'Edit Banner' : 'Tambah Banner'; ?></h3>
            </div>
            <div class="card-body">
                <form action="./pages/proses/banner.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $isEdit ? $banner['id'] : ''; ?>">

                    <div class="form-group">
                        <label>Judul Banner:</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($banner['title']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Upload Gambar:</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*" <?php echo $isEdit ? '' : 'required'; ?>>
                        <?php if ($isEdit && !empty($banner['image'])): ?>
                            <p>Gambar saat ini:</p>
                            <img src="../assets/banner/<?php echo htmlspecialchars($banner['image']); ?>" alt="Banner Image" style="max-width: 150px; height: auto;">
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Link Referensi:</label>
                        <input type="url" name="link_reference" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($banner['link_reference']) : ''; ?>" required>
                    </div>

                    <button type="submit" name="action" value="<?php echo $isEdit ? 'Update Banner' : 'Tambah Banner'; ?>" class="btn btn-primary">
                        <?php echo $isEdit ? 'Update Banner' : 'Tambah Banner'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Section untuk menampilkan daftar banner yang sudah ada -->
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Daftar Banner</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $query = "SELECT * FROM banners";
                    $result = mysqli_query($conn, $query);

                    while ($banner = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <h5 class="card-title text-center mt-5"><?php echo htmlspecialchars($banner['title']); ?></h5>
                                <div class="card-body text-center">
                                    <?php if ($banner['image']): ?>
                                        <img src="../assets/banner/<?php echo htmlspecialchars($banner['image']); ?>" alt="Banner Image" class="img-fluid mb-3" style="max-width: 100%; height: 150px; object-fit: cover;">
                                    <?php endif; ?>
                                    <p><strong>Link:</strong> <a href="<?php echo htmlspecialchars($banner['link_reference']); ?>" target="_blank"><?php echo htmlspecialchars($banner['link_reference']); ?></a></p>
                                    <a href="?page=banner&action=edit&id=<?php echo $banner['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="./pages/proses/banner.php?action=delete&id=<?php echo $banner['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus banner ini?');" class="btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>
