<?php 
require_once '../includes/init.php';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_gallery'])) {
        $caption = clean($_POST['caption']);
        $image = upload_image($_FILES['image'], "../assets/img/gallery/");

        if ($image) {
            db_query("INSERT INTO gallery (image_path, caption) VALUES (?, ?)", [$image, $caption]);
            $success_msg = "Foto berhasil ditambahkan ke galeri!";
        } else {
            $error_msg = "Gagal mengunggah foto.";
        }
    }

    if (isset($_POST['delete_gallery'])) {
        $id = (int)$_POST['gallery_id'];
        $item = db_get_one("SELECT image_path FROM gallery WHERE id = ?", [$id]);
        if ($item && $item['image_path']) {
            @unlink("../assets/img/gallery/" . $item['image_path']);
        }
        db_query("DELETE FROM gallery WHERE id = ?", [$id]);
        $success_msg = "Foto berhasil dihapus!";
    }
}

// Fetch gallery items
$gallery_items = db_get_all("SELECT * FROM gallery ORDER BY created_at DESC");

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kelola Galeri (Footer)</h3>
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
                <div class="col-md-4 mb-4">
                    <div class="card card-dark card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Foto Galeri</h3>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Foto</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Caption / Keterangan</label>
                                    <input type="text" name="caption" class="form-control" placeholder="Isi keterangan foto...">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="add_gallery" class="btn btn-dark w-100">Unggah ke Galeri</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Galeri</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <?php foreach ($gallery_items as $item): ?>
                                    <div class="col-6 col-sm-4 col-md-3 text-center">
                                        <div class="position-relative">
                                            <img src="../assets/img/gallery/<?= $item['image_path'] ?>" class="img-fluid rounded border shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
                                            <form method="POST" onsubmit="return confirm('Hapus foto ini?')" class="position-absolute top-0 end-0 p-1">
                                                <input type="hidden" name="gallery_id" value="<?= $item['id'] ?>">
                                                <button type="submit" name="delete_gallery" class="btn btn-danger btn-sm rounded-circle p-1">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <small class="d-block mt-1 text-truncate"><?= $item['caption'] ?: 'No Caption' ?></small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>
