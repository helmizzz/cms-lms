<?php 
require_once '../includes/init.php';

// Fetch latest news
$news_list = db_get_all("SELECT * FROM posts WHERE type = 'news' AND status = 'published' ORDER BY created_at DESC");

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Berita Terbaru</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <?php if ($news_list): ?>
                    <?php foreach ($news_list as $news): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden">
                                <?php if ($news['image']): ?>
                                    <img src="../assets/img/posts/<?= $news['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light text-center py-5">
                                        <i class="bi bi-image text-muted" style="font-size: 50px;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?= $news['title'] ?></h5>
                                    <p class="card-text text-muted small mt-2">
                                        <?= substr(strip_tags($news['content']), 0, 100) ?>...
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-secondary"><?= date('d M Y', strtotime($news['created_at'])) ?></small>
                                        <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center mt-5">
                        <div class="bg-white p-5 rounded border shadow-sm d-inline-block">
                            <i class="bi bi-newspaper text-muted" style="font-size: 80px;"></i>
                            <h4 class="mt-3 text-secondary">Belum ada berita terbaru.</h4>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>
