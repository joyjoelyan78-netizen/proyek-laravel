PERUBAHAN WEBSITE VESCA: TAHAP 3 (rapikan backend, produk dari kode, desain ulang detail produk)

URUTAN PASANG
 1. BACKUP project dan database dulu.
 2. Salin isi folder ini ke folder project (C:\vesca_baru), timpa file yang sama.
 3. Jalankan hapus_file_lama.bat (klik dua kali, ketik YA). Ini menghapus 106 file/folder
    backend lama. Database TIDAK disentuh.
 4. Di terminal project:
       composer dump-autoload
       php artisan optimize:clear
 5. Tekan Ctrl+F5 di browser.

PRODUK SEKARANG DARI KODE
  Data produk (8 seri, 83 tipe, foto, kegunaan) ada di config/katalog_vesca.php.
  Foto ada di public/image/produk/. Ganti foto dengan nama file yang sama, atau ubah
  daftar 'gambar' di config. Tidak ada lagi halaman admin produk/kategori.

NOMOR WHATSAPP & KONTAK (config/vesca.php)
  whatsapp  : nomor utama untuk tombol WhatsApp di halaman produk
  kontak_wa : dua nomor di footer
  email, alamat : footer dan halaman Hubungi Kami

YANG TETAP ADA DI ADMIN
  Dashboard, Permintaan Penawaran, Konsultasi Teknis, Akun Admin (khusus Super Admin),
  Ganti Password, Login/Logout.

DIHAPUS (keamanan): halaman register umum, lupa password, verifikasi email.
  Akun admin baru dibuat Super Admin lewat menu Akun Admin.
