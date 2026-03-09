<?php
session_start();

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'carporate_db');

// Include global functions
require_once 'functions.php';

// Initialize Database Connection
$conn = db_connect();

// Global variable for site settings
$settings = [];
$raw_settings = db_get_all("SELECT setting_key, setting_value FROM site_settings");
if ($raw_settings) {
    foreach ($raw_settings as $s) {
        $settings[$s['setting_key']] = $s['setting_value'];
    }
}
?>
