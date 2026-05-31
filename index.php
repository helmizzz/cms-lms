<?php require_once "includes/init.php"; ?>
<?php
$hero_image = get_setting('hero_image', 'img/1.jpg');
if (!$hero_image) {
    $hero_image = 'img/1.jpg';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $settings["site_name"]; ?> - Solusi Informasi Hukum Terpercaya</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" >
	<link href="css/font-awesome.min.css" rel="stylesheet" >
	<link href="css/global.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="main-wrapper">
    <!-- Navigation -->
    <?php include "public/nav/top_nav.php"; ?>
    <div class="main_bg" style="background-image: linear-gradient(rgba(0,45,84,0.85), rgba(0,45,84,0.85)), url('<?= htmlspecialchars($hero_image, ENT_QUOTES, 'UTF-8') ?>'); background-size: cover; background-position: center;">
        <?php include "public/nav/main_nav.php"; ?>
        <?php include "public/nav/center_nav.php"; ?>
    </div>
    
    <!-- Quick Features -->
    <?php include "public/nav/manage_service.php"; ?>

    <!-- Main Content: News & Law Grid -->
    <?php include "public/index/news_grid.php"; ?>

    <!-- Secondary Content -->
    <?php include "public/about/skill.php"; ?>
    
    <!-- Interactive Section -->
    <?php include "public/index/faq.php"; ?>

    <!-- Footer -->
    <?php include "public/footer/footer.php"; ?>
    <?php include "public/footer/footerb.php"; ?>
</div>

<script>
window.onscroll = function() {myFunction()};

var navbar_sticky = document.getElementById("navbar_sticky");
var sticky = navbar_sticky.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky + 50) {
    navbar_sticky.classList.add("sticky")
  } else {
    navbar_sticky.classList.remove("sticky");
  }
}
</script>

</body>
</html>
