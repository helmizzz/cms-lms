<?php 
require_once '../includes/init.php';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_landing'])) {
        foreach (['hero_title', 'hero_subtitle', 'about_summary'] as $key) {
            $val = clean($_POST[$key]);
            db_query("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?", [$key, $val, $val]);
        }
        $success_msg = "Isi landing page berhasil diperbarui!";
    }

    if (isset($_POST['update_about'])) {
        $content = $_POST['about_full'];
        $about = db_get_one("SELECT id FROM posts WHERE type = 'about' LIMIT 1");
        if ($about) {
            db_query("UPDATE posts SET content = ?, updated_at = NOW() WHERE id = ?", [$content, $about['id']]);
        } else {
            db_query("INSERT INTO posts (title, slug, content, type, status, author_id) VALUES (?, ?, ?, 'about', 'published', 1)", 
                     ['Tentang Kami', 'tentang-kami', $content]);
        }
        $success_msg = "Konten 'About Us' berhasil diperbarui!";
    }
}

// Fetch About Us content
$about_post = db_get_one("SELECT content FROM posts WHERE type = 'about' LIMIT 1");
$about_content = $about_post ? $about_post['content'] : '';

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Kelola Isi Landing & About Us</h3>
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

            <div class="row">
                <!-- Landing Content -->
                <div class="col-md-5 mb-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Bagian Hero (Landing Page)</h3>
                        </div>
                        <form method="POST">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Judul Utama (Hero Title)</label>
                                    <input type="text" name="hero_title" class="form-control" value="<?= get_setting('hero_title', 'Selamat Datang') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sub-judul (Hero Subtitle)</label>
                                    <textarea name="hero_subtitle" class="form-control" rows="3"><?= get_setting('hero_subtitle', 'Solusi digital untuk kebutuhan Anda.') ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ringkasan Singkat (Footer/Section)</label>
                                    <textarea name="about_summary" class="form-control" rows="2"><?= get_setting('about_summary') ?></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="update_landing" class="btn btn-primary">Simpan Isi Landing</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- About Us Detailed Content -->
                <div class="col-md-7 mb-4">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Tentang Perusahaan (About Us Full)</h3>
                        </div>
                        <form method="POST">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Konten Lengkap Halaman About Us</label>
                                    <textarea name="about_full" class="form-control" rows="12" placeholder="Tulis sejarah, visi, misi, dll..."><?= $about_content ?></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="update_about" class="btn btn-info">Update Tentang Kami</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>
