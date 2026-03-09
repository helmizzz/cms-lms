<?php

/**
 * Database Connection
 */
function db_connect() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

/**
 * Execute Prepared Statement
 */
function db_query($sql, $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    if ($params) {
        $types = "";
        foreach ($params as $param) {
            if (is_int($param)) $types .= "i";
            elseif (is_double($param)) $types .= "d";
            else $types .= "s";
        }
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt;
}

/**
 * Fetch All Rows
 */
function db_get_all($sql, $params = []) {
    $stmt = db_query($sql, $params);
    if (!$stmt) return [];
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Fetch Single Row
 */
function db_get_one($sql, $params = []) {
    $stmt = db_query($sql, $params);
    if (!$stmt) return null;
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

/**
 * Authentication check
 */
function is_authenticated() {
    return isset($_SESSION['user_id']);
}

/**
 * Get Setting Value
 */
function get_setting($key, $default = "") {
    global $settings;
    return isset($settings[$key]) ? $settings[$key] : $default;
}

/**
 * Generate Slug
 */
function generate_slug($string) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return $slug;
}

/**
 * Upload Image Helper
 */
function upload_image($file, $target_dir = "../assets/img/posts/") {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) return null;
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = time() . "_" . uniqid() . "." . $ext;
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $filename;
    }
    return null;
}
/**
 * Clean & Sanitize Input
 */
function clean($data) {
    global $conn;
    if (is_array($data)) {
        return array_map('clean', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    if ($conn && $data) {
        $data = $conn->real_escape_string($data);
    }
    return $data;
}

function db_execute($sql, $params = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    if ($params) {
        $types = "";
        foreach ($params as $param) {
            if (is_int($param)) $types .= "i";
            elseif (is_double($param)) $types .= "d";
            else $types .= "s";
        }
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt;
}


/**
 * Redirect based on user role
 */
function redirect_by_role($role) {
    if ($role === 'admin') {
        header('Location: ../admview/index.php');
    } else {
        header('Location: ../adminbaru/index.php');
    }
    exit;
}

/**
 * Access control check
 */
function check_access($allowed_roles = []) {
    if (!is_authenticated()) {
        header('Location: ../adminbaru/login.php');
        exit;
    }
    
    if (!empty($allowed_roles) && !in_array($_SESSION['role'], $allowed_roles)) {
        // Forbidden or redirect to their own dashboard
        redirect_by_role($_SESSION['role']);
    }
}
?>
