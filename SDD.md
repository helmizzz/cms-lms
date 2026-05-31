# Software Design Document (SDD)

# LEXALINK ID - Portal Informasi Hukum dan CMS

## 1. Gambaran Arsitektur

Project menggunakan arsitektur PHP procedural dengan file entry point per halaman. Tidak ada framework backend. Database memakai MySQL melalui `mysqli`.

Struktur utama:

- Root public pages: `index.php`, `about.php`, `services.php`, `team.php`, `blog.php`, `blog_detail.php`, `contact.php`.
- Shared includes: `includes/init.php`, `includes/functions.php`.
- Public components: `public/`.
- Admin CMS: `admview/`.
- User portal: `adminbaru/`.
- Assets: `css/`, `js/`, `img/`, `assets/`.
- Database schema: `new.sql`.

## 2. Komponen Utama

### 2.1 Initialization

File: `includes/init.php`

Tanggung jawab:

- Memulai session.
- Mendefinisikan konfigurasi database.
- Memuat helper function.
- Membuka koneksi database.
- Memuat `site_settings` ke variable global `$settings`.

Catatan desain:

- Semua halaman utama memanggil `require_once 'includes/init.php'` atau `../includes/init.php`.
- Konfigurasi database masih hardcoded.

### 2.2 Database Helper

File: `includes/functions.php`

Fungsi utama:

- `db_connect()`
- `db_query($sql, $params = [])`
- `db_get_all($sql, $params = [])`
- `db_get_one($sql, $params = [])`
- `db_execute($sql, $params = [])`
- `clean($data)`
- `upload_image($file, $target_dir)`
- `generate_slug($string)`
- `is_authenticated()`
- `check_access($allowed_roles = [])`
- `redirect_by_role($role)`
- `app_url($path = '')`
- `get_user_avatar_src($avatar = '')`

Catatan desain:

- Query sudah menggunakan prepared statement.
- `clean()` mencampur sanitasi HTML dan escape SQL, sementara prepared statement sudah menangani parameter SQL. Untuk desain jangka panjang, sebaiknya pisahkan input validation, SQL binding, dan output escaping.

## 3. Desain Frontend Publik

### 3.1 Beranda

File: `index.php`

Komponen:

- `public/nav/top_nav.php`
- `public/nav/main_nav.php`
- `public/nav/center_nav.php`
- `public/nav/manage_service.php`
- `public/index/news_grid.php`
- `public/about/skill.php`
- `public/index/faq.php`
- `public/footer/footer.php`
- `public/footer/footerb.php`

Data dinamis:

- Hero image: `site_settings.hero_image`.
- Hero title/subtitle: `site_settings`.
- Navbar: `navbar_menus`.
- Blog terbaru: `posts` type `blog`, status `published`.
- Produk hukum terbaru: `produk_hukum`.

### 3.2 Blog

File:

- `blog.php`
- `blog_detail.php`
- `public/blog/blog_pg.php`
- `public/blog/blog_detail.php`

Alur:

1. `blog.php` memuat layout.
2. `public/blog/blog_pg.php` mengambil semua post `type = blog` dan `status = published`.
3. User klik detail ke `blog_detail.php?slug=...`.
4. Detail mengambil post published berdasarkan slug.

### 3.3 Contact

File:

- `contact.php`
- `public/contactus/office_addr.php`
- `public/contactus/subs.php`

Desain saat ini:

- Menampilkan alamat dan form.
- Form belum memiliki `method`, `action`, validasi, atau penyimpanan pesan.

## 4. Desain Admin CMS

Folder: `admview/`

Layout:

- `head.php`
- `foot.php`
- `navside/navbar.php`
- `navside/sidebar.php`

Framework UI:

- AdminLTE.
- Bootstrap.
- Bootstrap Icons.

### 4.1 Dashboard Admin

File: `admview/index.php`

Data:

- Count news.
- Count articles.
- Count produk hukum.
- Count gallery.

### 4.2 Kelola Berita dan Artikel

File:

- `admview/kelola_berita.php`
- `admview/kelola_artikel.php`

Desain:

- Form create.
- Upload image ke `assets/img/posts/`.
- Simpan ke tabel `posts`.
- Delete post dan file gambar.

Kekurangan desain:

- Belum ada edit.
- Belum ada slug collision handling.
- Belum ada validasi tipe dan ukuran gambar di helper `upload_image`.
- Belum ada CSRF.

### 4.3 Kelola Produk Hukum

File: `admview/kelola_produkhukum.php`

Desain:

- Upload dokumen ke `assets/docs/produk_hukum/`.
- Simpan metadata ke `produk_hukum`.
- Delete dokumen dan record.

Kekurangan desain:

- Validasi file hanya berdasarkan `accept` di HTML.
- Belum ada batas ukuran file.
- Belum ada edit metadata/file.

### 4.4 Kelola Menu

File: `admview/kelola_menu.php`

Desain:

- Mengelola `site_settings` untuk identitas website.
- Mengelola `navbar_menus` untuk menu dan submenu.
- Parent-child menu menggunakan `parent_id`.
- Menu default tidak boleh dihapus.

Catatan:

- Tombol tambah menu baru tampak disabled saat tidak ada perubahan karena logic JS membandingkan form awal. Ini perlu diuji ulang karena bisa menghambat tambah menu baru.

### 4.5 Kelola Landing dan Appearance

File:

- `admview/kelola_landing.php`
- `admview/appearance.php`

Desain:

- `site_settings` menyimpan hero title, subtitle, summary, hero image, dan logo admin.
- Konten about disimpan sebagai post `type = about`.
- Upload hero/logo ke `assets/img/appearance/`.

### 4.6 Kelola Akun

File: `admview/kelola_akun.php`

Desain:

- Admin dapat menambah akun.
- Admin dapat menghapus akun selain dirinya sendiri.
- Password memakai `password_hash`.
- Role tersedia: `admin`, `user`.

Kekurangan:

- Belum ada edit user.
- Belum ada reset password oleh admin.

## 5. Desain Portal User

Folder: `adminbaru/`

Layout mirip admin CMS, tetapi sidebar lebih terbatas.

Halaman:

- `index.php`: ringkasan statistik.
- `berita.php`: daftar berita published.
- `artikel.php`: daftar artikel published.
- `produk_hukum.php`: daftar produk hukum dan download.
- `profile.php`: update profil, avatar, password.

Kekurangan:

- Belum ada detail berita/artikel.
- Beberapa link masih placeholder.
- Proteksi akses belum konsisten.

## 6. Database Design

### 6.1 users

Menyimpan akun login.

Kolom penting:

- `id`
- `username`
- `password`
- `email`
- `full_name`
- `phone`
- `role`
- `avatar`
- `last_login`

Relasi:

- `posts.author_id` ke `users.id`.
- `ai_prompt_templates.created_by` ke `users.id`.
- `user_ai_quotas.user_id` ke `users.id`.
- `ai_requests.user_id` ke `users.id`.

### 6.2 posts

Menyimpan blog, news, dan about.

Kolom penting:

- `title`
- `slug`
- `content`
- `image`
- `type`: `blog`, `news`, `about`
- `status`: `draft`, `published`
- `author_id`

### 6.3 produk_hukum

Menyimpan dokumen hukum.

Kolom penting:

- `title`
- `description`
- `file_path`
- `category`
- `created_at`

### 6.4 navbar_menus

Menyimpan navigasi publik.

Kolom penting:

- `title`
- `url`
- `parent_id`
- `sort_order`
- `is_active`

### 6.5 site_settings

Key-value settings.

Contoh key:

- `site_name`
- `location`
- `footer_about`
- `hero_title`
- `hero_subtitle`
- `about_summary`
- `hero_image`
- `admin_logo`

### 6.6 AI Tables

Tabel:

- `ai_prompt_templates`
- `ai_packages`
- `user_ai_quotas`
- `ai_requests`

Desain schema sudah cukup untuk fase awal AI, tetapi belum ada service layer dan UI.

## 7. Alur Data Penting

### 7.1 Login

1. User submit username/password.
2. `login.php` mencari user berdasarkan username.
3. Password diverifikasi dengan `password_verify`.
4. Session diisi: `user_id`, `username`, `full_name`, `role`.
5. `last_login` diupdate.
6. Redirect sesuai role.

### 7.2 Publish Artikel/Berita

1. Admin membuka form create.
2. Admin mengisi title, content, status, dan gambar.
3. Sistem membuat slug dari title.
4. Gambar diupload ke `assets/img/posts/`.
5. Record masuk ke `posts`.
6. Halaman publik membaca post dengan status `published`.

### 7.3 Upload Produk Hukum

1. Admin memilih dokumen.
2. File dipindah ke `assets/docs/produk_hukum/`.
3. Metadata disimpan ke `produk_hukum`.
4. User dashboard menampilkan dokumen.
5. User klik download.

## 8. Security Design

Desain yang sudah ada:

- Prepared statement untuk query parameter.
- Password hashing.
- Basic role routing.
- Beberapa validasi upload di profile/appearance.

Desain yang perlu ditambahkan:

- Panggil `check_access(['admin'])` pada semua halaman `admview`.
- Panggil `check_access(['user'])` atau minimal `check_access()` pada semua halaman `adminbaru`.
- Tambahkan CSRF token helper.
- Validasi upload terpusat untuk gambar dan dokumen.
- Escape semua output database.
- Tambahkan session regeneration setelah login.
- Tambahkan logout timeout opsional.
- Pindahkan credential production ke environment/config terpisah.

## 9. Deployment Design

Kebutuhan minimum:

- PHP dengan ekstensi `mysqli`.
- MySQL/MariaDB.
- Web server Apache/Nginx.
- Permission write untuk:
  - `assets/img/posts/`
  - `assets/img/gallery/`
  - `assets/img/avatars/`
  - `assets/img/appearance/`
  - `assets/docs/produk_hukum/`

Langkah setup:

1. Import `new.sql`.
2. Sesuaikan `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` di `includes/init.php`.
3. Pastikan folder upload writable.
4. Akses `login.php`.

## 10. Recommended Technical Improvements

- Buat helper `require_admin()` dan `require_login()` lalu panggil konsisten.
- Buat helper `csrf_field()` dan `verify_csrf()`.
- Buat helper upload terpisah:
  - `upload_validated_image()`
  - `upload_validated_document()`
- Tambahkan update CRUD untuk konten.
- Tambahkan pagination query.
- Tambahkan search backend.
- Buat halaman produk hukum publik.
- Buat tabel `contact_messages` dan `newsletter_subscribers`.
- Pisahkan config database ke file yang tidak ikut repository production.
- Rapikan encoding karakter yang rusak seperti `Â©` dan `â†³`.

## 11. Kesimpulan Desain

Desain saat ini cocok untuk prototype CMS portal hukum. Struktur sudah mudah dipahami dan fitur utama sudah mulai berjalan. Agar siap dipakai client secara production, desain perlu diperkuat pada keamanan akses, CRUD lengkap, validasi upload, form publik, dan pengurangan konten/template placeholder.
