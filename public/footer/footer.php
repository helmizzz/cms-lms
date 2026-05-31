<?php
$site_name = get_setting("site_name", "LEXALINK ID");
$name_parts = explode(" ", $site_name);
$last_word = array_pop($name_parts);
$first_part = implode(" ", $name_parts);

$footer_news = db_get_all("SELECT * FROM posts WHERE type = 'blog' AND status = 'published' ORDER BY created_at DESC LIMIT 2");
?>
<section id="footer" class="py-5" style="background: #001529; border-top: 4px solid var(--secondary-color);">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="footer_logo mb-4">
           <h3 class="fw-800 m-0"><span style="color: white;"><?= $first_part ?></span> <span style="color: var(--secondary-color);"><?= $last_word ?></span></h3>
        </div>
        <p class="text-white-50 small lh-lg mb-4"><?= get_setting("about_summary", "Solusi terintegrasi untuk kebutuhan riset hukum, kepatuhan regulasi, dan berita hukum terkini di Indonesia.") ?></p>
        <div class="social-links">
           <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fa fa-facebook"></i></a>
           <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fa fa-twitter"></i></a>
           <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fa fa-linkedin"></i></a>
           <a href="#" class="btn btn-outline-light btn-sm rounded-circle"><i class="fa fa-instagram"></i></a>
        </div>
      </div>
      
      <div class="col-md-4 mb-4">
        <h5 class="text-white fw-bold mb-4">Berita Terbaru</h5>
        <?php foreach ($footer_news as $news): ?>
          <div class="d-flex mb-3 align-items-center">
            <div class="flex-shrink-0" style="width: 60px; height: 60px;">
              <img src="<?= $news["image"] ? "assets/img/posts/".$news["image"] : "img/default_blog.jpg" ?>" class="w-100 h-100 rounded object-fit-cover" alt="news">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-0"><a href="blog_detail.php?slug=<?= $news["slug"] ?>" class="text-white text-decoration-none small"><?= substr($news["title"], 0, 50) ?>...</a></h6>
              <span class="text-warning extra-small"><?= date("d M Y", strtotime($news["created_at"])) ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      
      <div class="col-md-2 mb-4">
        <h5 class="text-white fw-bold mb-4">Navigasi</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="index.php" class="text-white-50 text-decoration-none small hover-text-warning transition">Beranda</a></li>
          <li class="mb-2"><a href="about.php" class="text-white-50 text-decoration-none small hover-text-warning transition">Tentang Kami</a></li>
          <li class="mb-2"><a href="blog.php" class="text-white-50 text-decoration-none small hover-text-warning transition">Berita Hukum</a></li>
          <li class="mb-2"><a href="services.php" class="text-white-50 text-decoration-none small hover-text-warning transition">Produk Hukum</a></li>
          <li class="mb-2"><a href="contact.php" class="text-white-50 text-decoration-none small hover-text-warning transition">Kontak</a></li>
        </ul>
      </div>
      
      <div class="col-md-2 mb-4">
        <h5 class="text-white fw-bold mb-4">Bantuan</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none small hover-text-warning transition">Pusat Bantuan</a></li>
          <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none small hover-text-warning transition">Syarat & Ketentuan</a></li>
          <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none small hover-text-warning transition">Kebijakan Privasi</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>
<style>
.extra-small { font-size: 11px; }
.object-fit-cover { object-fit: cover; }
.hover-text-warning:hover { color: var(--secondary-color) !important; padding-left: 5px; }
.transition { transition: all 0.3s ease; }
</style>
