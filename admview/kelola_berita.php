<?php 
require_once '../includes/init.php';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_news'])) {
        $title = clean($_POST['title']);
        $content = $_POST['content']; // Expect HTML from editor
        $slug = generate_slug($title);
        $status = $_POST['status'];
        $image = upload_image($_FILES['image'], "../assets/img/posts/");

        db_query("INSERT INTO posts (title, slug, content, image, type, status, author_id) VALUES (?, ?, ?, ?, 'news', ?, ?)", 
                 [$title, $slug, $content, $image, $status, $_SESSION['user_id'] ?? 1]);
        $success_msg = "Berita berhasil ditambahkan!";
    }

    if (isset($_POST['delete_news'])) {
        $id = (int)$_POST['news_id'];
        // Fetch image to delete from server
        $news = db_get_one("SELECT image FROM posts WHERE id = ?", [$id]);
        if ($news && $news['image']) {
            @unlink("../assets/img/posts/" . $news['image']);
        }
        db_query("DELETE FROM posts WHERE id = ?", [$id]);
        $success_msg = "Berita berhasil dihapus!";
    }
}

// Fetch news
$news_list = db_get_all("SELECT * FROM posts WHERE type = 'news' ORDER BY created_at DESC");

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kelola Berita</h3>
                </div>
            </div>
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
                <div class="col-12 mb-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Berita Baru</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Judul Berita</label>
                                    <input type="text" name="title" class="form-control" placeholder="Masukkan judul berita" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konten</label>
                                    <textarea name="content" class="form-control" rows="5" placeholder="Tulis isi berita di sini..." required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gambar Utama</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="published">Terbitkan</option>
                                            <option value="draft">Simpan sebagai Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="add_news" class="btn btn-primary">Simpan Berita</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Berita</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th style="width: 100px">Gambar</th>
                                        <th>Judul</th>
                                        <th style="width: 100px">Status</th>
                                        <th style="width: 150px">Tanggal</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($news_list as $row): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td>
                                            <?php if ($row['image']): ?>
                                                <img src="../assets/img/posts/<?= $row['image'] ?>" width="80" class="img-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $row['title'] ?></td>
                                        <td>
                                            <span class="badge <?= $row['status'] == 'published' ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                                <?= ucfirst($row['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <form method="POST" onsubmit="return confirm('Hapus berita ini?')" style="display:inline;">
                                                <input type="hidden" name="news_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="delete_news" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>