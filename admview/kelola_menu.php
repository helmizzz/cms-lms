<?php 
require_once '../includes/init.php';

$edit_data = null;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_settings'])) {
        $site_name = clean($_POST['site_name']);
        $location = clean($_POST['location']);
        $footer_about = clean($_POST['footer_about']);
        
        db_execute("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'site_name'", [$site_name]);
        db_execute("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'location'", [$location]);
        db_execute("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'footer_about'", [$footer_about]);
        
        $success_msg = "Pengaturan berhasil diperbarui!";
    }
    
    // Add or Update Menu
    if (isset($_POST['add_menu'])) {
        $id = isset($_POST['menu_id']) ? (int)$_POST['menu_id'] : 0;
        $parent_id = (int)$_POST['parent_id'];
        $parent_val = ($parent_id > 0) ? $parent_id : null; // Use NULL for top-level
        $title = clean($_POST['menu_title']);
        $url = clean($_POST['menu_url']);
        $sort = (int)$_POST['menu_sort'];
        $is_active = (int)$_POST['is_active'];
        
        if ($id > 0) {
            db_execute("UPDATE navbar_menus SET parent_id = ?, title = ?, url = ?, sort_order = ?, is_active = ? WHERE id = ?", [$parent_val, $title, $url, $sort, $is_active, $id]);
            $success_msg = "Menu berhasil diperbarui!";
        } else {
            db_execute("INSERT INTO navbar_menus (parent_id, title, url, sort_order, is_active) VALUES (?, ?, ?, ?, ?)", [$parent_val, $title, $url, $sort, $is_active]);
            $success_msg = "Menu baru berhasil ditambahkan!";
        }
    }

    if (isset($_POST['delete_menu'])) {
        $id = (int)$_POST['menu_id'];
        $menu = db_get_one("SELECT * FROM navbar_menus WHERE id = ?", [$id]);
        $default_urls = ['index.php', 'blog.php', 'about.php', 'services.php', 'team.php', 'contact.php'];
        
        if (in_array($menu['url'], $default_urls)) {
            $error_msg = "Menu bawaan tidak dapat dihapus!";
        } else {
            db_execute("DELETE FROM navbar_menus WHERE id = ? OR parent_id = ?", [$id, $id]);
            $success_msg = "Menu berhasil dihapus!";
        }
    }

    // Load data for editing
    if (isset($_POST['edit_menu_trigger'])) {
        $id = (int)$_POST['menu_id'];
        $edit_data = db_get_one("SELECT * FROM navbar_menus WHERE id = ?", [$id]);
    }
}

// Fetch all menus ordered for hierarchy
$all_menus = db_get_all("SELECT * FROM navbar_menus ORDER BY sort_order ASC, title ASC");
$default_urls = ['index.php', 'blog.php', 'about.php', 'services.php', 'team.php', 'contact.php'];

// Structure menus for display
$parents = [];
$children = [];
foreach ($all_menus as $m) {
    if (!$m['parent_id']) {
        $parents[] = $m;
    } else {
        $children[$m['parent_id']][] = $m;
    }
}

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Kelola Menu & Dropdown</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <?php if (isset($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $success_msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error_msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Identitas -->
                <div class="col-md-4 mb-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header"><h3 class="card-title">Identitas Website</h3></div>
                        <form method="POST">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label small">Nama Website</label>
                                    <input type="text" name="site_name" class="form-control form-control-sm" value="<?= get_setting('site_name') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Lokasi Kantor</label>
                                    <input type="text" name="location" class="form-control form-control-sm" value="<?= get_setting('location') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Footer About</label>
                                    <textarea name="footer_about" class="form-control form-control-sm" rows="3"><?= get_setting('footer_about') ?></textarea>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" name="update_settings" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Navbar List -->
                <div class="col-md-8 mb-4">
                    <div class="card card-success card-outline">
                        <div class="card-header"><h3 class="card-title">Struktur Navigasi</h3></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>URL</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($parents as $p): 
                                            $is_default = in_array($p['url'], $default_urls);
                                        ?>
                                        <tr class="table-light fw-bold">
                                            <td><?= $p['title'] ?></td>
                                            <td><code><?= $p['url'] ?></code></td>
                                            <td><span class="badge <?= $p['is_active'] ? 'text-bg-success' : 'text-bg-danger' ?>"><?= $p['is_active'] ? 'Aktif' : 'Nonaktif' ?></span></td>
                                            <td>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="menu_id" value="<?= $p['id'] ?>">
                                                    <button type="submit" name="edit_menu_trigger" class="btn btn-warning btn-xs"><i class="bi bi-pencil"></i></button>
                                                    <?php if (!$is_default): ?>
                                                        <button type="submit" name="delete_menu" class="btn btn-danger btn-xs" onclick="return confirm('Hapus menu dan semua sub-menunya?')"><i class="bi bi-trash"></i></button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php if (isset($children[$p['id']])): ?>
                                            <?php foreach ($children[$p['id']] as $c): ?>
                                            <tr>
                                                <td class="ps-4">↳ <?= $c['title'] ?></td>
                                                <td class="ps-4"><code><?= $c['url'] ?></code></td>
                                                <td><span class="badge <?= $c['is_active'] ? 'text-bg-success' : 'text-bg-danger' ?>"><?= $c['is_active'] ? 'Aktif' : 'Nonaktif' ?></span></td>
                                                <td>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="menu_id" value="<?= $c['id'] ?>">
                                                        <button type="submit" name="edit_menu_trigger" class="btn btn-warning btn-xs"><i class="bi bi-pencil"></i></button>
                                                        <button type="submit" name="delete_menu" class="btn btn-danger btn-xs" onclick="return confirm('Hapus sub-menu ini?')"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <h5><?= $edit_data ? 'Edit' : 'Tambah' ?> Item Menu</h5>
                            <form method="POST" id="menu-form">
                                <?php if ($edit_data): ?>
                                    <input type="hidden" name="menu_id" value="<?= $edit_data['id'] ?>">
                                <?php endif; ?>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small">Judul</label>
                                        <input type="text" name="menu_title" class="form-control form-control-sm" value="<?= $edit_data['title'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">URL</label>
                                        <input type="text" name="menu_url" class="form-control form-control-sm" value="<?= $edit_data['url'] ?? '' ?>" required <?= ($edit_data && in_array($edit_data['url'], $default_urls)) ? 'readonly' : '' ?>>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Menu Induk (Optional)</label>
                                        <select name="parent_id" class="form-select form-select-sm">
                                            <option value="0">-- Tanpa Induk (Main Menu) --</option>
                                            <?php foreach ($parents as $p): ?>
                                                <?php if ($edit_data && $edit_data['id'] == $p['id']) continue; ?>
                                                <option value="<?= $p['id'] ?>" <?= (isset($edit_data) && $edit_data['parent_id'] == $p['id']) ? 'selected' : '' ?>>
                                                    <?= $p['title'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Urutan</label>
                                        <input type="number" name="menu_sort" class="form-control form-control-sm" value="<?= $edit_data['sort_order'] ?? '0' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small d-block">Status</label>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="is_active" value="1" id="a1" <?= (!isset($edit_data) || $edit_data['is_active'] == 1) ? 'checked' : '' ?>>
                                            <label class="form-check-label small" for="a1">Aktif</label>
                                        </div>
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="is_active" value="0" id="a0" <?= (isset($edit_data) && $edit_data['is_active'] == 0) ? 'checked' : '' ?>>
                                            <label class="form-check-label small" for="a0">Off</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" name="add_menu" id="btn-save" class="btn btn-success btn-sm w-100" <?= $edit_data ? '' : 'disabled' ?>>Simpan</button>
                                        <?php if ($edit_data): ?>
                                            <a href="kelola_menu.php" class="btn btn-link btn-xs w-100 mt-1">Batal Edit</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('menu-form');
    const saveBtn = document.getElementById('btn-save');
    const initialData = new FormData(form);

    form.addEventListener('change', () => checkChanges());
    form.addEventListener('input', () => checkChanges());

    function checkChanges() {
        let changed = false;
        const currentData = new FormData(form);
        for (let pair of currentData.entries()) {
            if (pair[ pair[0] === 'menu_id' ? 1 : 1] !== initialData.get(pair[0])) {
                changed = true;
                break;
            }
        }
        saveBtn.disabled = !changed;
    }
});
</script>

<?php include 'foot.php'; ?>
