PERUBAHAN WEBSITE VESCA: Lacak Pesanan + Klaim Garansi -> Minta Penawaran Resmi + Konsultasi & Spesifikasi Teknis

CARA PASANG
1. Backup dulu folder project dan database kamu.
2. Salin isi folder ini ke folder project (vesca_baru), timpa file yang sama.
3. Jalankan: php artisan migrate
   (ada 2 migrasi: pembuatan 2 tabel, lalu penambahan kolom katalog; keduanya hanya MENAMBAH)
   (hanya membuat 2 tabel baru; tabel lama tidak disentuh)
   Alternatif tanpa artisan: impor database/sql/penawaran_konsultasi.sql lalu penawaran_konsultasi_tambahan.sql lewat phpMyAdmin.
   Pilih salah satu saja, jangan dua-duanya.
4. Pastikan ada storage link: php artisan storage:link
5. Isi di file .env (opsional, supaya tombol WhatsApp muncul):
   VESCA_WHATSAPP=62812xxxxxxxx
   VESCA_SLA_RESPON="1x24 jam kerja"
6. Jalankan: php artisan optimize:clear

HALAMAN BARU
  /minta-penawaran     /konsultasi-teknis
  Admin: /admin/permintaan-penawaran   /admin/konsultasi-teknis

TIDAK DIHAPUS
  Tabel pesanan, tracking_pesanan, klaim_garansi, serial_produk, tiket_teknisi, verifikasi_garansi, dll.
  Controller, view, dan model lama tetap ada. Route publik lama dijadikan komentar di routes/web.php,
  dan alamat lama /lacak-pesanan serta /klaim-garansi dialihkan ke halaman baru.

DATA KATALOG
  Semua tipe, ukuran, berat, performa, dan sertifikat ada di config/katalog_vesca.php
  (disalin dari CATALOG_PT_VESCARINDO.pdf). Kalau katalog berubah, cukup edit file itu.

TAMPILAN HP / TABLET
  public/css/responsive.css dimuat paling akhir oleh layouts/frontend.blade.php.
  Navbar memakai menu hamburger sampai lebar 1024px (tablet). Setelah menimpa file,
  tekan Ctrl+F5 di browser supaya CSS lama tidak tersimpan di cache.
