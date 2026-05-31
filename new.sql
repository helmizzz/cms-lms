CREATE DATABASE IF NOT EXISTS if0_41394957_carporate_db;
USE if0_41394957_carporate_db;

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `navbar_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent_id` int DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `navbar_menus_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `navbar_menus` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `navbar_menus` (`id`, `title`, `url`, `parent_id`, `sort_order`, `is_active`) VALUES
	(3, 'Blogs', 'blog.php', NULL, 1, 1),
	(4, 'Home', 'index.php', NULL, 2, 1),
	(5, 'About Us', 'about.php', NULL, 2, 1),
	(6, 'Pelayanan', 'services.php', NULL, 3, 1),
	(7, 'Tim Kami', 'team.php', NULL, 4, 1),
	(8, 'Hubungi Kami', 'contact.php', NULL, 5, 1);

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('blog','news','about') NOT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `author_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `type`, `status`, `author_id`, `created_at`, `updated_at`) VALUES
	(1, 'Tentang Kami', 'tentang-kami', 'ini testing tentang perusahaan', NULL, 'about', 'published', 1, '2026-03-07 14:51:13', '2026-03-07 14:51:13'),
	(2, 'Test 1', 'test-1', 'tes konten', '1772895628_69ac3d8c0e45f.jpg', 'news', 'published', 1, '2026-03-07 15:00:28', '2026-03-07 15:00:28'),
	(3, 'Tes 2', 'tes-2', 'ini berita testing', '1772896629_69ac417588777.jpg', 'news', 'draft', 1, '2026-03-07 15:17:09', '2026-03-07 15:17:09'),
	(4, 'test artikel 1', 'test-artikel-1', 'ini testing isi', '1772897936_69ac46902b959.jpg', 'blog', 'draft', 1, '2026-03-07 15:38:56', '2026-03-07 15:38:56'),
	(5, 'test artikel 2', 'test-artikel-2', 'ini test isi artikel', '1772897973_69ac46b568d0c.jpg', 'blog', 'published', 1, '2026-03-07 15:39:33', '2026-03-07 15:39:33');

CREATE TABLE IF NOT EXISTS `produk_hukum` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `file_path` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `produk_hukum` (`id`, `title`, `description`, `file_path`, `category`, `created_at`) VALUES
	(1, 'Test aturarn', 'ini isi aturan', '1772898114_69ac4742d4a95.pdf', 'Peraturan Pemerintah', '2026-03-07 15:41:54');

CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`) VALUES
	(1, 'site_name', 'LEXALINK ID'),
	(2, 'location', 'Jakarta, Indonesia'),
	(3, 'footer_about', 'Solusi digital untuk manajemen informasi hukum dan berita terkini.'),
	(4, 'hero_title', 'Selamat Datang'),
	(5, 'hero_subtitle', 'Solusi digital untuk kebutuhan Anda.'),
	(6, 'about_summary', 'Testing yaa ini di footer'),
	(7, 'hero_image', 'img/1.jpg'),
	(8, 'admin_logo', '');

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `avatar` varchar(255) DEFAULT 'default_avatar.png',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `phone`, `role`, `avatar`, `created_at`, `updated_at`, `last_login`) VALUES
	(1, 'admin', '$2y$10$m5Lnrg.VPVggfGk9dHy5/eneyxvLz4eTast1TnkuYQnBc.fK89nM2', 'admin@example.com', 'Administrator', NULL, 'admin', 'default_avatar.png', '2026-02-28 21:04:13', '2026-03-07 14:50:28', '2026-03-07 14:50:28'),
	(2, 'user', '$2y$10$H8WDuM32RPZTFTuCvNzIfudQ1KsL5Yal1nHgQ0jpLXmCm4MEMm/ZK', 'user@gmail.com', 'User', '', 'user', '1772898194_69ac47926b306.png', '2026-03-07 15:43:14', '2026-03-07 15:50:46', '2026-03-07 15:50:46');

CREATE TABLE IF NOT EXISTS `ai_prompt_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `type` enum('chat','document','legal_analysis') NOT NULL DEFAULT 'chat',
  `category` varchar(100) DEFAULT NULL,
  `description` text,
  `system_prompt` longtext NOT NULL,
  `user_prompt_template` longtext DEFAULT NULL,
  `output_format` enum('plain_text','markdown','html','json') NOT NULL DEFAULT 'markdown',
  `temperature` decimal(3,2) NOT NULL DEFAULT '0.70',
  `max_tokens` int DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `type` (`type`),
  KEY `category` (`category`),
  KEY `is_active` (`is_active`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `ai_prompt_templates_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `ai_prompt_templates` (`id`, `title`, `slug`, `type`, `category`, `description`, `system_prompt`, `user_prompt_template`, `output_format`, `temperature`, `max_tokens`, `is_active`, `created_by`) VALUES
	(1, 'Chat Umum Bantuan Hukum', 'chat-umum-bantuan-hukum', 'chat', 'Chat', 'Template dasar untuk percakapan umum bertema hukum.', 'Anda adalah asisten AI untuk website layanan informasi hukum. Berikan jawaban yang jelas, ringkas, dan edukatif. Jangan mengaku sebagai pengacara dan sarankan pengguna berkonsultasi dengan profesional hukum untuk keputusan penting.', NULL, 'markdown', 0.70, 1200, 1, 1),
	(2, 'Generate Dokumen Hukum', 'generate-dokumen-hukum', 'document', 'Dokumen Hukum', 'Template dasar untuk membuat draft dokumen hukum.', 'Anda adalah asisten penyusun draft dokumen hukum. Buat dokumen yang rapi, formal, dan mudah diedit. Jika data tidak lengkap, gunakan placeholder yang jelas.', 'Jenis dokumen: {{document_type}}\nKebutuhan pengguna: {{user_input}}\nData tambahan: {{extra_context}}', 'markdown', 0.50, 2500, 1, 1),
	(3, 'Analisis Produk Hukum', 'analisis-produk-hukum', 'legal_analysis', 'Analisis Hukum', 'Template dasar untuk menganalisis teks produk hukum.', 'Anda adalah asisten analisis produk hukum. Ringkas isi utama, jelaskan poin penting, kewajiban, larangan, risiko, dan rekomendasi tindak lanjut secara terstruktur.', 'Produk hukum / teks: {{legal_text}}\nFokus analisis: {{analysis_focus}}', 'markdown', 0.40, 2500, 1, 1);

CREATE TABLE IF NOT EXISTS `ai_packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text,
  `request_limit` int NOT NULL DEFAULT '0',
  `token_limit` int NOT NULL DEFAULT '0',
  `period` enum('daily','weekly','monthly','lifetime') NOT NULL DEFAULT 'monthly',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(10) NOT NULL DEFAULT 'IDR',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `ai_packages` (`id`, `name`, `slug`, `description`, `request_limit`, `token_limit`, `period`, `price`, `currency`, `is_active`) VALUES
	(1, 'Free', 'free', 'Paket percobaan untuk pengguna standar.', 20, 50000, 'monthly', 0.00, 'IDR', 1),
	(2, 'Premium', 'premium', 'Paket penggunaan AI dengan batas request dan token lebih besar.', 500, 1500000, 'monthly', 99000.00, 'IDR', 1);

CREATE TABLE IF NOT EXISTS `user_ai_quotas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `package_id` int DEFAULT NULL,
  `request_limit` int NOT NULL DEFAULT '0',
  `token_limit` int NOT NULL DEFAULT '0',
  `requests_used` int NOT NULL DEFAULT '0',
  `tokens_used` int NOT NULL DEFAULT '0',
  `period_started_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `reset_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `package_id` (`package_id`),
  KEY `reset_at` (`reset_at`),
  KEY `is_active` (`is_active`),
  CONSTRAINT `user_ai_quotas_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_ai_quotas_package_fk` FOREIGN KEY (`package_id`) REFERENCES `ai_packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user_ai_quotas` (`user_id`, `package_id`, `request_limit`, `token_limit`, `requests_used`, `tokens_used`, `reset_at`, `is_active`) VALUES
	(1, 2, 500, 1500000, 0, 0, DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 MONTH), 1),
	(2, 1, 20, 50000, 0, 0, DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 MONTH), 1);

CREATE TABLE IF NOT EXISTS `ai_requests` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `prompt_template_id` int DEFAULT NULL,
  `request_type` enum('chat','document','legal_analysis') NOT NULL DEFAULT 'chat',
  `title` varchar(180) DEFAULT NULL,
  `input_text` longtext,
  `input_payload` json DEFAULT NULL,
  `final_prompt` longtext,
  `response_text` longtext,
  `provider` varchar(50) NOT NULL DEFAULT 'openrouter',
  `model` varchar(120) DEFAULT NULL,
  `prompt_tokens` int NOT NULL DEFAULT '0',
  `completion_tokens` int NOT NULL DEFAULT '0',
  `total_tokens` int NOT NULL DEFAULT '0',
  `quota_request_charged` int NOT NULL DEFAULT '1',
  `quota_tokens_charged` int NOT NULL DEFAULT '0',
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `error_message` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `prompt_template_id` (`prompt_template_id`),
  KEY `request_type` (`request_type`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `ai_requests_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ai_requests_prompt_template_fk` FOREIGN KEY (`prompt_template_id`) REFERENCES `ai_prompt_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
