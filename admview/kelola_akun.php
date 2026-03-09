<?php 
require_once '../includes/init.php';

// Check access - only admin can manage accounts
check_access(['admin']);

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add User
    if (isset($_POST['add_user'])) {
        $full_name = clean($_POST['full_name']);
        $email = clean($_POST['email']);
        $username = clean($_POST['username']);
        $phone = clean($_POST['phone']);
        $role = clean($_POST['role']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Handle Avatar Upload
        $avatar = 'default_avatar.png';
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploaded_file = upload_image($_FILES['avatar'], "../assets/img/avatars/");
            if ($uploaded_file) {
                $avatar = $uploaded_file;
            }
        }

        // Check if username or email exists
        $check = db_get_one("SELECT id FROM users WHERE username = ? OR email = ?", [$username, $email]);
        if ($check) {
            $error_msg = "Username atau Email sudah terdaftar!";
        } else {
            db_query("INSERT INTO users (full_name, email, username, phone, role, password, avatar) VALUES (?, ?, ?, ?, ?, ?, ?)", 
                     [$full_name, $email, $username, $phone, $role, $password, $avatar]);
            $success_msg = "Akun berhasil ditambahkan!";
        }
    }

    // Delete User
    if (isset($_POST['delete_user'])) {
        $id = (int)$_POST['user_id'];
        
        // Prevent self-deletion
        if ($id === $_SESSION['user_id']) {
            $error_msg = "Anda tidak dapat menghapus akun sendiri!";
        } else {
            // Delete avatar file if not default
            $user = db_get_one("SELECT avatar FROM users WHERE id = ?", [$id]);
            if ($user && $user['avatar'] && $user['avatar'] !== 'default_avatar.png') {
                @unlink("../assets/img/avatars/" . $user['avatar']);
            }
            db_query("DELETE FROM users WHERE id = ?", [$id]);
            $success_msg = "Akun berhasil dihapus!";
        }
    }
}

// Fetch all users
$users = db_get_all("SELECT * FROM users ORDER BY created_at DESC");

include 'head.php'; 
include 'navside/navbar.php'; 
include 'navside/sidebar.php'; 
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Kelola Akun Pengguna</h3>
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
                <!-- User List -->
                <div class="col-md-12 mb-4">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pengguna</h3>
                            <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="bi bi-plus"></i> Tambah Akun
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Avatar</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $row): ?>
                                        <tr>
                                            <td>
                                                <img src="../assets/img/avatars/<?= $row['avatar'] ?>" class="rounded-circle" width="40" height="40" alt="Avatar">
                                            </td>
                                            <td>
                                                <strong><?= $row['username'] ?></strong><br>
                                                <small class="text-muted"><?= $row['full_name'] ?></small>
                                            </td>
                                            <td><?= $row['email'] ?></td>
                                            <td>
                                                <span class="badge <?= $row['role'] == 'admin' ? 'text-bg-danger' : 'text-bg-primary' ?>">
                                                    <?= ucfirst($row['role']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" onsubmit="return confirm('Hapus akun ini? Setiap data terkait mungkin akan terpengaruh.')" style="display:inline;">
                                                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                                    <button type="submit" name="delete_user" class="btn btn-danger btn-sm" <?= $row['id'] == $_SESSION['user_id'] ? 'disabled' : '' ?>>
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
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content card card-primary card-outline">
                <div class="modal-header card-header">
                    <h5 class="modal-title card-title" id="addUserModalLabel">Tambah Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="phone" class="form-control" placeholder="Nomor HP">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="user">User (LMS)</option>
                                <option value="admin">Admin (CMS)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Avatar / Foto Profil</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="add_user" class="btn btn-primary">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'foot.php'; ?>