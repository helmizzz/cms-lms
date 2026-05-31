# Product Requirements Document (PRD)

# LEXALINK ID - Portal Informasi Hukum dan CMS

## 1. Ringkasan Produk

LEXALINK ID adalah website portal informasi hukum berbasis PHP dan MySQL yang menyediakan halaman publik, publikasi artikel/berita, daftar produk hukum berbentuk dokumen, serta dashboard admin untuk mengelola konten website.

Produk saat ini terdiri dari:

- Website publik: beranda, blog, detail blog, layanan, tim, tentang kami, dan kontak.
- CMS admin: pengelolaan menu, landing page, berita, artikel, produk hukum, galeri, akun, profil, dan tampilan.
- Portal user: dashboard user untuk melihat berita, artikel, produk hukum, dan mengubah profil.
- Fondasi database untuk fitur AI: prompt template, paket AI, kuota user, dan riwayat request AI.

## 2. Tujuan Produk

Tujuan utama produk adalah membantu client memiliki website hukum yang dapat dikelola secara mandiri tanpa perlu mengubah kode setiap kali konten berubah.

Tujuan bisnis:

- Menampilkan identitas organisasi atau brand hukum secara profesional.
- Mempublikasikan berita, artikel, dan dokumen hukum.
- Memberikan akses informasi hukum kepada user terdaftar.
- Memberikan admin panel untuk mengelola konten dan akun.
- Menyiapkan fondasi pengembangan fitur AI legal assistant pada fase berikutnya.

## 3. Target Pengguna

- Pengunjung publik: membaca informasi website, artikel/blog, berita, dan produk hukum terbaru.
- User terdaftar: masuk ke dashboard untuk melihat berita, artikel, dan mengunduh produk hukum.
- Admin CMS: mengelola konten website, menu, produk hukum, akun, landing page, galeri, dan appearance.
- Pemilik/client: memantau kesiapan website sebagai portal informasi hukum.

## 4. Masalah yang Diselesaikan

- Client membutuhkan media publikasi informasi hukum yang mudah diperbarui.
- Konten legal seperti artikel, berita, dan produk hukum perlu dikelola dari satu dashboard.
- User membutuhkan akses cepat ke dokumen hukum dan update terbaru.
- Admin membutuhkan kontrol dasar terhadap tampilan website seperti nama situs, lokasi, hero image, dan logo admin.

## 5. Ruang Lingkup Produk Saat Ini

### 5.1 Website Publik

Fitur yang sudah ada:

- Beranda dengan hero, navigasi dinamis, highlight fitur, berita/blog terbaru, produk hukum terbaru, FAQ, dan footer.
- Halaman blog dan detail blog.
- Halaman about, services, team, contact.
- Navbar mengambil data dari tabel `navbar_menus`.
- Footer menampilkan nama situs, ringkasan, dan artikel terbaru.
- Hero title, subtitle, lokasi, nama situs, gambar hero, dan ringkasan diambil dari `site_settings`.

Catatan:

- Beberapa bagian masih menggunakan konten template/lorem ipsum, terutama services, team, contact copy, FAQ, dan value section.
- Form kontak, pencarian, dan newsletter belum memiliki proses backend.

### 5.2 CMS Admin

Fitur yang sudah ada:

- Dashboard statistik: jumlah berita, artikel, produk hukum, dan galeri.
- Kelola berita: tambah dan hapus berita, upload gambar, status draft/published.
- Kelola artikel: tambah dan hapus artikel, upload gambar, status draft/published.
- Kelola produk hukum: upload PDF/DOC/DOCX, kategori, deskripsi, hapus file.
- Kelola galeri: upload foto dan caption.
- Kelola landing: update hero title, hero subtitle, about summary, dan konten about.
- Kelola menu: update identitas website, lokasi, footer about, menu, submenu, urutan, dan status aktif.
- Kelola akun: tambah dan hapus user, role admin/user, avatar.
- Profile: update nama, nomor telepon, avatar, dan password.
- Appearance: update hero image dan logo admin.

### 5.3 Portal User

Fitur yang sudah ada:

- Dashboard user dengan statistik berita, artikel, dan produk hukum published.
- Daftar berita published.
- Daftar artikel published.
- Daftar produk hukum dengan tombol download.
- Profile user dan ubah password.

Catatan:

- Tombol "Baca Selengkapnya" di portal user masih berupa link kosong.
- Belum ada halaman detail artikel/berita khusus untuk user dashboard.

### 5.4 Fondasi AI

Di database sudah tersedia struktur untuk:

- Template prompt AI.
- Paket AI.
- Kuota AI per user.
- Log request AI.

Namun file implementasi AI seperti `includes/ai_services.php`, `adminbaru/ai_assistant.php`, `adminbaru/ai_history.php`, `admview/ai_logs.php`, `admview/ai_settings.php`, dan `admview/kelola_ai_prompt.php` masih kosong. Jadi fitur AI belum dapat dianggap tersedia secara fungsional.

## 6. Kesesuaian dengan Kebutuhan Client

Karena kebutuhan client belum tersedia dalam dokumen terpisah, penilaian ini memakai asumsi kebutuhan dari aplikasi yang sudah dibangun: portal informasi hukum dengan CMS, akun user, publikasi artikel/berita, dan dokumen produk hukum.

### Sudah Memenuhi

- Website publik dasar sudah tersedia.
- Konten blog/artikel dan berita sudah bisa dikelola admin.
- Produk hukum sudah bisa diunggah dan diunduh.
- Login berbasis role admin/user sudah tersedia.
- Password sudah disimpan menggunakan `password_hash`.
- Menu navigasi sudah dinamis dari database.
- Identitas situs dan hero bisa diedit dari CMS.
- User dashboard sudah bisa menampilkan berita, artikel, dan produk hukum.

### Memenuhi Sebagian

- CMS ada, tetapi operasi edit/update untuk berita, artikel, produk hukum, dan galeri belum tersedia.
- Status draft/published ada untuk posts, tetapi daftar publik hanya menampilkan blog published, sementara sebagian halaman belum menampilkan news secara terpisah.
- Produk hukum tampil di beranda dan user dashboard, tetapi halaman publik khusus produk hukum/search/filter belum tersedia.
- Contact page ada, tetapi form belum menyimpan atau mengirim pesan.
- Newsletter/subscription ada secara visual, tetapi belum berfungsi.
- Gallery bisa dikelola, tetapi belum jelas ditampilkan di frontend.
- Role admin/user ada, tetapi proteksi akses belum konsisten di seluruh halaman dashboard.

### Belum Memenuhi

- Fitur AI legal assistant belum berjalan meskipun database sudah disiapkan.
- Tidak ada audit log aktivitas admin.
- Tidak ada CSRF protection pada form.
- Validasi upload belum konsisten di semua modul.
- Tidak ada reset password/lupa password.
- Belum ada pencarian fungsional untuk blog, berita, produk hukum, atau menu.
- Belum ada pagination nyata pada blog.
- Belum ada manajemen pesan kontak.
- Belum ada pengaturan SEO per halaman/post.
- Belum ada test otomatis atau dokumentasi deployment.

## 7. Prioritas Pengembangan

### Must Have

- Proteksi akses semua halaman admin dan user.
- Edit/update berita, artikel, produk hukum, galeri, dan user.
- Contact form menyimpan pesan ke database atau mengirim email.
- Link detail berita/artikel di user dashboard.
- Validasi upload file dan gambar secara konsisten.
- Perbaikan path download produk hukum di frontend publik.

### Should Have

- Search dan filter untuk blog, berita, dan produk hukum.
- Pagination dinamis.
- Halaman produk hukum publik.
- Manajemen pesan kontak di admin.
- CSRF token untuk semua form.
- Sanitasi output yang konsisten untuk mencegah XSS.

### Could Have

- SEO metadata per konten.
- Editor WYSIWYG.
- Preview sebelum publish.
- Audit log aktivitas admin.
- Integrasi AI legal assistant.
- Export data.

## 8. Metrik Keberhasilan

- Admin dapat membuat, mengedit, publish, draft, dan menghapus konten tanpa error.
- User dapat login, melihat konten published, dan mengunduh produk hukum.
- Pengunjung publik dapat membaca blog/detail dan melihat produk hukum terbaru.
- Semua form penting menghasilkan data atau aksi nyata.
- Tidak ada akses admin tanpa login.
- Upload file hanya menerima tipe file yang diizinkan.

## 9. Risiko Produk

- Client bisa menganggap fitur AI sudah termasuk karena struktur database dan menu/file sudah ada, padahal implementasi belum tersedia.
- Konten template yang masih tersisa dapat mengurangi kesan profesional.
- Halaman admin yang tidak diproteksi dapat menjadi risiko keamanan.
- Form statis dapat menimbulkan ekspektasi palsu bagi pengunjung.
- Tidak adanya fitur edit konten dapat menghambat workflow CMS harian.

## 10. Rekomendasi Keputusan

Produk sudah layak disebut prototype/versi awal CMS portal hukum. Untuk memenuhi kebutuhan client secara lebih kuat, produk perlu diselesaikan pada area keamanan akses, CRUD lengkap, form publik, search/filter, dan pembersihan konten template. Fitur AI sebaiknya diposisikan sebagai fase lanjutan sampai service dan UI-nya benar-benar dibuat.
