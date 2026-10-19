<?php

namespace App\Support;

/*
|--------------------------------------------------------------------------
| Pembaca data katalog (config/katalog_vesca.php)
|--------------------------------------------------------------------------
*/

class KatalogVesca
{
    /** Seri khusus untuk ukuran di luar katalog. */
    public const CUSTOM = [
        'aluminium_custom' => ['bahan' => 'aluminium', 'label' => 'Aluminium: ukuran khusus (custom)'],
        'zinc_custom'      => ['bahan' => 'zinc',      'label' => 'Zinc: ukuran khusus (custom)'],
    ];

    public static function bahan(): array
    {
        return config('katalog_vesca.bahan', []);
    }

    public static function seri(): array
    {
        return config('katalog_vesca.seri', []);
    }

    public static function sertifikat(): array
    {
        return config('katalog_vesca.sertifikat', []);
    }

    /** Semua kode seri yang boleh dipilih (katalog + custom). */
    public static function kodeSeriValid(): array
    {
        return array_merge(array_keys(self::seri()), array_keys(self::CUSTOM));
    }

    public static function labelBahan(string $bahan): string
    {
        return config("katalog_vesca.bahan.{$bahan}.nama", ucfirst($bahan));
    }

    /** Contoh: "Aluminium Anode: Tipe Las (Ship Hull Welding)" */
    public static function labelSeri(?string $kode): string
    {
        if (!$kode) {
            return '-';
        }

        if (isset(self::CUSTOM[$kode])) {
            return self::CUSTOM[$kode]['label'];
        }

        $seri = self::seri()[$kode] ?? null;

        if (!$seri) {
            return $kode;
        }

        return self::labelBahan($seri['bahan']) . ': ' . $seri['nama'];
    }

    public static function bahanDariSeri(string $kode): ?string
    {
        if (isset(self::CUSTOM[$kode])) {
            return self::CUSTOM[$kode]['bahan'];
        }

        return self::seri()[$kode]['bahan'] ?? null;
    }

    /**
     * Cari satu tipe di dalam seri.
     * Hasil: ['kode', 'ringkas', 'berat_nett' (float|null)] atau null.
     */
    public static function cariTipe(string $kodeSeri, string $kodeTipe): ?array
    {
        $seri = self::seri()[$kodeSeri] ?? null;

        if (!$seri) {
            return null;
        }

        foreach ($seri['baris'] as $baris) {

            if (strcasecmp($baris[0], trim($kodeTipe)) === 0) {

                return self::bentukTipe($seri, $baris);
            }
        }

        return null;
    }

    /**
     * Data ringan untuk dropdown di formulir (dikirim ke JavaScript).
     * [kodeSeri => ['bahan', 'label', 'custom', 'tipe' => [['kode','ringkas'], ...]]]
     */
    public static function untukDropdown(): array
    {
        $hasil = [];

        foreach (self::seri() as $kode => $seri) {

            $tipe = [];

            foreach ($seri['baris'] as $baris) {

                $data = self::bentukTipe($seri, $baris);

                $tipe[] = ['kode' => $data['kode'], 'ringkas' => $data['ringkas']];
            }

            $hasil[$kode] = [
                'bahan'  => $seri['bahan'],
                'label'  => self::labelSeri($kode),
                'custom' => false,
                'tipe'   => $tipe,
            ];
        }

        foreach (self::CUSTOM as $kode => $info) {

            $hasil[$kode] = [
                'bahan'  => $info['bahan'],
                'label'  => $info['label'],
                'custom' => true,
                'tipe'   => [],
            ];
        }

        return $hasil;
    }

    /** Daftar seri untuk pilihan "produk yang diminati" (tanpa custom). */
    public static function daftarSeri(): array
    {
        $hasil = [];

        foreach (self::seri() as $kode => $seri) {

            $hasil[$kode] = self::labelSeri($kode);
        }

        return $hasil;
    }

    // ==================================================================
    //  DATA PRODUK UNTUK HALAMAN WEB (daftar produk, detail, pencarian)
    // ==================================================================

    /** Format angka berat: 1.20 -> "1.2", 30.0 -> "30" */
    public static function formatAngka(float $nilai): string
    {
        return rtrim(rtrim(number_format($nilai, 2, '.', ''), '0'), '.');
    }

    /**
     * Satu produk = satu seri di katalog. Hasil sudah dilengkapi data turunan:
     * jumlah tipe, rentang berat, daftar URL foto, dan nama bahan.
     */
    public static function produk(): array
    {
        $hasil = [];

        foreach (self::seri() as $kode => $seri) {

            $berat = [];

            foreach ($seri['baris'] as $baris) {

                $nilai = $baris[$seri['berat_idx']] ?? null;

                if (is_numeric($nilai)) {
                    $berat[] = (float) $nilai;
                }
            }

            $galeri = array_map(
                fn ($f) => '/image/produk/' . $f,
                $seri['gambar'] ?? []
            );

            $hasil[$kode] = [
                'key'         => $kode,
                'slug'        => $seri['slug'] ?? str_replace('_', '-', $kode),
                'bahan'       => $seri['bahan'],
                'bahan_nama'  => self::labelBahan($seri['bahan']),
                'bentuk'      => $seri['bentuk'] ?? '',
                'nama'        => $seri['judul'] ?? $seri['nama'],
                'subjudul'    => $seri['subjudul'] ?? '',
                'ringkas'     => $seri['ringkas'] ?? ($seri['deskripsi'] ?? ''),
                'kegunaan'    => $seri['kegunaan'] ?? [],
                'foto'        => $galeri[0] ?? null,
                'galeri'      => $galeri,
                'jumlah_tipe' => count($seri['baris']),
                'berat_min'   => $berat ? min($berat) : null,
                'berat_max'   => $berat ? max($berat) : null,
                'berat_label' => $berat
                    ? self::formatAngka(min($berat)) . ' – ' . self::formatAngka(max($berat)) . ' kg'
                    : null,
                'seri'        => $seri,
            ];
        }

        return $hasil;
    }

    public static function produkBySlug(string $slug): ?array
    {
        foreach (self::produk() as $item) {

            if ($item['slug'] === $slug) {
                return $item;
            }
        }

        return null;
    }

    /** Daftar produk, boleh difilter bahan (aluminium / zinc) dan kata kunci. */
    public static function daftarProduk(?string $bahan = null, ?string $cari = null): array
    {
        $hasil = self::produk();

        if ($bahan) {
            $hasil = array_filter($hasil, fn ($p) => $p['bahan'] === $bahan);
        }

        $cari = trim((string) $cari);

        if ($cari !== '') {

            $kunci = self::normal($cari);

            $hasil = array_filter($hasil, function ($p) use ($kunci) {

                if (str_contains(self::normal($p['nama'] . ' ' . $p['subjudul'] . ' ' . $p['bahan_nama']), $kunci)) {
                    return true;
                }

                foreach ($p['seri']['baris'] as $baris) {

                    if (str_contains(self::normal($baris[0]), $kunci)) {
                        return true;
                    }
                }

                return false;
            });
        }

        return array_values($hasil);
    }

    /** Produk untuk beranda. */
    public static function unggulan(int $jumlah = 2): array
    {
        $prioritas = ['zinc_las', 'aluminium_las', 'zinc_baut', 'aluminium_baut'];
        $semua     = self::produk();
        $hasil     = [];

        foreach ($prioritas as $kode) {

            if (isset($semua[$kode])) {
                $hasil[] = $semua[$kode];
            }
        }

        return array_slice($hasil, 0, $jumlah);
    }

    /**
     * Rekomendasi produk lain: yang sama bentuknya tapi beda bahan dulu
     * (misal Zinc Las -> Aluminium Las), lalu yang sama bahan.
     */
    public static function rekomendasi(string $kode, int $jumlah = 4): array
    {
        $semua = self::produk();
        $ini   = $semua[$kode] ?? null;

        if (!$ini) {
            return array_slice(array_values($semua), 0, $jumlah);
        }

        $urut = [];

        foreach ($semua as $k => $p) {

            if ($k === $kode) {
                continue;
            }

            $skor = 0;

            if ($p['bentuk'] === $ini['bentuk'] && $p['bahan'] !== $ini['bahan']) {
                $skor = 3;
            } elseif ($p['bahan'] === $ini['bahan']) {
                $skor = 2;
            } else {
                $skor = 1;
            }

            $urut[] = ['skor' => $skor, 'p' => $p];
        }

        usort($urut, fn ($a, $b) => $b['skor'] <=> $a['skor']);

        return array_map(fn ($x) => $x['p'], array_slice($urut, 0, $jumlah));
    }

    /**
     * Pencarian cepat di navbar. Mengembalikan seri dan tipe yang cocok.
     * [['label' => ..., 'slug' => ..., 'tipe' => ...|null], ...]
     */
    public static function cariCepat(string $kata, int $batas = 8): array
    {
        $kunci = self::normal($kata);

        if ($kunci === '') {
            return [];
        }

        $hasil = [];

        foreach (self::produk() as $p) {

            if (str_contains(self::normal($p['nama'] . ' ' . $p['subjudul']), $kunci)) {

                $hasil[] = ['label' => $p['nama'], 'slug' => $p['slug'], 'tipe' => null];
            }

            foreach ($p['seri']['baris'] as $baris) {

                if (str_contains(self::normal($baris[0]), $kunci)) {

                    $kodeNormal = self::normal($baris[0]);

                    $hasil[] = [
                        'label' => $baris[0] . ' · ' . $p['nama'],
                        'slug'  => $p['slug'],
                        'tipe'  => $baris[0],
                        'skor'  => $kodeNormal === $kunci ? 2 : (str_starts_with($kodeNormal, $kunci) ? 1 : 0),
                    ];
                }
            }
        }

        // hasil yang kodenya sama persis / diawali kata kunci tampil lebih dulu
        usort($hasil, fn ($a, $b) => ($b['skor'] ?? 1) <=> ($a['skor'] ?? 1));

        return array_slice($hasil, 0, $batas);
    }

    /** Huruf kecil tanpa spasi / tanda baca, supaya "av 320" cocok dengan "AV-320". */
    protected static function normal(string $teks): string
    {
        return preg_replace('/[^a-z0-9]+/', '', strtolower($teks));
    }

    // ==================================================================
    //  WHATSAPP
    // ==================================================================

    /** 0812-1205-1709 -> 6281212051709 */
    public static function nomorWa(?string $nomor): string
    {
        $angka = preg_replace('/\D+/', '', (string) $nomor);

        if ($angka === '') {
            return '';
        }

        if (str_starts_with($angka, '0')) {
            return '62' . substr($angka, 1);
        }

        if (str_starts_with($angka, '8')) {
            return '62' . $angka;
        }

        return $angka;
    }

    /** Tautan wa.me dengan pesan awal. Kosong jika nomor belum diatur. */
    public static function linkWa(string $pesan, ?string $nomor = null): string
    {
        $tujuan = self::nomorWa($nomor ?: config('vesca.whatsapp'));

        if ($tujuan === '') {
            return '';
        }

        return 'https://wa.me/' . $tujuan . '?text=' . rawurlencode($pesan);
    }

    // ------------------------------------------------------------------

    protected static function bentukTipe(array $seri, array $baris): array
    {
        $potongan = [];

        foreach (($seri['format'] ?? []) as $i => $pola) {

            $nilai = $baris[$i + 1] ?? null;

            if ($nilai !== null && $nilai !== '') {

                $potongan[] = sprintf($pola, $nilai);
            }
        }

        $berat = $baris[$seri['berat_idx']] ?? null;

        return [
            'kode'       => $baris[0],
            'ringkas'    => implode(', ', $potongan),
            'berat_nett' => is_numeric($berat) ? (float) $berat : null,
        ];
    }
}
