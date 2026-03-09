<?php
$site_name = get_setting('site_name', 'LEXALINK ID');
$name_parts = explode(' ', $site_name);
$last_word = array_pop($name_parts);
$first_part = implode(' ', $name_parts);

// Fetch latest news for footer
$footer_news = db_get_all("SELECT * FROM posts WHERE type = 'news' AND status = 'published' ORDER BY created_at DESC LIMIT 3");

// Fetch gallery for footer
$footer_gallery = db_get_all("SELECT * FROM gallery ORDER BY created_at DESC LIMIT 9");
?>
<section id="footer" class="pt-5">
  <div class="container">
   <div class="row footer_1">
	  <div class="col-md-3">
	   <div class="footer_1i">
	    <h3 class="mb-4"><a class="navbar-brand text-white pt-1 m-0" href="index.php"><?= $first_part ?> <span class="col_oran"><?= $last_word ?></span></a></h3>
		<p class="col_light font_15 mb-4"><?= get_setting('about_summary', 'We provide professional consulting and financial solutions to help your business grow.') ?></p>
		<ul class="social-network social-circle mb-0 mt-2">
			<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
			<li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
			<li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
			<li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
		</ul>
	   </div>
	  </div>
	  <div class="col-md-3">
	   <div class="footer_1i">
	    <h4 class="mb-4 text-white">Latest News</h4>
        <?php foreach ($footer_news as $news): ?>
            <div class="row mb-3">
                <div class="col-md-3 col-3">
                <div class="footer_1i1l">
                    <?php if ($news['image']): ?>
                        <img src="assets/img/posts/<?= $news['image'] ?>" alt="news" class="rounded-circle w-10" style="height: 10px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-secondary w-100 d-flex align-items-center justify-content-center" style="height: 10px;">
                            <i class="fa fa-newspaper-o text-white"></i>
                        </div>
                    <?php endif; ?>
                </div>
                </div>
                <div class="col-md-9 px-0 col-9">
                <div class="footer_1i1r">
                    <p class="font_15 mb-0"><a class="col_light" href="blog_detail.php?slug=<?= $news['slug'] ?>"><?= substr($news['title'], 0, 40) ?>...</a></p>
                    <p class="col_oran font_13 fw-bold"><?= date('M d, Y', strtotime($news['created_at'])) ?></p>
                </div>
                </div>
            </div>
        <?php endforeach; ?>
	   </div>
	  </div>
	  <div class="col-md-3">
	   <div class="footer_1i2">
	    <h4 class="mb-4 text-white">Quick Links</h4>
	    <ul>
		 <li class="d-inline-block"><a href="index.php">Home</a></li>
		 <li class="d-inline-block"><a href="about.php">About Us</a></li>
		 <li class="d-inline-block"><a href="blog.php">Blog</a></li>
		 <li class="d-inline-block"><a href="services.php">Services</a></li>
		 <li class="d-inline-block"><a href="team.php">Team</a></li>
		 <li class="d-inline-block"><a href="contact.php">Contact Us</a></li>
		 <li class="d-inline-block"><a href="adminbaru/index.php">LMS Login</a></li>
		</ul>
	   </div>
	  </div>
	  <div class="col-md-3">
	   <div class="footer_1i2">
	    <h4 class="mb-4 text-white">Gallery</h4>
	    <div class="footer_1i2i row g-2">
            <?php foreach ($footer_gallery as $img): ?>
                <div class="col-4">
                    <div class="footer_1i2i1">
                        <a href="#"><img src="assets/img/gallery/<?= $img['image_path'] ?>" class="w-100 rounded" alt="gallery" style="height: 60px; object-fit: cover;"></a>
                    </div> 
                </div>
            <?php endforeach; ?>
		</div>
	   </div>
	  </div>
   </div>
  </div>
 </section>
