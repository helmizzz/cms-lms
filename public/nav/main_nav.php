<?php
$site_name = get_setting("site_name", "LEXALINK ID");
$name_parts = explode(" ", $site_name);
$last_word = array_pop($name_parts);
$first_part = implode(" ", $name_parts);

$all_menus = db_get_all("SELECT * FROM navbar_menus WHERE is_active = 1 ORDER BY sort_order ASC");
$current_page = basename($_SERVER["PHP_SELF"]);
$is_logged_in = is_authenticated();
$nav_user = [];
$dashboard_url = app_url('adminbaru/index.php');

if ($is_logged_in) {
    $nav_user = db_get_one("SELECT username, email, full_name, role, avatar FROM users WHERE id = ?", [$_SESSION['user_id']]) ?: [];
    $nav_role = $nav_user['role'] ?? ($_SESSION['role'] ?? 'user');
    $dashboard_url = $nav_role === 'admin' ? app_url('admview/index.php') : app_url('adminbaru/index.php');
}

$parents = [];
$children = [];
foreach ($all_menus as $m) {
    if (!$m["parent_id"]) {
        $parents[] = $m;
    } else {
        $children[$m["parent_id"]][] = $m;
    }
}

$display_name = $nav_user['full_name'] ?? ($_SESSION['full_name'] ?? 'User');
$username = $nav_user['username'] ?? ($_SESSION['username'] ?? '-');
$role = $nav_user['role'] ?? ($_SESSION['role'] ?? 'user');
$email = $nav_user['email'] ?? '-';
$avatar_src = get_user_avatar_src($nav_user['avatar'] ?? '');
$initial = strtoupper(substr(trim($display_name ?: $username), 0, 1));
?>
<section id="header">
  <nav class="navbar navbar-expand-lg navbar-dark py-2" id="navbar_sticky" style="background: var(--primary-color);">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <span style="color: var(--white); font-weight: 800; font-size: 1.1rem;"><?= $first_part ?></span>
        <span class="ms-1" style="color: var(--secondary-color); font-weight: 800; font-size: 1.1rem;"><?= $last_word ?></span>
      </a>
      
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon" style="width: 1.2rem; height: 1.2rem;"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-0 align-items-lg-center">
          <?php foreach ($parents as $p): 
              $has_children = isset($children[$p["id"]]);
              $is_active = ($current_page == $p["url"]);
              
              if ($has_children && !$is_active) {
                  foreach ($children[$p["id"]] as $c) {
                      if ($current_page == $c["url"]) { $is_active = true; break; }
                  }
              }
              
              if ($has_children): ?>
                  <li class="nav-item dropdown px-lg-1">
                      <a class="nav-link dropdown-toggle <?= $is_active ? "active" : "" ?>" href="#" data-bs-toggle="dropdown" style="font-size: 13px;">
                          <?= $p["title"] ?>
                      </a>
                      <ul class="dropdown-menu border-0 shadow-lg mt-2 py-2">
                          <?php foreach ($children[$p["id"]] as $c): ?>
                              <li><a class="dropdown-item py-1 px-3 small" href="<?= $c["url"] ?>"><?= $c["title"] ?></a></li>
                          <?php endforeach; ?>
                      </ul>
                  </li>
              <?php else: ?>
                  <li class="nav-item px-lg-1">
                      <a class="nav-link <?= $is_active ? "active" : "" ?>" href="<?= $p["url"] ?>" style="font-size: 13px;"><?= $p["title"] ?></a>
                  </li>
              <?php endif; ?>
          <?php endforeach; ?>

          <li class="nav-item ms-lg-2 border-start ps-lg-3 d-none d-lg-block">
            <form class="d-flex position-relative">
              <input class="form-control form-control-sm pe-4 rounded-pill border-0" type="search" placeholder="Cari..." style="background: rgba(255,255,255,0.1); color: white; width: 140px; font-size: 12px;">
              <button class="btn btn-link position-absolute end-0 text-white-50 p-1" type="submit"></button>
            </form>
          </li>
          
          <?php if ($is_logged_in): ?>
            <li class="nav-item ms-lg-2">
              <a class="btn btn-sm px-3 rounded-pill" href="<?= app_url('logout.php') ?>" style="background: var(--secondary-color); color: var(--primary-color); font-weight: 700; font-size: 11px; letter-spacing: 0.5px;">
                LOGOUT
              </a>
            </li>
            <li class="nav-item dropdown ms-lg-2 mt-2 mt-lg-0">
              <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle overflow-hidden" style="width: 34px; height: 34px; background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.35); color: var(--secondary-color); font-weight: 800; font-size: 13px;">
                  <?php if (!empty($avatar_src)): ?>
                    <img src="<?= htmlspecialchars($avatar_src, ENT_QUOTES, 'UTF-8') ?>" alt="Avatar <?= htmlspecialchars($display_name, ENT_QUOTES, 'UTF-8') ?>" style="width: 100%; height: 100%; object-fit: cover;">
                  <?php else: ?>
                    <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?>
                  <?php endif; ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-0" aria-labelledby="accountDropdown" style="min-width: 240px; border-radius: 8px; overflow: hidden;">
                <li class="px-3 py-3" style="background: var(--primary-color); color: var(--white);">
                  <div class="fw-bold small"><?= htmlspecialchars($display_name, ENT_QUOTES, 'UTF-8') ?></div>
                  <div class="text-white-50" style="font-size: 12px;"><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></div>
                </li>
                <li class="px-3 py-2">
                  <div class="text-muted" style="font-size: 11px;">Role</div>
                  <div class="small text-capitalize"><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?></div>
                </li>
                <li class="px-3 py-2">
                  <div class="text-muted" style="font-size: 11px;">Email</div>
                  <div class="small text-truncate"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></div>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                  <a class="dropdown-item small py-2" href="<?= htmlspecialchars($dashboard_url, ENT_QUOTES, 'UTF-8') ?>">
                    <i class="fa fa-tachometer me-2 text-warning"></i>Dashboard
                  </a>
                </li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item ms-lg-2">
              <a class="btn btn-sm px-3 rounded-pill" href="<?= app_url('login.php') ?>" style="background: var(--secondary-color); color: var(--primary-color); font-weight: 700; font-size: 11px; letter-spacing: 0.5px;">
                LOGIN
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</section>
