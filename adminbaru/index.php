<?php 
require_once '../includes/init.php';

// Fetch Statistics for User
$count_news = db_get_one("SELECT COUNT(*) as total FROM posts WHERE type = 'news' AND status = 'published'")['total'];
$count_products = db_get_one("SELECT COUNT(*) as total FROM produk_hukum")['total'];
$count_articles = db_get_one("SELECT COUNT(*) as total FROM posts WHERE type = 'blog' AND status = 'published'")['total'];

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">User Dashboard</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-4 mb-4">
                    <div class="small-box text-bg-primary shadow-sm h-100 p-4">
                        <div class="inner">
                            <h3><?= $count_news ?></h3>
                            <p>Berita & Informasi Terbaru</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-newspaper" style="font-size: 60px; opacity: 0.3;"></i>
                        </div>
                        <a href="berita.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover mt-3">
                            Lihat Berita <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-4">
                    <div class="small-box text-bg-warning shadow-sm h-100 p-4">
                        <div class="inner">
                            <h3><?= $count_products ?></h3>
                            <p>Produk Hukum & Regulasi</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-file-earmark-lock" style="font-size: 60px; opacity: 0.3;"></i>
                        </div>
                        <a href="produk_hukum.php" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover mt-3">
                            Lihat Dokumen <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-4">
                    <div class="small-box text-bg-info shadow-sm h-100 p-4">
                        <div class="inner">
                            <h3><?= $count_articles ?></h3>
                            <p>Artikel Terbaru</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-file-earmark-lock" style="font-size: 60px; opacity: 0.3;"></i>
                        </div>
                        <a href="artikel.php" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover mt-3">
                            Lihat Artikel <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">Selamat Datang di Portal Website kami, <?= $_SESSION['full_name'] ?? 'User' ?>!</h3>
                        </div>
                        <div class="card-body">
                            <p>Di dashboard ini, Anda dapat mengakses berbagai informasi penting seputar berita perusahaan dan produk hukum terbaru yang kami terbitkan.</p>
                            <div class="d-flex gap-3 mt-4">
                                <a href="profile.php" class="btn btn-outline-info">
                                    <i class="bi bi-person-circle me-1"></i> Edit Profil Saya
                                </a>
                                <a href="#" class="btn btn-outline-secondary">
                                    <i class="bi bi-question-circle me-1"></i> Pusat Bantuan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>