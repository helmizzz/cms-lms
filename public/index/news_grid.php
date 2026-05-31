<?php
// Fetch latest 3 blogs
$latest_blogs = db_get_all("SELECT * FROM posts WHERE type = 'blog' AND status = 'published' ORDER BY created_at DESC LIMIT 3");
// Fetch latest 4 legal products
$latest_law = db_get_all("SELECT * FROM produk_hukum ORDER BY created_at DESC LIMIT 4");
?>

<section id="news_grid" class="py-5 bg-light">
  <div class="container">
    <div class="row mb-4 align-items-end">
      <div class="col-md-8">
        <h6 class="text-warning fw-bold mb-2">UPDATE TERBARU</h6>
        <h2 class="text-primary fw-bold">Berita & Analisis Hukum</h2>
      </div>
      <div class="col-md-4 text-md-end">
        <a href="blog.php" class="text-primary fw-bold text-decoration-none">Lihat Semua Berita <i class="fa fa-angle-right ms-1"></i></a>
      </div>
    </div>
    
    <div class="row g-4">
      <?php if ($latest_blogs): foreach ($latest_blogs as $blog): ?>
        <div class="col-md-4">
          <div class="card h-100 border-0 shadow-sm overflow-hidden news-card">
            <div class="position-relative">
              <img src="<?= $blog['image'] ? 'assets/img/posts/'.$blog['image'] : 'img/default_blog.jpg' ?>" class="card-img-top" alt="<?= $blog['title'] ?>" style="height: 220px; object-fit: cover;">
              <span class="position-absolute top-0 start-0 m-3 badge bg-warning text-dark rounded-pill px-3 py-2">BERITA</span>
            </div>
            <div class="card-body p-4">
              <div class="d-flex align-items-center mb-2 text-muted small">
                <i class="fa fa-calendar-o me-2"></i> <?= date('d M Y', strtotime($blog['created_at'])) ?>
              </div>
              <h5 class="card-title fw-bold mb-3">
                <a href="blog_detail.php?slug=<?= $blog['slug'] ?>" class="text-primary text-decoration-none stretched-link"><?= $blog['title'] ?></a>
              </h5>
              <p class="card-text text-muted small"><?= substr(strip_tags($blog['content']), 0, 100) ?>...</p>
            </div>
          </div>
        </div>
      <?php endforeach; else: ?>
        <div class="col-12 text-center py-5">
           <p class="text-muted">Belum ada berita terbaru.</p>
        </div>
      <?php endif; ?>
    </div>

    <div class="row mt-5 pt-5 border-top">
      <div class="col-md-12 mb-4">
        <h6 class="text-warning fw-bold mb-2">DOKUMEN TERBARU</h6>
        <h2 class="text-primary fw-bold">Produk Hukum</h2>
      </div>
      
      <div class="col-md-12">
        <div class="row g-3">
          <?php if ($latest_law): foreach ($latest_law as $law): ?>
            <div class="col-md-6">
              <div class="d-flex align-items-start p-3 bg-white border rounded shadow-sm hover-shadow transition">
                <div class="bg-primary-light text-warning p-3 rounded me-3">
                  <i class="fa fa-file-pdf-o fa-2x"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-1 text-primary"><?= $law['title'] ?></h6>
                  <p class="text-muted small mb-1"><?= $law['category'] ?> | <?= date('Y', strtotime($law['created_at'])) ?></p>
                  <a href="<?= $law['file_path'] ?>" class="text-warning small fw-bold text-decoration-none"><i class="fa fa-download me-1"></i> Unduh Dokumen</a>
                </div>
              </div>
            </div>
          <?php endforeach; else: ?>
            <p class="text-muted text-center w-100">Belum ada produk hukum terbaru.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.news-card { transition: transform 0.3s ease; }
.news-card:hover { transform: translateY(-10px); }
.hover-shadow:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; cursor: pointer; }
.bg-primary-light { background: #eef4f9; }
</style>
