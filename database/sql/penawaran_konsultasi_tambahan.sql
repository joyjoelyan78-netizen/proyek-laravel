-- =====================================================================
-- Tambahan kolom untuk penyesuaian katalog VESCA
-- Setara dengan migration 2026_10_14_000000_tambah_kolom_katalog_pada_penawaran_dan_konsultasi
--
-- PAKAI FILE INI HANYA JIKA tidak memakai "php artisan migrate".
-- Jangan dijalankan dua-duanya (nanti error "duplicate column").
-- =====================================================================

ALTER TABLE `permintaan_penawaran`
  ADD COLUMN `rincian_item` TEXT NULL AFTER `id_produk`;

ALTER TABLE `konsultasi_teknis`
  ADD COLUMN `produk_diminati` VARCHAR(150) NULL AFTER `id_produk`;

-- Jika memakai SQL ini (bukan artisan), catat juga ke tabel migrations:
-- INSERT INTO `migrations` (`migration`, `batch`)
-- VALUES ('2026_10_14_000000_tambah_kolom_katalog_pada_penawaran_dan_konsultasi',
--         (SELECT IFNULL(MAX(b.`batch`), 0) + 1 FROM (SELECT `batch` FROM `migrations`) b));
