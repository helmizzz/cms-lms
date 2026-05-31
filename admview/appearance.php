<?php 
require_once '../includes/init.php';

$hero_image = get_setting('hero_image', 'img/1.jpg');
if (!$hero_image) {
    $hero_image = 'img/1.jpg';
}
$hero_preview = "../" . $hero_image;
$admin_logo = get_setting('admin_logo', '');
$admin_logo_preview = $admin_logo ? "../" . $admin_logo : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_hero_image'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $file_type = $_FILES['hero_image']['type'] ?? '';
        $extension = strtolower(pathinfo($_FILES['hero_image']['name'] ?? '', PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $image_info = isset($_FILES['hero_image']['tmp_name']) ? @getimagesize($_FILES['hero_image']['tmp_name']) : false;

        if (!isset($_FILES['hero_image']) || $_FILES['hero_image']['error'] !== UPLOAD_ERR_OK) {
            $error_msg = "Pilih foto hero terlebih dahulu.";
        } elseif (!$image_info || !in_array($file_type, $allowed_types, true) || !in_array($extension, $allowed_extensions, true)) {
            $error_msg = "Format foto harus JPG, PNG, WEBP, atau GIF.";
        } else {
            $uploaded = upload_image($_FILES['hero_image'], "../assets/img/appearance/");

            if ($uploaded) {
                $new_path = "assets/img/appearance/" . $uploaded;

                if ($hero_image && strpos($hero_image, 'assets/img/appearance/') === 0) {
                    @unlink("../" . $hero_image);
                }

                db_query(
                    "INSERT INTO site_settings (setting_key, setting_value) VALUES ('hero_image', ?) ON DUPLICATE KEY UPDATE setting_value = ?",
                    [$new_path, $new_path]
                );

                $hero_image = $new_path;
                $hero_preview = "../" . $hero_image;
                $success_msg = "Foto hero berhasil diperbarui.";
            } else {
                $error_msg = "Gagal mengunggah foto hero.";
            }
        }
    }

    if (isset($_POST['update_admin_logo'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $file_type = $_FILES['admin_logo']['type'] ?? '';
        $extension = strtolower(pathinfo($_FILES['admin_logo']['name'] ?? '', PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $image_info = isset($_FILES['admin_logo']['tmp_name']) ? @getimagesize($_FILES['admin_logo']['tmp_name']) : false;

        if (!isset($_FILES['admin_logo']) || $_FILES['admin_logo']['error'] !== UPLOAD_ERR_OK) {
            $error_msg = "Pilih logo admin terlebih dahulu.";
        } elseif (!$image_info || !in_array($file_type, $allowed_types, true) || !in_array($extension, $allowed_extensions, true)) {
            $error_msg = "Format logo harus JPG, PNG, WEBP, atau GIF.";
        } else {
            $uploaded = upload_image($_FILES['admin_logo'], "../assets/img/appearance/");

            if ($uploaded) {
                $new_path = "assets/img/appearance/" . $uploaded;

                if ($admin_logo && strpos($admin_logo, 'assets/img/appearance/') === 0) {
                    @unlink("../" . $admin_logo);
                }

                db_query(
                    "INSERT INTO site_settings (setting_key, setting_value) VALUES ('admin_logo', ?) ON DUPLICATE KEY UPDATE setting_value = ?",
                    [$new_path, $new_path]
                );

                $admin_logo = $new_path;
                $admin_logo_preview = "../" . $admin_logo;
                $success_msg = "Logo admin berhasil diperbarui.";
            } else {
                $error_msg = "Gagal mengunggah logo admin.";
            }
        }
    }

    if (isset($_POST['delete_hero_image'])) {
        if ($hero_image && strpos($hero_image, 'assets/img/appearance/') === 0) {
            @unlink("../" . $hero_image);
        }

        db_query(
            "INSERT INTO site_settings (setting_key, setting_value) VALUES ('hero_image', 'img/1.jpg') ON DUPLICATE KEY UPDATE setting_value = 'img/1.jpg'"
        );

        $hero_image = 'img/1.jpg';
        $hero_preview = "../" . $hero_image;
        $success_msg = "Foto hero dikembalikan ke gambar default.";
    }

    if (isset($_POST['delete_admin_logo'])) {
        if ($admin_logo && strpos($admin_logo, 'assets/img/appearance/') === 0) {
            @unlink("../" . $admin_logo);
        }

        db_query(
            "INSERT INTO site_settings (setting_key, setting_value) VALUES ('admin_logo', '') ON DUPLICATE KEY UPDATE setting_value = ''"
        );

        $admin_logo = '';
        $admin_logo_preview = '';
        $success_msg = "Logo admin berhasil dihapus.";
    }
}

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<style>
    .profile-header {
        color: #2C3844;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .profile-tabs {
        border-bottom: none;
        margin-bottom: 25px;
    }
    .profile-tabs .nav-link {
        color: #767676;
        border: none;
        font-weight: 500;
        padding: 5px 0;
        margin-right: 25px;
        background: transparent;
        cursor: pointer;
    }
    .profile-tabs .nav-link.active {
        color: #2C3844;
        background: transparent;
        border-bottom: 3px solid #FDCB6E;
    }
    .profile-card {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        border: 1px solid #f1f1f1;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .avatar-placeholder {
        width: 120px;
        height: 120px;
        background: #DDE2E5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #9BA4AD;
        font-size: 60px;
    }
    .profile-name {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 5px;
    }
    .profile-email {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 20px;
    }
    .membership-badge {
        background: #4A5D70;
        color: white;
        padding: 8px 20px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        font-size: 14px;
        width: 100%;
        justify-content: center;
    }
    .membership-badge i {
        margin-right: 8px;
        font-size: 12px;
    }
    .section-title {
        font-size: 22px;
        font-weight: 600;
        color: #2C3844;
        margin-bottom: 25px;
    }
    .info-card {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        border: 1px solid #f1f1f1;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .form-label {
        color: #212529;
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #DDE2E5;
        padding: 12px 15px;
        font-size: 14px;
        color: #767676;
    }
    .form-control:focus {
        border-color: #FDCB6E;
        box-shadow: none;
    }
    .password-wrapper {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #767676;
    }
    .btn-simpan {
        background-color: #AAB2BD;
        color: #2C3844;
        border: none;
        padding: 10px 35px;
        border-radius: 10px;
        font-weight: 600;
        float: right;
        margin-top: 20px;
    }
    .btn-simpan:hover {
        background-color: #939BA5;
    }
    .appearance-preview {
        width: 100%;
        min-height: 260px;
        border-radius: 12px;
        background-size: cover;
        background-position: center;
        overflow: hidden;
        border: 1px solid #DDE2E5;
    }
    .appearance-preview-overlay {
        min-height: 260px;
        padding: 36px;
        display: flex;
        align-items: center;
        background: linear-gradient(rgba(0,45,84,0.82), rgba(0,45,84,0.82));
        color: #fff;
    }
    .appearance-preview small {
        color: #FFB000;
        font-weight: 700;
        letter-spacing: .8px;
    }
    .appearance-preview h3 {
        margin: 12px 0 8px;
        font-weight: 700;
    }
    .logo-preview-box {
        width: 96px;
        height: 96px;
        border-radius: 12px;
        background: #2C3844;
        border: 1px solid #DDE2E5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .logo-preview-box img {
        max-width: 74px;
        max-height: 74px;
        object-fit: contain;
    }
    .logo-preview-placeholder {
        color: #fff;
        font-size: 36px;
        line-height: 1;
    }
</style>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">   
            <h2 class="profile-header">Kustomisasi</h2>
            
            <ul class="nav profile-tabs" id="profileTabs">
                <li class="nav-item">
                    <span class="nav-link active">Gambar Hero</span>
                </li>
            </ul>
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
                <div class="col-lg-7 mb-4">
                    <div class="info-card h-100">
                        <h3 class="section-title">Preview Hero Website</h3>
                        <div class="appearance-preview" style="background-image: url('<?= htmlspecialchars($hero_preview, ENT_QUOTES, 'UTF-8') ?>');">
                            <div class="appearance-preview-overlay">
                                <div>
                                    <small>SOLUSI HUKUM TERPERCAYA</small>
                                    <h3><?= htmlspecialchars(get_setting('hero_title', 'Selamat Datang'), ENT_QUOTES, 'UTF-8') ?></h3>
                                    <p class="mb-0"><?= htmlspecialchars(get_setting('hero_subtitle', 'Solusi digital untuk kebutuhan Anda.'), ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted small mt-3 mb-0">
                            Gambar ini mengganti background besar pada halaman depan.
                        </p>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="info-card h-100">
                        <h3 class="section-title">Foto Hero</h3>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Upload Foto Baru</label>
                                <input type="file" name="hero_image" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif" required>
                                <small class="text-muted d-block mt-2">Rekomendasi ukuran: 1600 x 900 px atau lebih besar.</small>
                            </div>
                            <button type="submit" name="update_hero_image" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i> Simpan Foto
                            </button>
                        </form>

                        <hr>

                        <form method="POST" onsubmit="return confirm('Kembalikan foto hero ke gambar default?')">
                            <button type="submit" name="delete_hero_image" class="btn btn-outline-danger" <?= strpos($hero_image, 'assets/img/appearance/') === 0 ? '' : 'disabled' ?>>
                                <i class="bi bi-trash me-1"></i> Hapus Foto Custom
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="info-card">
                        <h3 class="section-title">Preview Logo Sidebar</h3>
                        <div class="d-flex align-items-center gap-3">
                            <div class="logo-preview-box">
                                <?php if ($admin_logo_preview): ?>
                                    <img src="<?= htmlspecialchars($admin_logo_preview, ENT_QUOTES, 'UTF-8') ?>" alt="Logo Admin">
                                <?php else: ?>
                                    <i class="bi bi-image logo-preview-placeholder"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h5 class="mb-1"><?= htmlspecialchars(get_setting('site_name', 'Admin Baru'), ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="text-muted small mb-0">Logo ini tampil di sidebar admin.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="info-card">
                        <h3 class="section-title">Logo Admin</h3>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Upload Logo Baru</label>
                                <input type="file" name="admin_logo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif" required>
                                <small class="text-muted d-block mt-2">Rekomendasi: PNG transparan atau gambar rasio 1:1.</small>
                            </div>
                            <button type="submit" name="update_admin_logo" class="btn btn-primary">
                                <i class="bi bi-upload me-1"></i> Simpan Logo
                            </button>
                        </form>

                        <hr>

                        <form method="POST" onsubmit="return confirm('Hapus logo admin custom?')">
                            <button type="submit" name="delete_admin_logo" class="btn btn-outline-danger" <?= $admin_logo ? '' : 'disabled' ?>>
                                <i class="bi bi-trash me-1"></i> Hapus Logo Custom
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.password-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('bi-eye-slash-fill');
                    this.classList.add('bi-eye-fill');
                } else {
                    input.type = 'password';
                    this.classList.remove('bi-eye-fill');
                    this.classList.add('bi-eye-slash-fill');
                }
            });
        });
    });
</script>

<?php include 'foot.php'; ?>
