<?php
// Fetch all published blogs
$blogs = db_get_all("SELECT * FROM posts WHERE type = 'blog' AND status = 'published' ORDER BY created_at DESC");

// Fetch latest news for sidebar
$latest_news = db_get_all("SELECT * FROM posts WHERE type = 'news' AND status = 'published' ORDER BY created_at DESC LIMIT 3");

$location = get_setting('location', 'Eget city, New York');
?>
<section id="blog_pg" class="pt-5 pb-5">
 <div class="container">
  <div class="row blog_pg1">
   <div class="col-md-8">
    <div class="blog_pg1l">
      <?php if (empty($blogs)): ?>
        <div class="alert alert-info border-0 shadow-sm rounded-3">Belum ada artikel blog yang diterbitkan.</div>
      <?php else: ?>
        <?php foreach ($blogs as $blog): ?>
            <div class="blog_pg1l1 mb-5">
                <div class="grid clearfix">
                <figure class="effect-jazz mb-0 rounded-4 overflow-hidden shadow-sm">
                    <a href="blog_detail.php?slug=<?= $blog['slug'] ?>">
                        <?php if ($blog['image']): ?>
                            <img src="assets/img/posts/<?= $blog['image'] ?>" class="w-100" alt="blog" style="height: 400px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light w-100 d-flex align-items-center justify-content-center" style="height: 400px;">
                                <i class="fa fa-image fa-5x text-secondary opacity-25"></i>
                            </div>
                        <?php endif; ?>
                    </a>
                </figure>
            </div>
                <h6 class="mt-4 font_14 text-uppercase fw-bold letter-spacing-1">
                    <span class="text-secondary"><i class="fa fa-user me-1"></i> Admin</span> <span class="mx-2 text-muted">|</span>
                    <span class="text-secondary"><i class="fa fa-calendar me-1"></i> <?= date('F d, Y', strtotime($blog['created_at'])) ?></span>
                </h6>
            <h2 class="font_34 mt-3 fw-bold"><a href="blog_detail.php?slug=<?= $blog['slug'] ?>" class="text-dark text-decoration-none hover-oran"><?= $blog['title'] ?></a></h2>
            <p class="font_16 mt-3 text-muted"><?= substr(strip_tags($blog['content']), 0, 250) ?>...</p>
            
            <div class="blog_pg1l1i mt-4 row">
                <div class="col-md-6">
                <div class="blog_pg1l1il">
                <h5 class="mb-0"><a href="blog_detail.php?slug=<?= $blog['slug'] ?>" class="button_2 rounded-pill px-4">Read More</a></h5>
                </div>
                </div>
            </div>
            </div>
        <?php endforeach; ?>
      <?php endif; ?>

	  <div class="pages mt-5 text-center">
		 <div class="col-md-12">
		   <ul class="mb-0">
			<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
			<li class="act"><a href="#">1</a></li>
			<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
		   </ul>
		 </div>
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