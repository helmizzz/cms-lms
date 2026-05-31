# Software Requirements Specification (SRS)

# LEXALINK ID - Portal Informasi Hukum dan CMS

## 1. Pendahuluan

Dokumen ini menjelaskan kebutuhan fungsional dan non-fungsional sistem berdasarkan implementasi project saat ini.

Sistem dibangun dengan PHP procedural, MySQL, Bootstrap, Font Awesome, Bootstrap Icons, dan AdminLTE.

## 2. Aktor Sistem

- Guest: pengunjung tanpa login.
- User: pengguna terdaftar dengan role `user`.
- Admin: pengguna terdaftar dengan role `admin`.

## 3. Modul Sistem

### 3.1 Public Website

Halaman:

- `index.php`
- `about.php`
- `services.php`
- `team.php`
- `blog.php`
- `blog_detail.php`
- `contact.php`

Kebutuhan:

- Guest dapat melihat beranda.
- Guest dapat melihat navigasi dinamis.
- Guest dapat melihat daftar blog published.
- Guest dapat membuka detail post berdasarkan slug.
- Guest dapat melihat produk hukum terbaru di beranda.
- Guest dapat melihat informasi kontak.

Status implementasi:

- Sebagian besar tersedia.
- Contact form, search, newsletter, dan beberapa CTA belum memiliki backend.

### 3.2 Authentication

File:

- `login.php`
- `logout.php`
- `includes/functions.php`

Kebutuhan:

- Sistem harus menerima username dan password.
- Sistem harus memverifikasi password dengan `password_verify`.
- Sistem harus menyimpan session user setelah login berhasil.
- Sistem harus mengarahkan admin ke `admview/index.php`.
- Sistem harus mengarahkan user ke `adminbaru/index.php`.
- Sistem harus menghapus session saat logout.

Status implementasi:

- Login/logout tersedia.
- Proteksi halaman dashboard belum konsisten karena sebagian halaman belum memanggil `check_access`.

### 3.3 Admin CMS

Folder:

- `admview/`

Kebutuhan:

- Admin dapat melihat statistik konten.
- Admin dapat mengelola identitas situs.
- Admin dapat mengelola menu dan submenu.
- Admin dapat mengelola landing content.
- Admin dapat mengelola berita.
- Admin dapat mengelola artikel.
- Admin dapat mengelola produk hukum.
- Admin dapat mengelola galeri.
- Admin dapat mengelola akun user.
- Admin dapat mengubah profil, password, avatar, hero image, dan logo admin.

Status implementasi:

- Create/delete tersedia untuk berita, artikel, produk hukum, dan galeri.
- Update/edit belum tersedia pada berita, artikel, produk hukum, dan galeri.
- Account management hanya add/delete.
- `kelola_akun.php` sudah memakai `check_access(['admin'])`, tetapi banyak halaman admin lain belum.

### 3.4 User Portal

Folder:

- `adminbaru/`

Kebutuhan:

- User dapat melihat dashboard ringkas.
- User dapat melihat berita published.
- User dapat melihat artikel published.
- User dapat mengunduh produk hukum.
- User dapat mengubah profil, avatar, dan password.

Status implementasi:

- Daftar konten dan download produk hukum tersedia.
- Link detail berita/artikel belum tersedia.
- Proteksi akses belum konsisten.

### 3.5 Produk Hukum

Tabel:

- `produk_hukum`

Kebutuhan:

- Admin dapat mengunggah dokumen hukum.
- Sistem harus menyimpan judul, deskripsi, kategori, file path, dan tanggal upload.
- User dapat mengunduh file produk hukum.
- Website publik dapat menampilkan produk hukum terbaru.

Status implementasi:

- Upload/download tersedia di admin dan user.
- Link download di beranda publik saat ini menggunakan nama file langsung, sedangkan file disimpan di `assets/docs/produk_hukum/`; path perlu diselaraskan.

### 3.6 AI Foundation

Tabel:

- `ai_prompt_templates`
- `ai_packages`
- `user_ai_quotas`
- `ai_requests`

Kebutuhan yang terlihat dari schema:

- Admin dapat mengelola prompt AI.
- Sistem dapat mengelola paket AI.
- Sistem dapat mengelola kuota user.
- Sistem dapat mencatat request dan response AI.

Status implementasi:

- Database tersedia.
- File service dan UI masih kosong, sehingga fitur belum fungsional.

## 4. Kebutuhan Fungsional

| ID | Requirement | Prioritas | Status |
| --- | --- | --- | --- |
| FR-001 | Guest melihat halaman publik | Must | Ada |
| FR-002 | Navbar publik dinamis dari database | Must | Ada |
| FR-003 | Guest membaca daftar blog published | Must | Ada |
| FR-004 | Guest membaca detail post by slug | Must | Ada |
| FR-005 | Admin login ke CMS | Must | Ada |
| FR-006 | User login ke portal user | Must | Ada |
| FR-007 | Admin membuat berita | Must | Ada |
| FR-008 | Admin mengedit berita | Must | Belum ada |
| FR-009 | Admin menghapus berita | Must | Ada |
| FR-010 | Admin membuat artikel | Must | Ada |
| FR-011 | Admin mengedit artikel | Must | Belum ada |
| FR-012 | Admin menghapus artikel | Must | Ada |
| FR-013 | Admin mengunggah produk hukum | Must | Ada |
| FR-014 | Admin mengedit produk hukum | Must | Belum ada |
| FR-015 | Admin menghapus produk hukum | Must | Ada |
| FR-016 | User mengunduh produk hukum | Must | Ada |
| FR-017 | Admin mengelola menu | Should | Ada sebagian |
| FR-018 | Admin mengelola landing content | Should | Ada |
| FR-019 | Admin mengelola hero image dan logo | Should | Ada |
| FR-020 | Admin mengelola akun | Must | Ada sebagian |
| FR-021 | User/admin mengubah profil | Must | Ada |
| FR-022 | Contact form mengirim/menyimpan pesan | Must | Belum ada |
| FR-023 | Newsletter menyimpan subscriber | Should | Belum ada |
| FR-024 | Search konten | Should | Belum ada |
| FR-025 | Pagination blog | Should | Placeholder |
| FR-026 | AI assistant | Could | Belum ada |

## 5. Kebutuhan Non-Fungsional

### 5.1 Keamanan

- Semua halaman `admview/` harus hanya dapat diakses oleh admin.
- Semua halaman `adminbaru/` harus hanya dapat diakses oleh user login.
- Semua form POST harus memakai CSRF token.
- Semua upload harus memvalidasi MIME type, ekstensi, ukuran file, dan hasil pemeriksaan file aktual.
- Semua output dari database harus di-escape dengan `htmlspecialchars` kecuali konten HTML yang memang dipercaya.
- Password harus tetap disimpan dengan hashing.
- Database credential production tidak boleh disimpan terbuka di repository.

Status:

- Password hashing sudah baik.
- Prepared statement sudah tersedia.
- Proteksi akses, CSRF, dan validasi upload masih perlu diperkuat.

### 5.2 Usability

- Admin harus bisa mengelola konten tanpa mengubah kode.
- Form harus memberikan feedback sukses/gagal.
- Halaman publik harus responsive.
- Tombol/link yang tampil harus menjalankan aksi nyata.

Status:

- Feedback dasar tersedia.
- Beberapa tombol/link masih placeholder.

### 5.3 Maintainability

- Koneksi database harus tersentral di `includes/init.php`.
- Helper database harus dipakai konsisten.
- Duplikasi antara `admview` dan `adminbaru` perlu dikurangi pada fase refactor.
- Vendor assets seperti AdminLTE dan Bootstrap sebaiknya tidak dimodifikasi langsung.

### 5.4 Performance

- Query list konten harus menggunakan limit/pagination saat data besar.
- Gambar upload sebaiknya dikompresi atau dibatasi ukurannya.
- Halaman blog harus memakai pagination nyata.

## 6. Data Requirements

Entitas utama:

- `users`: akun, role, profil, avatar, password.
- `posts`: blog, news, about.
- `produk_hukum`: dokumen hukum.
- `navbar_menus`: menu dan submenu.
- `site_settings`: konfigurasi website.
- `gallery`: foto galeri.
- `ai_prompt_templates`: template prompt AI.
- `ai_packages`: paket AI.
- `user_ai_quotas`: kuota AI user.
- `ai_requests`: log request AI.

## 7. Business Rules

- Role `admin` diarahkan ke CMS admin.
- Role selain `admin` diarahkan ke portal user.
- Post hanya tampil di publik jika `status = 'published'`.
- Produk hukum dapat diunduh jika `file_path` tersedia.
- Menu hanya tampil di publik jika `is_active = 1`.
- Menu default tidak boleh dihapus dari admin menu manager.
- User tidak boleh menghapus akun sendiri.

## 8. Acceptance Criteria Ringkas

- Admin login dan masuk ke CMS.
- User login dan masuk ke portal user.
- Admin dapat membuat berita/artikel published dan muncul di website.
- Admin dapat upload produk hukum dan user dapat download.
- Guest hanya melihat konten published.
- User tanpa login tidak bisa membuka dashboard.
- Admin-only page tidak bisa dibuka oleh user biasa.
- Contact form menghasilkan pesan tersimpan atau email terkirim.
- Placeholder/lorem ipsum diganti dengan konten client.

## 9. Gap Utama

- Proteksi akses belum menyeluruh.
- CRUD belum lengkap.
- Form publik belum fungsional.
- Search, filter, pagination belum fungsional.
- AI belum fungsional.
- Konten template masih banyak.
- Belum ada dokumentasi deployment dan testing.
