<?php 
require_once '../includes/init.php';

// Mocking User ID since we don't have a real login yet
$user_id = $_SESSION['user_id'] ?? 1;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $full_name = clean($_POST['full_name']);
        $phone = clean($_POST['phone']);
        
        db_query("UPDATE users SET full_name = ?, phone = ? WHERE id = ?", [$full_name, $phone, $user_id]);
        $success_msg = "Profil berhasil diperbarui!";
    }
    
    if (isset($_POST['change_password'])) {
        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];
        
        // Fetch current user
        $user = db_get_one("SELECT password FROM users WHERE id = ?", [$user_id]);
        
        if (password_verify($old_pass, $user['password'])) {
            if ($new_pass === $confirm_pass) {
                $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                db_query("UPDATE users SET password = ? WHERE id = ?", [$hashed_pass, $user_id]);
                $success_msg = "Password berhasil diubah!";
            } else {
                $error_msg = "Konfirmasi password baru tidak cocok.";
            }
        } else {
            $error_msg = "Password lama salah.";
        }
    }
}

// Fetch current user data
$user_data = db_get_one("SELECT * FROM users WHERE id = ?", [$user_id]);

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
</style>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">   
            <h2 class="profile-header">Profil</h2>
            
            <ul class="nav profile-tabs" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detail-akun-tab" data-bs-toggle="tab" data-bs-target="#detail-akun" type="button" role="tab" aria-controls="detail-akun" aria-selected="true">Detail Akun</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password" type="button" role="tab" aria-controls="change-password" aria-selected="false">Change Password</button>
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
                <!-- Column Left -->
                <div class="col-md-4 mb-4">
                    <div class="profile-card h-100">
                        <div class="avatar-placeholder">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h3 class="profile-name"><?= $user_data['full_name'] ?></h3>
                        <p class="profile-email"><?= $user_data['email'] ?></p>
                        
                        <!-- <div class="mt-4">
                            <div class="membership-badge">
                                <i class="bi bi-caret-up-fill"></i> Freemium
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- Column Right -->
                <div class="col-md-8 mb-4">
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Tab Detail Akun -->
                        <div class="tab-pane fade show active" id="detail-akun" role="tabpanel" aria-labelledby="detail-akun-tab">
                            <div class="info-card h-100">
                                <h4 class="section-title">Informasi Personal</h4>
                                <form method="POST">
                                    <div class="mb-4">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="full_name" class="form-control" value="<?= $user_data['full_name'] ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Nomor handphone</label>
                                            <input type="text" name="phone" class="form-control" value="<?= $user_data['phone'] ?>" placeholder="Tulis nomor handphone di sini">
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="<?= $user_data['email'] ?>" readonly style="background-color: #f8f9fa;">
                                        </div>
                                    </div>
                                    <button type="submit" name="update_profile" class="btn-simpan">Simpan Profil</button>
                                </form>
                            </div>
                        </div>

                        <!-- Tab Ubah Password -->
                        <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                            <div class="info-card h-100">
                                <h4 class="section-title">Ubah Password</h4>
                                <form method="POST">
                                    <div class="mb-4">
                                        <label class="form-label">Password Lama</label>
                                        <div class="password-wrapper">
                                            <input type="password" name="old_password" class="form-control" placeholder="Masukkan password lama Anda" required>
                                            <i class="bi bi-eye-slash-fill password-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Password Baru</label>
                                            <div class="password-wrapper">
                                                <input type="password" name="new_password" class="form-control" placeholder="Masukkan password baru Anda" required>
                                                <i class="bi bi-eye-slash-fill password-toggle"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Konfirmasi Password Baru</label>
                                            <div class="password-wrapper">
                                                <input type="password" name="confirm_password" class="form-control" placeholder="Masukkan password baru Anda" required>
                                                <i class="bi bi-eye-slash-fill password-toggle"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="change_password" class="btn-simpan">Simpan Password</button>
                                </form>
                            </div>
                        </div>
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