<?php

/*
|--------------------------------------------------------------------------
| DATA KATALOG VESCA
|--------------------------------------------------------------------------
| Disalin dari CATALOG_PT_VESCARINDO.pdf. Dipakai oleh halaman
| Konsultasi & Spesifikasi Teknis dan formulir Minta Penawaran Resmi.
|
| Kalau katalog diperbarui (tipe baru, berat berubah, dll.), cukup ubah
| file ini. Tidak perlu mengubah tampilan atau database.
|
| Data produk untuk halaman web (nama, foto, kegunaan) juga diatur di sini:
|   - 'slug'     : alamat halaman, contoh /produk/zinc-las
|   - 'gambar'   : nama file foto di public/image/produk/ (yang pertama = foto utama)
|   - 'bentuk'   : jenis pemasangan (dipakai untuk rekomendasi produk serupa)
|
| Format baris tabel:  [kode tipe, kolom 2, kolom 3, ...]
|   - 'kolom'     : judul kolom tabel (urutan sama dengan baris)
|   - 'format'    : pola ringkasan per kolom ke-2 dst. (untuk dropdown)
|   - 'berat_idx' : nomor kolom (mulai 0) yang berisi berat nett (kg)
*/

return [

    /*
    |--------------------------------------------------------------------------
    | DATA MATERIAL & PERFORMA
    |--------------------------------------------------------------------------
    */

    'bahan' => [

        'aluminium' => [
            'nama'      => 'Aluminium Anode',
            'ringkasan' => 'Dicor dari paduan aluminium dengan tambahan zinc dan indium, dikembangkan khusus untuk air laut dan lumpur laut (sea mud). Dibuat dari ingot aluminium kemurnian tinggi.',
            'performa'  => [
                'Potensial larutan nominal' => '-1.10 volt terhadap Ag/AgCl',
                'Kapasitas listrik nominal' => '2700 Ampere-jam per kg',
                'Laju konsumsi nominal'     => '3.24 kg/A per tahun',
                'Tegangan penggerak nominal' => '0.3 volt terhadap baja terpolarisasi',
            ],
            'komposisi_kolom' => ['Unsur', 'Persentase (%)'],
            'komposisi' => [
                ['Zinc', '2.0 – 5.0'],
                ['Indium', '0.005 – 0.035'],
                ['Titanium', '0.01 – 0.05'],
                ['Silicon', '0.15 max'],
                ['Iron', '0.13 max'],
                ['Copper', '0.006 max'],
                ['Others', '0.02 max masing-masing'],
                ['Aluminium', 'sisanya'],
            ],
        ],

        'zinc' => [
            'nama'      => 'Zinc Anode',
            'ringkasan' => 'Mengacu pada spesifikasi A-1800-J (US Military Specification), standar perdagangan yang umum dipakai di seluruh dunia. Dicor dari paduan zinc kemurnian 99.995% dengan sedikit tambahan unsur paduan khusus.',
            'performa'  => [
                'Potensial larutan nominal' => '-1.05 volt terhadap Ag/AgCl',
                'Kapasitas listrik nominal' => '780 Ampere-jam per kg',
                'Laju konsumsi nominal'     => '11.25 kg/A per tahun',
                'Tegangan penggerak nominal' => '0.25 volt terhadap baja terpolarisasi',
            ],
            'komposisi_kolom' => ['Unsur', 'A-1800-H', 'A-1800-J'],
            'komposisi' => [
                ['Cadmium', '0.025 – 0.15', '0.025 – 0.07'],
                ['Copper', '0.005 max', '0.005 max'],
                ['Iron', '0.005 max', '0.005 max'],
                ['Silicon', '0.125 max', '-'],
                ['Aluminium', '0.1 – 0.50', '0.10 – 0.50'],
                ['Lead', '0.006 max', '0.006 max'],
                ['Zinc', 'sisanya', 'sisanya'],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | SERI PRODUK
    |--------------------------------------------------------------------------
    */

    'seri' => [

        // ====================== ALUMINIUM ======================

        'aluminium_las' => [
            'bahan'     => 'aluminium',
            'slug'      => 'aluminium-las',
            'bentuk'    => 'las',
            'judul'     => 'Aluminium Anode Tipe Las',
            'subjudul'  => 'Ship Hull Welding Type',
            'ringkas'   => 'Anoda aluminium untuk lambung kapal, dipasang dengan cara dilas.',
            'gambar'    => ['aluminium-las.jpg'],
            'kegunaan'  => [
                'Proteksi katodik lambung kapal (ship hull)',
                'Dipasang dengan las pada core baja',
                'Dibuat dari ingot aluminium kemurnian tinggi',
            ],
            'nama'      => 'Tipe Las (Ship Hull Welding)',
            'deskripsi' => 'Anoda aluminium untuk lambung kapal, dipasang dengan cara dilas.',
            'kolom'     => ['Tipe', 'Dimensi anoda (L x W x T) mm', 'Dimensi core (P x L x T) mm', 'Berat nett (kg)', 'Berat gross (kg)'],
            'format'    => ['anoda %s mm', 'core %s mm', 'nett %s kg', 'gross %s kg'],
            'berat_idx' => 3,
            'baris'     => [
                ['AV-140', '200 x 95 x 30',  '300 x 25 x 6',   '1.2',  '1.4'],
                ['AV-320', '250 x 145 x 30', '350 x 40 x 6',   '2.6',  '3.2'],
                ['AV-450', '380 x 150 x 35', '530 x 50 x 6',   '4.5',  '5.2'],
                ['AV-550', '380 x 150 x 40', '530 x 50 x 6',   '5.5',  '6.0'],
                ['AV-720', '520 x 117 x 46', '650 x 50 x 6',   '7.2',  '8.0'],
                ['AV-860', '520 x 117 x 52', '650 x 50 x 6',   '8.6',  '9.8'],
                ['AV-126', '520 x 117 x 67', '650 x 50 x 6',   '12.6', '13.8'],
                ['AV-141', '915 x 130 x 50', '1015 x 50 x 6',  '14.1', '16.0'],
                ['AV-210', '915 x 130 x 75', '1015 x 50 x 6',  '21.0', '24.0'],
                ['AV-300', '920 x 130 x 140', '1015 x 50 x 6', '30.0', '33.0'],
            ],
        ],

        'aluminium_baut' => [
            'bahan'     => 'aluminium',
            'slug'      => 'aluminium-baut',
            'bentuk'    => 'baut',
            'judul'     => 'Aluminium Anode Tipe Baut',
            'subjudul'  => 'Ship Hull Bolt Type',
            'ringkas'   => 'Anoda aluminium untuk lambung kapal, dipasang dengan baut.',
            'gambar'    => ['aluminium-baut-1.jpg', 'aluminium-baut-2.jpg'],
            'kegunaan'  => [
                'Proteksi katodik lambung kapal (ship hull)',
                'Dipasang dengan baut, jarak baut mengikuti tipe',
                'Dibuat dari ingot aluminium kemurnian tinggi',
            ],
            'nama'      => 'Tipe Baut (Ship Hull Bolt)',
            'deskripsi' => 'Anoda aluminium untuk lambung kapal, dipasang dengan baut.',
            'kolom'     => ['Tipe', 'Dimensi anoda (L x W x T) mm', 'Dimensi core (PCD)', 'Berat nett (kg)', 'Berat gross (kg)'],
            'format'    => ['anoda %s mm', '%s', 'nett %s kg', 'gross %s kg'],
            'berat_idx' => 3,
            'baris'     => [
                ['B2',  '150 x 70 x 20',  'Bolts @ 75 mm between Ctrs',  '0.3',  '0.5'],
                ['B3',  '200 x 100 x 20', 'Bolts @ 110 mm between Ctrs', '0.8',  '1.0'],
                ['B4',  '200 x 100 x 30', 'Bolts @ 110 mm between Ctrs', '1.15', '1.4'],
                ['B4E', '200 x 100 x 40', 'Bolts @ 110 mm between Ctrs', '1.5',  '1.8'],
                ['B8',  '300 x 150 x 25', 'Bolts @ 160 mm between Ctrs', '2.5',  '2.9'],
                ['B9',  '300 x 150 x 30', 'Bolts @ 160 mm between Ctrs', '2.9',  '3.3'],
                ['B9E', '300 x 150 x 40', 'Bolts @ 160 mm between Ctrs', '4.2',  '4.6'],
                ['B9F', '300 x 150 x 50', 'Bolts @ 160 mm between Ctrs', '5.1',  '5.5'],
                ['B11', '300 x 150 x 75', 'Bolts @ 160 mm between Ctrs', '9.2',  '9.6'],
            ],
        ],

        'aluminium_batang' => [
            'bahan'     => 'aluminium',
            'slug'      => 'aluminium-batang',
            'bentuk'    => 'batang',
            'judul'     => 'Aluminium Rod Anode',
            'subjudul'  => 'Anoda Batang',
            'ringkas'   => 'Anoda aluminium berbentuk batang / silinder dalam berbagai ukuran.',
            'gambar'    => ['aluminium-batang.jpg'],
            'kegunaan'  => [
                'Berbentuk batang (rod) dan silinder',
                'Tersedia dalam berbagai panjang dan diameter',
                'Penggunaan yang tepat bisa dikonsultasikan dengan tim teknis',
            ],
            'nama'      => 'Rod Anode (Batang)',
            'deskripsi' => 'Anoda aluminium berbentuk batang / silinder.',
            'kolom'     => ['Tipe', 'Berat (kg)', 'Panjang (mm)', 'Diameter (mm)'],
            'format'    => ['%s kg', 'panjang %s mm', 'diameter %s mm'],
            'berat_idx' => 1,
            'baris'     => [
                ['AVR-101', '0.4',  '10',  '70'],
                ['AVR-102', '0.4',  '15',  '100'],
                ['AVR-103', '4.9',  '50',  '150'],
                ['AVR-104', '0.4',  '300', '30'],
                ['AVR-105', '0.8',  '300', '25'],
                ['AVR-106', '1.6',  '300', '25'],
                ['AVR-107', '2.3',  '300', '30'],
                ['AVR-108', '4.1',  '300', '40'],
                ['AVR-109', '6.5',  '300', '50'],
                ['AVR-110', '9.3',  '300', '60'],
                ['AVR-111', '12.7', '300', '70'],
                ['AVR-112', '16.5', '300', '80'],
                ['AVR-113', '20.9', '300', '90'],
                ['AVR-114', '25.9', '300', '100'],
                ['AVR-115', '31.3', '300', '110'],
                ['AVR-116', '37.2', '300', '120'],
                ['AVR-117', '43.7', '300', '130'],
            ],
        ],

        'aluminium_platform' => [
            'bahan'     => 'aluminium',
            'slug'      => 'aluminium-platform',
            'bentuk'    => 'platform',
            'judul'     => 'Aluminium Anode Platform / Jetty',
            'subjudul'  => 'Platform or Jetty Aluminium Anodes',
            'ringkas'   => 'Anoda aluminium berukuran besar untuk platform dan dermaga (jetty).',
            'gambar'    => ['aluminium-platform-1.jpg', 'aluminium-platform-2.jpg'],
            'kegunaan'  => [
                'Untuk platform dan dermaga (jetty)',
                'Dilengkapi core baja untuk pemasangan',
                'Ukuran besar untuk kebutuhan struktur',
            ],
            'nama'      => 'Platform / Jetty',
            'deskripsi' => 'Anoda aluminium untuk platform dan dermaga (jetty).',
            'kolom'     => ['Tipe', 'Panjang anoda (mm)', 'Lebar anoda (mm)', 'Tinggi anoda (mm)', 'Core extension (mm)', 'Diameter core (mm)', 'Berat nett (kg)', 'Berat gross (kg)'],
            'format'    => ['panjang %s mm', 'lebar %s mm', 'tinggi %s mm', 'core ext. %s mm', 'diameter core %s mm', 'nett %s kg', 'gross %s kg'],
            'berat_idx' => 6,
            'baris'     => [
                ['AVS-45',  '1320', '102', '102', '152', '19',  '35',  '38'],
                ['AVS-68',  '1525', '135', '130', '152', '19',  '68',  '72'],
                ['AVS-119', '1550', '184', '159', '152', '25',  '119', '126'],
                ['AVS-148', '2440', '160', '162', '152', '60',  '148', '170'],
                ['AVS-240', '2750', '207', '207', '152', '114', '240', '306'],
                ['AVS-330', '2440', '252', '244', '152', '114', '330', '391'],
                ['AVS-435', '3000', '254', '257', '152', '114', '435', '507'],
                ['AVS-565', '3048', '283', '283', '152', '114', '565', '640'],
            ],
        ],

        // ====================== ZINC ======================

        'zinc_las' => [
            'bahan'     => 'zinc',
            'slug'      => 'zinc-las',
            'bentuk'    => 'las',
            'judul'     => 'Zinc Anode Tipe Las',
            'subjudul'  => 'Ship Hull Welding Type',
            'ringkas'   => 'Anoda zinc untuk lambung kapal, dipasang dengan cara dilas.',
            'gambar'    => ['zinc-las.jpg'],
            'kegunaan'  => [
                'Proteksi katodik lambung kapal (ship hull)',
                'Dipasang dengan las pada core baja',
                'Mengacu spesifikasi A-1800-J, paduan zinc kemurnian 99.995%',
            ],
            'nama'      => 'Tipe Las (Ship Hull Welding)',
            'deskripsi' => 'Anoda zinc untuk lambung kapal, dipasang dengan cara dilas.',
            'kolom'     => ['Tipe', 'Dimensi anoda (L x W x T) mm', 'Dimensi core (P x L x T) mm', 'Berat nett (kg)', 'Berat gross (kg)'],
            'format'    => ['anoda %s mm', 'core %s mm', 'nett %s kg', 'gross %s kg'],
            'berat_idx' => 3,
            'baris'     => [
                ['S-2',    '150 x 70 x 20',  '230 x 24 x 3',  '1.87', '2.0'],
                ['S-3',    '200 x 100 x 20', '300 x 38 x 3',  '2.60', '3.0'],
                ['S-4',    '200 x 100 x 30', '300 x 38 x 3',  '3.80', '4.2'],
                ['S-6',    '300 x 150 x 20', '270 x 30 x 4',  '5.75', '6.0'],
                ['S-8',    '300 x 150 x 25', '270 x 30 x 4',  '7.25', '8.0'],
                ['S-9',    '300 x 150 x 30', '270 x 30 x 4',  '8.75', '9.5'],
                ['ZV-320', '270 x 150 x 32', '350 x 40 x 6',  '5.5',  '6.0'],
                ['ZV-450', '400 x 150 x 32', '530 x 40 x 6',  '11.1', '12.1'],
                ['ZV-165', '550 x 150 x 25', '650 x 40 x 6',  '16.5', '18.0'],
            ],
        ],

        'zinc_baut' => [
            'bahan'     => 'zinc',
            'slug'      => 'zinc-baut',
            'bentuk'    => 'baut',
            'judul'     => 'Zinc Anode Seri B (Baut)',
            'subjudul'  => 'Ship Hull B Series',
            'ringkas'   => 'Anoda zinc seri B untuk lambung kapal, dipasang dengan baut.',
            'gambar'    => ['zinc-baut.jpg'],
            'kegunaan'  => [
                'Proteksi katodik lambung kapal (ship hull)',
                'Dipasang dengan baut, jarak baut mengikuti tipe',
                'Mengacu spesifikasi A-1800-J, paduan zinc kemurnian 99.995%',
            ],
            'nama'      => 'Seri B (Baut)',
            'deskripsi' => 'Anoda zinc untuk lambung kapal, seri B dengan pemasangan baut.',
            'kolom'     => ['Tipe', 'Dimensi anoda (L x W x T) mm', 'Dimensi core (PCD)', 'Berat nett (kg)', 'Berat gross (kg)'],
            'format'    => ['anoda %s mm', '%s', 'nett %s kg', 'gross %s kg'],
            'berat_idx' => 3,
            'baris'     => [
                ['B2',  '150 x 70 x 25',  'Bolts @ 75 mm between Ctrs',  '1.1',  '1.5'],
                ['B3',  '200 x 100 x 20', 'Bolts @ 110 mm between Ctrs', '2.2',  '2.5'],
                ['B4',  '200 x 100 x 30', 'Bolts @ 110 mm between Ctrs', '3.3',  '3.6'],
                ['B6',  '300 x 150 x 20', 'Bolts @ 160 mm between Ctrs', '5.5',  '5.75'],
                ['B8',  '300 x 150 x 25', 'Bolts @ 160 mm between Ctrs', '6.9',  '7.3'],
                ['B9',  '300 x 150 x 30', 'Bolts @ 160 mm between Ctrs', '8.2',  '8.5'],
                ['B9E', '300 x 150 x 40', 'Bolts @ 160 mm between Ctrs', '10.6', '11.0'],
                ['B9F', '300 x 150 x 50', 'Bolts @ 160 mm between Ctrs', '13.4', '13.8'],
            ],
        ],

        'zinc_tank' => [
            'bahan'     => 'zinc',
            'slug'      => 'zinc-tank',
            'bentuk'    => 'tank',
            'judul'     => 'Zinc Tank Anode',
            'subjudul'  => 'Anoda untuk Tangki',
            'ringkas'   => 'Anoda zinc untuk tangki (tank anode), dilengkapi core baja.',
            'gambar'    => ['zinc-tank-1.jpg', 'zinc-tank-2.jpg'],
            'kegunaan'  => [
                'Dirancang untuk tangki (tank anode)',
                'Dilengkapi core baja untuk pemasangan',
                'Mengacu spesifikasi A-1800-J, paduan zinc kemurnian 99.995%',
            ],
            'nama'      => 'Tank Anode',
            'deskripsi' => 'Anoda zinc untuk tangki.',
            'kolom'     => ['Tipe', 'A (mm)', 'B (mm)', 'C (mm)', 'D (mm)', 'Diameter core (mm)', 'Berat nett (kg)', 'Berat gross (kg)'],
            'format'    => ['A %s mm', 'B %s mm', 'C %s mm', 'D %s mm', 'diameter core %s mm', 'nett %s kg', 'gross %s kg'],
            'berat_idx' => 6,
            'baris'     => [
                ['ZVT-212', '1220', '227', '51', '51', '12', '21.2', '22.7'],
                ['ZVT-304', '1220', '227', '60', '60', '12', '30.4', '32.0'],
                ['ZVT-318', '1220', '227', '63', '63', '12', '31.8', '33.4'],
                ['ZVT-450', '1220', '227', '76', '76', '12', '45.0', '46.6'],
                ['ZVT-500', '1525', '227', '70', '70', '12', '50.0', '52.0'],
            ],
        ],

        'zinc_batang' => [
            'bahan'     => 'zinc',
            'slug'      => 'zinc-batang',
            'bentuk'    => 'batang',
            'judul'     => 'Zinc Rod Anode',
            'subjudul'  => 'Anoda Batang',
            'ringkas'   => 'Anoda zinc berbentuk batang / silinder dalam berbagai ukuran.',
            'gambar'    => ['zinc-batang.jpg'],
            'kegunaan'  => [
                'Berbentuk batang (rod) dan silinder',
                'Tersedia dalam berbagai panjang dan diameter',
                'Penggunaan yang tepat bisa dikonsultasikan dengan tim teknis',
            ],
            'nama'      => 'Rod Anode (Batang)',
            'deskripsi' => 'Anoda zinc berbentuk batang / silinder.',
            'kolom'     => ['Tipe', 'Berat (kg)', 'Panjang (mm)', 'Diameter (mm)'],
            'format'    => ['%s kg', 'panjang %s mm', 'diameter %s mm'],
            'berat_idx' => 1,
            'baris'     => [
                ['AVR-101', '1.1',   '10',  '70'],
                ['AVR-102', '3.3',   '15',  '100'],
                ['AVR-103', '12.5',  '50',  '150'],
                ['AVR-104', '1.0',   '150', '30'],
                ['AVR-105', '2.1',   '300', '25'],
                ['AVR-106', '4.2',   '300', '25'],
                ['AVR-107', '6.0',   '300', '30'],
                ['AVR-108', '10.7',  '300', '40'],
                ['AVR-109', '16.7',  '300', '50'],
                ['AVR-110', '24.1',  '300', '60'],
                ['AVR-111', '32.7',  '300', '70'],
                ['AVR-112', '42.8',  '300', '80'],
                ['AVR-113', '54.1',  '300', '90'],
                ['AVR-114', '66.8',  '300', '100'],
                ['AVR-115', '80.8',  '300', '110'],
                ['AVR-116', '96.2',  '300', '120'],
                ['AVR-117', '112.9', '300', '130'],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | SERTIFIKASI
    |--------------------------------------------------------------------------
    */

    'sertifikat' => [

        [
            'judul'    => 'BKI Type Approval: Aluminium Anode',
            'lembaga'  => 'Biro Klasifikasi Indonesia',
            'detail'   => [
                'Tipe produk'      => 'VESCA Aluminium Anode AVW (KI-Al1) & AVB (KI-Al1)',
                'No. persetujuan'  => '00518TA26',
                'Tanggal'          => '26 Desember 2025',
                'Berlaku sampai'   => '25 Desember 2030',
            ],
        ],

        [
            'judul'    => 'BKI Type Approval: Zinc Anode',
            'lembaga'  => 'Biro Klasifikasi Indonesia',
            'detail'   => [
                'Tipe produk'      => 'VESCA Zinc Anode (KI-Zn1 & KI-Zn2)',
                'No. persetujuan'  => '00551TA26',
                'Tanggal'          => '27 Juli 2026',
                'Berlaku sampai'   => '26 Juli 2031',
            ],
        ],

        [
            'judul'    => 'ISO 9001:2015',
            'lembaga'  => 'RMI Certification',
            'detail'   => [
                'Cakupan'          => 'Metal casting fabrication and trading',
                'ID sertifikat'    => 'RMI20200320162QMS47',
                'Diterbitkan'      => '28 Maret 2025',
                'Berlaku sampai'   => '27 Maret 2028',
            ],
        ],

    ],

];
