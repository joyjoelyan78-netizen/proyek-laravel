-- =====================================================================
-- Tabel baru: permintaan_penawaran & konsultasi_teknis
-- Setara dengan migration 2026_10_13_000000_create_penawaran_dan_konsultasi_tables
--
-- PAKAI FILE INI HANYA JIKA tidak memakai "php artisan migrate".
-- Jangan dijalankan dua-duanya (nanti error "table already exists").
-- Tabel lama (pesanan, tracking_pesanan, klaim_garansi, dll.) TIDAK disentuh.
-- =====================================================================

CREATE TABLE IF NOT EXISTS `permintaan_penawaran` (
  `id_penawaran`        BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_permintaan`    VARCHAR(255) NOT NULL,
  `nama_pemohon`        VARCHAR(255) NOT NULL,
  `nama_perusahaan`     VARCHAR(255) NULL,
  `email`               VARCHAR(255) NOT NULL,
  `nomor_telepon`       VARCHAR(30)  NOT NULL,
  `id_produk`           BIGINT UNSIGNED NULL,
  `jenis_produk`        VARCHAR(50)  NOT NULL,
  `tipe_ukuran`         VARCHAR(255) NULL,
  `jumlah`              INT UNSIGNED NOT NULL,
  `satuan`              VARCHAR(30)  NOT NULL DEFAULT 'pcs',
  `jenis_kapal`         VARCHAR(255) NULL,
  `lokasi_pengiriman`   VARCHAR(255) NOT NULL,
  `tanggal_dibutuhkan`  DATE NULL,
  `file_lampiran`       VARCHAR(255) NULL,
  `catatan`             TEXT NULL,
  `status`              VARCHAR(30)  NOT NULL DEFAULT 'baru',
  `catatan_admin`       TEXT NULL,
  `id_user_proses`      BIGINT UNSIGNED NULL,
  `created_at`          TIMESTAMP NULL DEFAULT NULL,
  `updated_at`          TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_penawaran`),
  UNIQUE KEY `permintaan_penawaran_nomor_permintaan_unique` (`nomor_permintaan`),
  KEY `permintaan_penawaran_id_produk_index` (`id_produk`),
  KEY `permintaan_penawaran_id_user_proses_index` (`id_user_proses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `konsultasi_teknis` (
  `id_konsultasi`       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomor_konsultasi`    VARCHAR(255) NOT NULL,
  `nama_pengirim`       VARCHAR(255) NOT NULL,
  `nama_perusahaan`     VARCHAR(255) NULL,
  `email`               VARCHAR(255) NOT NULL,
  `nomor_telepon`       VARCHAR(30)  NOT NULL,
  `id_produk`           BIGINT UNSIGNED NULL,
  `jenis_kapal`         VARCHAR(255) NOT NULL,
  `ukuran_kapal`        VARCHAR(255) NULL,
  `bagian_dilindungi`   VARCHAR(255) NULL,
  `kondisi_air`         VARCHAR(30)  NOT NULL,
  `pertanyaan`          TEXT NOT NULL,
  `status`              VARCHAR(30)  NOT NULL DEFAULT 'baru',
  `balasan_admin`       TEXT NULL,
  `id_user_balas`       BIGINT UNSIGNED NULL,
  `dibalas_pada`        DATETIME NULL,
  `created_at`          TIMESTAMP NULL DEFAULT NULL,
  `updated_at`          TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_konsultasi`),
  UNIQUE KEY `konsultasi_teknis_nomor_konsultasi_unique` (`nomor_konsultasi`),
  KEY `konsultasi_teknis_id_produk_index` (`id_produk`),
  KEY `konsultasi_teknis_id_user_balas_index` (`id_user_balas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jika memakai SQL ini (bukan artisan), catat juga ke tabel migrations
-- supaya "php artisan migrate" nanti tidak mencoba membuat ulang:
-- INSERT INTO `migrations` (`migration`, `batch`)
-- VALUES ('2026_10_13_000000_create_penawaran_dan_konsultasi_tables',
--         (SELECT IFNULL(MAX(b.`batch`), 0) + 1 FROM (SELECT `batch` FROM `migrations`) b));
