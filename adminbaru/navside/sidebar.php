<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="index.php" class="brand-link">
            <img src="../admin/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light"><?= get_setting('site_name', 'Admin Baru') ?></span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="berita.php" class="nav-link">
                        <i class="nav-icon bi bi-newspaper"></i>
                        <p>Berita Terbaru</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="produk_hukum.php" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-lock"></i>
                        <p>Produk Hukum</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="artikel.php" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>Artikel</p>
                    </a>
                </li>
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="profile.php" class="nav-link">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>Profil Anda</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-question-circle"></i>
                        <p>Pusat Bantuan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
