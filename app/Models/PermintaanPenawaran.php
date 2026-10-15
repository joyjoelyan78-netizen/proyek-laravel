<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class PermintaanPenawaran extends Model
{
    use LogsActivity;

    protected $table = 'permintaan_penawaran';

    protected $primaryKey = 'id_penawaran';

    protected $fillable = [
        'nomor_permintaan',
        'nama_pemohon',
        'nama_perusahaan',
        'email',
        'nomor_telepon',
        'id_produk',
        'rincian_item',
        'jenis_produk',
        'tipe_ukuran',
        'jumlah',
        'satuan',
        'jenis_kapal',
        'lokasi_pengiriman',
        'tanggal_dibutuhkan',
        'file_lampiran',
        'catatan',
        'status',
        'catatan_admin',
        'id_user_proses',
    ];

    protected $casts = [
        'tanggal_dibutuhkan' => 'date',
        'rincian_item'       => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | DAFTAR PILIHAN
    |--------------------------------------------------------------------------
    */

    public const STATUS = [
        'baru'               => 'Baru',
        'diproses'           => 'Diproses',
        'penawaran_terkirim' => 'Penawaran Terkirim',
        'selesai'            => 'Selesai',
        'dibatalkan'         => 'Dibatalkan',
    ];

    // warna badge: [latar, teks]
    public const STATUS_WARNA = [
        'baru'               => ['#fff3cd', '#856404'],
        'diproses'           => ['#cce5ff', '#004085'],
        'penawaran_terkirim' => ['#d1ecf1', '#0c5460'],
        'selesai'            => ['#d4edda', '#155724'],
        'dibatalkan'         => ['#f8d7da', '#721c24'],
    ];

    public const JENIS_PRODUK = [
        'zinc'       => 'Zinc Anode',
        'aluminium'  => 'Aluminium Anode',
        'campuran'   => 'Zinc dan Aluminium',
        'belum_tahu' => 'Belum tahu / ingin disarankan',
    ];

    public const SATUAN = ['pcs', 'kg', 'set'];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function userProses()
    {
        return $this->belongsTo(User::class, 'id_user_proses', 'id_user');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusWarnaAttribute(): array
    {
        return self::STATUS_WARNA[$this->status] ?? ['#e2e3e5', '#383d41'];
    }

    public function getWhatsappLinkAttribute(): string
    {
        $nomor = preg_replace('/\D+/', '', (string) $this->nomor_telepon);

        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        return 'https://wa.me/' . $nomor;
    }

    /** Ringkasan satu baris untuk tabel admin, contoh: "AV-320 x10, S-3 x5". */
    public function getRingkasanItemAttribute(): string
    {
        $item = $this->rincian_item;

        if (!is_array($item) || empty($item)) {
            return $this->tipe_ukuran ?: '-';
        }

        return collect($item)
            ->map(fn ($i) => ($i['tipe'] ?? '?') . ' x' . ($i['jumlah'] ?? '?'))
            ->implode(', ');
    }

    /** Estimasi berat nett total (kg) dari item katalog; null jika tidak ada datanya. */
    public function getEstimasiBeratAttribute(): ?float
    {
        $item = $this->rincian_item;

        if (!is_array($item)) {
            return null;
        }

        $total = 0.0;
        $ada   = false;

        foreach ($item as $i) {

            if (isset($i['berat_nett']) && is_numeric($i['berat_nett'])) {

                $total += $i['berat_nett'] * (int) ($i['jumlah'] ?? 0);
                $ada = true;
            }
        }

        return $ada ? $total : null;
    }

    public function getJenisProdukLabelAttribute(): string
    {
        return self::JENIS_PRODUK[$this->jenis_produk] ?? $this->jenis_produk;
    }

    /*
    |--------------------------------------------------------------------------
    | BUAT DATA + NOMOR (PNW-2026-0001)
    |--------------------------------------------------------------------------
    | Nomor dibuat dari nomor terakhir di tahun berjalan. Jika dua pengunjung
    | mengirim di detik yang sama dan nomornya bentrok (kolom unique), dicoba
    | lagi sampai 3 kali.
    */

    public static function buatDenganNomor(array $data): self
    {
        $percobaan = 0;

        while (true) {

            $percobaan++;

            $data['nomor_permintaan'] = self::nomorBerikutnya();

            try {

                return self::create($data);

            } catch (QueryException $e) {

                $duplikat = ($e->errorInfo[1] ?? null) == 1062;

                if (!$duplikat || $percobaan >= 3) {
                    throw $e;
                }
            }
        }
    }

    protected static function nomorBerikutnya(): string
    {
        $tahun  = now()->format('Y');
        $prefix = "PNW-{$tahun}-";

        $terakhir = self::where('nomor_permintaan', 'like', $prefix . '%')
            ->orderByDesc('id_penawaran')
            ->value('nomor_permintaan');

        $urut = $terakhir ? ((int) substr($terakhir, -4)) + 1 : 1;

        return $prefix . str_pad((string) $urut, 4, '0', STR_PAD_LEFT);
    }
}
