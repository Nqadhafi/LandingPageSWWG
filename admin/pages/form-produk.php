<?php
include './config.php';
include './auth.php';


// Cek apakah ini aksi edit
$isEdit = isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id']);
$product = null;

if ($isEdit) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
}
?>
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Manajemen Produk</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Tombol untuk toggle form -->
         <?php if ($isEdit) : ?>
         <a href="?page=produk" class="btn btn-primary mb-4">Form Tambah Produk (Klik 2x)</a>
         <?php else :?>
        <button id="toggleFormBtn" class="btn btn-primary mb-3" data-toggle="collapse" data-target="#formProduk">
   Form Tambah Produk
</button>
<?php endif;?>
        <!-- Form tambah/edit produk -->
<div id="formProduk" class="collapse">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $isEdit ? 'Edit Produk' : 'Tambah Produk'; ?></h3>
        </div>
        <div class="card-body">
            <form id="produkForm" action="./pages/proses/produk.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $isEdit ? $product['id'] : ''; ?>">
                <!-- Form fields -->
                <!-- Kategori -->
                <div class="form-group">
                    <label>Kategori:</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        $query = "SELECT * FROM categories";
                        $categories = mysqli_query($conn, $query);
                        while ($category = mysqli_fetch_assoc($categories)) {
                            $selected = $isEdit && $category['id'] == $product['category_id'] ? 'selected' : '';
                            echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Nama Produk -->
                <div class="form-group">
                    <label>Nama Produk:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($product['name']) : ''; ?>" required>
                </div>

                <!-- Range Harga -->
                <div class="form-group">
                    <label>Range Harga:</label>
                    <input type="text" name="price_range" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($product['price_range']) : ''; ?>" required>
                </div>

<!-- Deskripsi -->
<div class="form-group">
    <label>Deskripsi:</label>
    <textarea name="description" class="form-control" rows="5" required><?= $isEdit ? htmlspecialchars($product['description']) : ''; ?></textarea>
</div>


                <!-- Link Referensi -->
                <div class="form-group">
                    <label>Link Referensi:</label>
                    <input type="url" name="link_reference" class="form-control" value="<?php echo $isEdit ? htmlspecialchars($product['link_reference']) : ''; ?>" required>
                </div>

                <!-- Upload Gambar -->
                <div class="form-group">
                    <label>Upload Gambar:</label>
                    <input type="file" name="image" class="form-control-file" accept="image/*" <?php echo $isEdit ? '' : 'required'; ?>>
                    <?php if ($isEdit && !empty($product['image'])): ?>
                        <p>Gambar saat ini:</p>
                        <img src="../assets/product/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width: 150px; height: auto;">
                    <?php endif; ?>
                </div>

                <button type="submit" name="action" value="<?php echo $isEdit ? 'Update Produk' : 'Tambah Produk'; ?>" class="btn btn-primary">
                    <?php echo $isEdit ? 'Update Produk' : 'Tambah Produk'; ?>
                </button>
            </form>
        </div>
    </div>
</div>

    <!-- Filter Kategori -->
    <div class="mb-3">
        <form method="GET">
            <input type="hidden" name="page" value="produk">
            <select name="filter_category" class="form-control w-25 d-inline-block">
                <option value="">Semua Kategori</option>
                <?php
                $query = "SELECT * FROM categories";
                $categories = mysqli_query($conn, $query);
                while ($category = mysqli_fetch_assoc($categories)) {
                    $selected = isset($_GET['filter_category']) && $_GET['filter_category'] == $category['id'] ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>
    </div>

    <!-- Section untuk menampilkan daftar produk -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Produk</h3>
        </div>
        <div class="card-body">
            <div class="row m-5">
                <?php
                $filterCategory = isset($_GET['filter_category']) ? $_GET['filter_category'] : '';
                $query = "SELECT products.*, categories.name AS category_name FROM products 
                          LEFT JOIN categories ON products.category_id = categories.id";
                if (!empty($filterCategory)) {
                    $query .= " WHERE products.category_id = '$filterCategory'";
                }
                $result = mysqli_query($conn, $query);

                while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <h5 class="card-title text-center mt-3"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <div class="card-body">
                                <?php if ($product['image']): ?>
                                    <img src="../assets/product/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="img-fluid mb-3" style="max-width: 100%; height: 150px; object-fit: cover;">
                                <?php endif; ?>
                                <p><strong>Kategori:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                                <p><strong>Harga:</strong> <?php echo htmlspecialchars($product['price_range']); ?></p>
                                <p><strong>Deskripsi:</strong> <?= nl2br(htmlspecialchars($product['description'])); ?></p>
                                <p><strong>Link:</strong> <a href="<?php echo htmlspecialchars($product['link_reference']); ?>" target="_blank"><?php echo htmlspecialchars($product['link_reference']); ?></a></p>
                                <a href="?page=produk&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="./pages/proses/produk.php?action=delete&id=<?php echo $product['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="btn btn-danger btn-sm">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const action = urlParams.get('action');
        const toggleFormBtn = document.getElementById('toggleFormBtn');
        const produkForm = document.getElementById('produkForm');
        const formProduk = document.getElementById('formProduk');

        // Buka form otomatis jika dalam mode edit
        if (action === 'edit') {
            formProduk.classList.add('show'); // Buka collapse form
            toggleFormBtn.setAttribute('aria-expanded', 'true'); // Ubah atribut aria
        }

        // Reset form ketika tombol toggle diklik (jika tidak dalam mode edit)
        toggleFormBtn.addEventListener('click', function() {
            if (action !== 'edit') {
                produkForm.reset();
                // Hapus value hidden input ID jika ada
                const hiddenId = produkForm.querySelector('input[name="id"]');
                if (hiddenId) hiddenId.value = '';
            }
        });
    });
</script>