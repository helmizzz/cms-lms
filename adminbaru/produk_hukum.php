<?php 
require_once '../includes/init.php';

// Fetch all legal products
$products = db_get_all("SELECT * FROM produk_hukum ORDER BY created_at DESC");

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Daftar Produk Hukum</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Regulasi & Peraturan</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>Nama Produk Hukum</th>
                                        <th>Kategori</th>
                                        <th style="width: 150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($products): ?>
                                        <?php $i=1; foreach ($products as $row): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td>
                                                <div class="fw-bold"><?= $row['title'] ?></div>
                                                <small class="text-muted"><?= $row['description'] ?></small>
                                            </td>
                                            <td><span class="badge text-bg-info"><?= $row['category'] ?></span></td>
                                            <td>
                                                <?php if ($row['file_path']): ?>
                                                    <a href="../assets/docs/produk_hukum/<?= $row['file_path'] ?>" target="_blank" class="btn btn-sm btn-warning w-100">
                                                        <i class="bi bi-download"></i> Download
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-secondary w-100" disabled>No File</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">Belum ada produk hukum yang terdaftar.</td>
                                        </tr>
                                    <?php endif; ?>
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
