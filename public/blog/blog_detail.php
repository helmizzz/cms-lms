<?php
$slug = clean($_GET['slug'] ?? '');
if (!$slug) {
    header("Location: blog.php");
    exit;
}

// Fetch the post
$post = db_get_one("SELECT * FROM posts WHERE slug = ? AND status = 'published'", [$slug]);

if (!$post) {
    echo "<div class='container mt-5 pt-5'><div class='alert alert-danger'>Post tidak ditemukan.</div><a href='blog.php' class='btn btn-primary'>Kembali ke Blog</a></div>";
    exit;
}

// Fetch latest news for sidebar
$latest_news = db_get_all("SELECT * FROM posts WHERE type = 'news' AND status = 'published' ORDER BY created_at DESC LIMIT 3");
$location = get_setting('location', 'Eget city, New York');
?>
<section id="blog_pg" class="pt-5 pb-5">
 <div class="container">
  <div class="row blog_pg1">
   <div class="col-md-8">
    <div class="blog_pg1l">
	  
	  <div class="blog_pg1l1 pb-0 mb-0 border-0 blog_pg1dt">
	    <div class="grid clearfix">
		  <figure class="effect-jazz mb-0 rounded-4 overflow-hidden shadow">
            <?php if ($post['image']): ?>
			    <img src="assets/img/posts/<?= $post['image'] ?>" class="w-100" alt="post image" style="max-height: 500px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-light w-100 d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="fa fa-image fa-4x text-secondary opacity-25"></i>
                </div>
            <?php endif; ?>
		  </figure>
	  </div>
	    <h6 class="mt-4 font_14 text-uppercase fw-bold letter-spacing-1">
			<span class="text-secondary"><i class="fa fa-user me-1"></i> Admin</span> <span class="mx-2 text-muted">|</span>
			<span class="text-secondary"><i class="fa fa-calendar me-1"></i> <?= date('F d, Y', strtotime($post['created_at'])) ?></span>
       </h6>
	   <h1 class="font_34 mt-3 fw-bold text-dark"><?= $post['title'] ?></h1>
	   <div class="font_16 mt-4 blog-content-text lh-lg text-muted">
            <?= nl2br($post['content']) ?>
       </div>
	  </div>

      <div class="share-post mt-5 pt-4 border-top">
          <h5 class="fw-bold mb-3">Share this post:</h5>
          <ul class="social-network social-circle">
            <li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
          </ul>
      </div>

	</div>
   </div>
   <div class="col-md-4">
    <div class="blog_pg1r">
	  <div class="blog_pg1r1">
	    <div class="input-group">
				<input type="text" class="form-control" placeholder="Search">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="button">
						<i class="fa fa-search"></i></button>
				</span>
		</div>
	  </div>
	  <div class="blog_pg1r2 mt-4">
	    <h4 class="bg_head mb-4">Contact Info</h4>
		<h6 class="font_15"><i class="fa fa-map-marker text-oran"></i> <?= $location ?></h6>
		<h6 class="font_15"><i class="fa fa-clock-o text-oran"></i> Mon - Fri (08:00 - 17:00)</h6>
		<h6 class="font_15"><i class="fa fa-phone text-oran"></i> +62 ... (Update in Admin)</h6>
		<h6 class="font_15 border-0 pb-0 mb-0"><i class="fa fa-envelope text-oran"></i> info@lexalink.id</h6>
	  </div>
	  <div class="blog_pg1r2 mt-4">
	    <h4 class="bg_head mb-4">Latest News</h4>
        <?php foreach ($latest_news as $news): ?>
            <div class="footer_1i1 row mb-3">
                <div class="col-md-3 col-3">
                <div class="footer_1i1l">
                    <?php if ($news['image']): ?>
                        <img src="assets/img/posts/<?= $news['image'] ?>" alt="news" class="rounded-circle w-100" style="height: 60px; width: 60px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-secondary w-100 d-flex align-items-center justify-content-center" style="height: 60px; width: 60px;">
                            <i class="fa fa-newspaper-o text-white"></i>
                        </div>
                    <?php endif; ?>
                </div>
                </div>
                <div class="col-md-9 px-0 col-9 ps-3">
                <div class="footer_1i1r">
                    <p class="font_15 mb-0 fw-bold"><a href="blog_detail.php?slug=<?= $news['slug'] ?>"><?= substr($news['title'], 0, 45) ?>...</a></p>
                    <p class="col_oran font_13 mb-0"><?= date('M d, Y', strtotime($news['created_at'])) ?></p>
                </div>
                </div>
            </div>
        <?php endforeach; ?>
	  </div>
	</div>
   </div>
  </div>
 </div>
</section>
 