<?php 
require_once '../includes/init.php';

// Helper for file upload (legal products might be PDF/Docx)
function upload_doc($file, $target_dir = "../assets/docs/produk_hukum/") {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) return null;
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = time() . "_" . uniqid() . "." . $ext;
    $target_file = $target_dir . $filename;
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $filename;
    }
    return null;
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $title = clean($_POST['title']);
        $description = clean($_POST['description']);
        $category = clean($_POST['category']);
        $file_path = upload_doc($_FILES['doc_file']);

        db_query("INSERT INTO produk_hukum (title, description, file_path, category) VALUES (?, ?, ?, ?)", 
                 [$title, $description, $file_path, $category]);
        $success_msg = "Produk hukum berhasil ditambahkan!";
    }

    if (isset($_POST['delete_product'])) {
        $id = (int)$_POST['product_id'];
        $product = db_get_one("SELECT file_path FROM produk_hukum WHERE id = ?", [$id]);
        if ($product && $product['file_path']) {
            @unlink("../assets/docs/produk_hukum/" . $product['file_path']);
        }
        db_query("DELETE FROM produk_hukum WHERE id = ?", [$id]);
        $success_msg = "Produk hukum berhasil dihapus!";
    }
}

// Fetch products
$products = db_get_all("SELECT * FROM produk_hukum ORDER BY created_at DESC");

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kelola Produk Hukum</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <?php if (isset($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $success_msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Unggah Produk Hukum Baru</h3>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Judul / Nama Produk Hukum</label>
                                    <input type="text" name="title" class="form-control" placeholder="Contoh: Peraturan Daerah No. 1 Tahun 2024" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi Singkat</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi isi peraturan..."></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="category" class="form-select">
                                            <option value="Peraturan Pemerintah">Peraturan Pemerintah</option>
                                            <option value="Peraturan Daerah">Peraturan Daerah</option>
                                            <option value="Surat Keputusan">Surat Keputusan</option>
                                            <option value="Undang-Undang">Undang-Undang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">File Dokumen (PDF/DOCX)</label>
                                        <input type="file" name="doc_file" class="form-control" accept=".pdf,.doc,.docx" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="add_product" class="btn btn-warning">Unggah Dokumen</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Produk Hukum</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>Nama Produk Hukum</th>
                                        <th>Kategori</th>
                                        <th style="width: 150px">File</th>
                                        <th style="width: 150px">Tanggal Upload</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($products as $row): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <strong><?= $row['title'] ?></strong><br>
                                            <small class="text-muted"><?= $row['description'] ?></small>
                                        </td>
                                        <td><span class="badge text-bg-info"><?= $row['category'] ?></span></td>
                                        <td>
                                            <?php if ($row['file_path']): ?>
                                                <a href="../assets/docs/produk_hukum/<?= $row['file_path'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf"></i> Lihat File
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <form method="POST" onsubmit="return confirm('Hapus produk hukum ini?')" style="display:inline;">
                                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="delete_product" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>