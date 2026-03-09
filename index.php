<?php require_once 'includes/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Carporate</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" >
	<link href="css/font-awesome.min.css" rel="stylesheet" >
	<link href="css/global.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>

</head>
<body>
<div class="main">
<div class="main_1">
<?php include 'public/nav/top_nav.php'; ?>
<?php include 'public/nav/main_nav.php'; ?>
<?php include 'public/nav/center_nav.php'; ?>
<?php include 'public/nav/manage_service.php'; ?>
</div>
</div>
<?php include 'public/about/value.php'; ?>
<?php include 'public/about/skill.php'; ?>

<?php include 'public/index/faq.php'; ?>
<?php include 'public/footer/footer.php'; ?>
<?php include 'public/footer/footerb.php'; ?>
<script>
window.onscroll = function() {myFunction()};

var navbar_sticky = document.getElementById("navbar_sticky");
var sticky = navbar_sticky.offsetTop;
var navbar_height = document.querySelector('.navbar').offsetHeight;

function myFunction() {
  if (window.pageYOffset >= sticky + navbar_height) {
    navbar_sticky.classList.add("sticky")
	document.body.style.paddingTop = navbar_height + 'px';
  } else {
    navbar_sticky.classList.remove("sticky");
	document.body.style.paddingTop = '0'
  }
}
</script>

</body>

</html>