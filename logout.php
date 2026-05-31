<?php
require_once 'includes/init.php';
session_destroy();
header('Location: ' . app_url('login.php'));
exit;
?>
