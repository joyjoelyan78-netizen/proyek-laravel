<?php

/*
|--------------------------------------------------------------------------
| Pengaturan fitur Penawaran & Konsultasi
|--------------------------------------------------------------------------
| Isi lewat file .env, contoh:
|   VESCA_WHATSAPP=6281234567890      (tanpa tanda + dan tanpa spasi)
|   VESCA_SLA_RESPON="1x24 jam kerja"
|   VESCA_TELEPON_1, VESCA_TELEPON_2, VESCA_EMAIL   (sudah terisi dari katalog)
|
| Kalau VESCA_WHATSAPP kosong, tombol WhatsApp otomatis tidak ditampilkan.
*/

return [

    'whatsapp' => env('VESCA_WHATSAPP'),

    'sla_respon' => env('VESCA_SLA_RESPON', '1x24 jam kerja'),

    // Kontak langsung (diambil dari katalog). Bisa diganti lewat .env
    'telepon' => [
        env('VESCA_TELEPON_1', '021-86902769'),
        env('VESCA_TELEPON_2', '021-86902092'),
    ],

    'email' => env('VESCA_EMAIL', 'Vescarindoutama@yahoo.co.id'),

    // Alamat untuk halaman Hubungi Kami dan footer.
    // Tautan Google Maps = tautan yang dikirim Joy. Kalau alamat teks di bawah
    // belum sama dengan lokasi di tautan itu, ubah di sini.
    'alamat' => [
        'Jl. Narogong KM. 12, Pangkalan 2, Cikiwul',
        'Gg. Blaung RT. 004 / RW. 003, Bantar Gebang',
        'Bekasi, Jawa Barat, Indonesia',
    ],

    'alamat_footer' => 'Jl. Narogong KM. 12, Pangkalan 2, Cikiwul, Bantar Gebang, Bekasi',

    'maps_url' => env('VESCA_MAPS_URL', 'https://share.google/nVxDYWUz0XGi8tA8v'),

    // kata kunci untuk peta yang tampil di halaman (embed)
    'maps_query' => env('VESCA_MAPS_QUERY', 'PT Vescarindo Utama, Jl. Narogong KM 12, Pangkalan 2, Cikiwul, Bantar Gebang, Bekasi'),

];
