<?php 
require_once '../includes/init.php';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_article'])) {
        $title = clean($_POST['title']);
        $content = $_POST['content']; 
        $slug = generate_slug($title);
        $status = $_POST['status'];
        $image = upload_image($_FILES['image'], "../assets/img/posts/");

        db_query("INSERT INTO posts (title, slug, content, image, type, status, author_id) VALUES (?, ?, ?, ?, 'blog', ?, ?)", 
                 [$title, $slug, $content, $image, $status, $_SESSION['user_id'] ?? 1]);
        $success_msg = "Artikel berhasil ditambahkan!";
    }

    if (isset($_POST['delete_article'])) {
        $id = (int)$_POST['article_id'];
        $article = db_get_one("SELECT image FROM posts WHERE id = ?", [$id]);
        if ($article && $article['image']) {
            @unlink("../assets/img/posts/" . $article['image']);
        }
        db_query("DELETE FROM posts WHERE id = ?", [$id]);
        $success_msg = "Artikel berhasil dihapus!";
    }
}

// Fetch articles
$articles = db_get_all("SELECT * FROM posts WHERE type = 'blog' ORDER BY created_at DESC");

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kelola Artikel</h3>
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
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Artikel Baru</h3>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Judul Artikel</label>
                                    <input type="text" name="title" class="form-control" placeholder="Masukkan judul artikel" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Isi Artikel</label>
                                    <textarea name="content" class="form-control" rows="5" placeholder="Tulis konten artikel..." required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gambar Sampul</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="published">Terbitkan</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="add_article" class="btn btn-info">Tambah Artikel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Artikel</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
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
                                    <?php $i=1; foreach ($articles as $row): ?>
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
                                            <span class="badge <?= $row['status'] == 'published' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= ucfirst($row['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <form method="POST" onsubmit="return confirm('Hapus artikel ini?')" style="display:inline;">
                                                <input type="hidden" name="article_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="delete_article" class="btn btn-danger btn-sm">
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