-- File Penambahan Tabel dan Relasi untuk Fitur "Aduan"

CREATE TABLE IF NOT EXISTS `aduan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelapor` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `isi_aduan` text NOT NULL,
  `status` enum('pending','proses','selesai','ditolak') DEFAULT 'pending',
  `alasan` text DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tambahan Permissions untuk Modul Aduan agar Super Admin dapat mengaksesnya
INSERT IGNORE INTO `role_permissions` (`role_id`, `module`, `can_view`, `can_create`, `can_update`, `can_delete`) VALUES
(1, 'aduan', 1, 1, 1, 1);
