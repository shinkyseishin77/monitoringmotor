CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module` varchar(50) NOT NULL,
  `can_view` tinyint(1) DEFAULT 0,
  `can_create` tinyint(1) DEFAULT 0,
  `can_update` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_module` (`role_id`, `module`),
  CONSTRAINT `fk_permission_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `motors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pemilik` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `nomor_polisi` varchar(20) NOT NULL,
  `tahun` varchar(4) DEFAULT NULL,
  `status` enum('tersedia', 'service', 'digunakan') DEFAULT 'tersedia',
  `lokasi` varchar(100) DEFAULT NULL,
  `digunakan_oleh` varchar(100) DEFAULT NULL,
  `tujuan` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_polisi` (`nomor_polisi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `unit_acs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_unit` varchar(100) NOT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `kapasitas` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) NOT NULL,
  `status` enum('aktif', 'service', 'mati') DEFAULT 'aktif',
  `tanggal_pasang` date DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motor_id` int(11) NOT NULL,
  `tanggal_service` date NOT NULL,
  `keluhan` text NOT NULL,
  `tindakan` text,
  `biaya_jasa` decimal(10,2) DEFAULT 0,
  `status` enum('pending', 'proses', 'selesai') DEFAULT 'pending',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `motor_id` (`motor_id`),
  CONSTRAINT `fk_service_motor` FOREIGN KEY (`motor_id`) REFERENCES `motors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `jadwal_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_service` enum('regular', 'ganti_oli', 'tune_up', 'ac') NOT NULL,
  `motor_id` int(11) DEFAULT NULL,
  `unit_ac_id` int(11) DEFAULT NULL,
  `tanggal_jadwal` date NOT NULL,
  `catatan` text,
  `status` enum('dijadwalkan', 'selesai', 'terlewat') DEFAULT 'dijadwalkan',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `motor_id` (`motor_id`),
  KEY `unit_ac_id` (`unit_ac_id`),
  CONSTRAINT `fk_jadwal_motor` FOREIGN KEY (`motor_id`) REFERENCES `motors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_jadwal_ac` FOREIGN KEY (`unit_ac_id`) REFERENCES `unit_acs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `log_monitoring_motors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motor_id` int(11) NOT NULL,
  `status` enum('tersedia', 'service', 'digunakan') NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `digunakan_oleh` varchar(100) DEFAULT NULL,
  `tujuan` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `motor_id` (`motor_id`),
  CONSTRAINT `fk_log_motor` FOREIGN KEY (`motor_id`) REFERENCES `motors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `log_monitoring_acs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ac_id` int(11) NOT NULL,
  `status` enum('aktif', 'service', 'mati') NOT NULL,
  `suhu` varchar(20) DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ac_id` (`ac_id`),
  CONSTRAINT `fk_log_ac` FOREIGN KEY (`ac_id`) REFERENCES `unit_acs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `log_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `aksi` varchar(50) NOT NULL,
  `modul` varchar(50) NOT NULL,
  `data_lama` text,
  `data_baru` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seeding Default Admin Role & User
INSERT IGNORE INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Administrator Sistem');

-- Seeding Default Roles Permissions
-- Admin gets all permissions
INSERT IGNORE INTO `role_permissions` (`role_id`, `module`, `can_view`, `can_create`, `can_update`, `can_delete`) VALUES
(1, 'dashboard', 1, 1, 1, 1),
(1, 'motor', 1, 1, 1, 1),
(1, 'service', 1, 1, 1, 1),
(1, 'jadwal_service', 1, 1, 1, 1),
(1, 'monitoring', 1, 1, 1, 1),
(1, 'unit_ac', 1, 1, 1, 1),
(1, 'monitoring_ac', 1, 1, 1, 1),
(1, 'riwayat', 1, 1, 1, 1),
(1, 'laporan_monitoring', 1, 1, 1, 1),
(1, 'activity_log', 1, 1, 1, 1),
(1, 'kelola_role', 1, 1, 1, 1),
(1, 'kelola_user', 1, 1, 1, 1);

-- default user admin@bengkel.com, password md5 of 'password' or password_hash
-- Codeigniter uses standard PHP pass so let's just insert 'password' hashed with password_hash using BCRYPT but MySQL can't do password_hash natively.
-- Let's use MD5 or build a seeder in CI3. For simplicity, we can insert MD5 and modify Auth to accept MD5 or we'll insert a known bcrypt hash.
-- bcrypt hash of 'password' is: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi (Laravel default for 'password')
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `role_id`) VALUES
(1, 'Super Admin', 'admin@bengkel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

