<?php 
require_once '../includes/init.php';

// Fetch Statistics
$count_news = db_get_one("SELECT COUNT(*) as total FROM posts WHERE type = 'news'")['total'];
$count_articles = db_get_one("SELECT COUNT(*) as total FROM posts WHERE type = 'blog'")['total'];
$count_products = db_get_one("SELECT COUNT(*) as total FROM produk_hukum")['total'];
$count_gallery = db_get_one("SELECT COUNT(*) as total FROM gallery")['total'];

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Admin Dashboard CMS</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-primary shadow-sm">
                            <i class="bi bi-newspaper"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Berita</span>
                            <span class="info-box-number"><?= $count_news ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-success shadow-sm">
                            <i class="bi bi-journal-text"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Artikel</span>
                            <span class="info-box-number"><?= $count_articles ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-warning shadow-sm text-white">
                            <i class="bi bi-file-earmark-lock"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Produk Hukum</span>
                            <span class="info-box-number"><?= $count_products ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-danger shadow-sm">
                            <i class="bi bi-images"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Foto Galeri</span>
                            <span class="info-box-number"><?= $count_gallery ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Selamat Datang di Panel CMS (Admin)</h3>
                        </div>
                        <div class="card-body">
                            <p>Panel ini digunakan untuk mengelola seluruh konten statis maupun dinamis pada landing page website Anda. Gunakan menu di sebelah kiri untuk mulai melakukan konfigurasi:</p>
                            <ul>
                                <li><strong>Kelola Navbar & Footer</strong>: Mengubah nama website, link menu, dan info lokasi.</li>
                                <li><strong>Kelola Isi Landing</strong>: Mengubah teks banner (Hero) dan konten "About Us".</li>
                                <li><strong>Kelola Berita & Artikel</strong>: Publikasi update terbaru dan tulisan blog.</li>
                                <li><strong>Kelola Produk Hukum</strong>: Dokumentasi regulasi dan peraturan.</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="../index.php" target="_blank" class="btn btn-outline-primary">Buka Website Utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>