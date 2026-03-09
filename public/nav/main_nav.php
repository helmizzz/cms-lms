<?php
$site_name = get_setting('site_name', 'LEXALINK ID');
$name_parts = explode(' ', $site_name);
$last_word = array_pop($name_parts);
$first_part = implode(' ', $name_parts);

// Fetch all active menus
$all_menus = db_get_all("SELECT * FROM navbar_menus WHERE is_active = 1 ORDER BY sort_order ASC");
$current_page = basename($_SERVER['PHP_SELF']);

// Structure hierarchical menus
$parents = [];
$children = [];
foreach ($all_menus as $m) {
    if (!$m['parent_id']) {
        $parents[] = $m;
    } else {
        $children[$m['parent_id']][] = $m;
    }
}
?>
<section id="header">
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none; top:0;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-transparent border-0">
          <div class="modal-header border-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
          </div>
          <div class="modal-body p-0">
            <div class="search_1">
               <div class="input-group">
                  <input type="text" class="form-control bg-transparent border-0" placeholder="Type your keyword..">
                  <span class="input-group-btn">
                    <button class="btn btn-primary bg-transparent border-0" type="button">
                        <i class="fa fa-search"></i></button>
                  </span>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  <nav class="navbar navbar-expand-md navbar-light pt-3 pb-3" id="navbar_sticky">
    <div class="container">
    <a class="navbar-brand text-white pt-1 m-0" href="index.php"><?= $first_part ?> <span class="col_oran"><?= $last_word ?></span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mb-0 ms-auto d-flex align-items-center">
        <?php foreach ($parents as $p): 
            $has_children = isset($children[$p['id']]);
            $is_active = ($current_page == $p['url']);
            
            // Check if any child is active to highlight parent
            if ($has_children && !$is_active) {
                foreach ($children[$p['id']] as $c) {
                    if ($current_page == $c['url']) {
                        $is_active = true;
                        break;
                    }
                }
            }
            
            if ($has_children): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $is_active ? 'active' : '' ?>" href="#" id="drop_<?= $p['id'] ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $p['title'] ?>
                    </a>
                    <ul class="dropdown-menu border-0 shadow" aria-labelledby="drop_<?= $p['id'] ?>">
                        <?php foreach ($children[$p['id']] as $c): ?>
                            <li><a class="dropdown-item <?= ($current_page == $c['url']) ? 'active' : '' ?>" href="<?= $c['url'] ?>"><?= $c['title'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link <?= $is_active ? 'active' : '' ?>" href="<?= $p['url'] ?>"><?= $p['title'] ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <li class="nav-item"><a class="nav-link drop_togn" data-bs-target="#exampleModal2" data-bs-toggle="modal" href="#"><i class="fa fa-search"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="adminbaru/index.php"><i class="fa fa-user"></i></a></li>
      </ul>
    </div>
  </div>
  </nav>
</section>
