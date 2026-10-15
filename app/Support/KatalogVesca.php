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
