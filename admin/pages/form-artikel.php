<?php
include './config.php';
include './auth.php';

// Cek apakah artikel sudah ada
$query = "SELECT * FROM article LIMIT 1";
$result = mysqli_query($conn, $query);
$article = mysqli_fetch_assoc($result);

// Cek apakah ini aksi edit
$isEdit = isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']);
$editingArticle = null;

if ($isEdit) {
    $id = $_GET['id'];
    $query = "SELECT * FROM article WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $editingArticle = mysqli_fetch_assoc($result);
}
?>


    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Manajemen Artikel</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo $isEdit ? "Edit Artikel" : (!$article ? "Tambah Artikel" : "Artikel Saat Ini"); ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (!$article || $isEdit): ?>
                        <!-- Form untuk tambah/edit artikel -->
                        <form action="./pages/proses/artikel.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $isEdit ? $editingArticle['id'] : ''; ?>">

                            <div class="form-group">
                                <label>Judul Artikel:</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($editingArticle['title']) : ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Teks Artikel:</label>
                                <textarea name="content" class="form-control" rows="5" required><?php echo $isEdit ? htmlspecialchars($editingArticle['content']) : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Upload Gambar:</label>
                                <input type="file" name="image" class="form-control-file" accept="image/*" <?php echo $isEdit ? '' : 'required'; ?>>
                            </div>

                            <div class="form-group">
                                <label>Alt Text:</label>
                                <input type="text" name="alt_text" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($editingArticle['alt_text']) : ''; ?>" required>
                            </div>
                            <input type="hidden" name="action" value="<?php echo $isEdit ? 'Update Artikel' : 'Tambah Artikel'; ?>">
                            <button type="submit"  class="btn btn-primary">
                                <?php echo $isEdit ? 'Update Artikel' : 'Tambah Artikel'; ?>
                            </button>
                        </form>
                    <?php else: ?>
                        <!-- Tampilkan artikel -->
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
                        <?php if ($article['image']): ?>
                            <img src="../assets/img/<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image" class="img-fluid mb-3" style="max-width: 200px;">
                        <?php endif; ?>
                        <p><strong>Referensi:</strong> <?php echo htmlspecialchars($article['alt_text']); ?></p>

                        <a href="?page=artikel&action=edit&id=<?php echo $article['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="pages/proses/artikel.php?action=delete&id=<?php echo $article['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');" class="btn btn-danger">Hapus</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>



