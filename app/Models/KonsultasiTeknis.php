<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class KonsultasiTeknis extends Model
{
    use LogsActivity;

    protected $table = 'konsultasi_teknis';

    protected $primaryKey = 'id_konsultasi';

    protected $fillable = [
        'nomor_konsultasi',
        'nama_pengirim',
        'nama_perusahaan',
        'email',
        'nomor_telepon',
        'id_produk',
        'produk_diminati',
        'jenis_kapal',
        'ukuran_kapal',
        'bagian_dilindungi',
        'kondisi_air',
        'pertanyaan',
        'status',
        'balasan_admin',
        'id_user_balas',
        'dibalas_pada',
    ];

    protected $casts = [
        'dibalas_pada' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | DAFTAR PILIHAN
    |--------------------------------------------------------------------------
    */

    public const STATUS = [
        'baru'    => 'Baru',
        'dibalas' => 'Sudah Dibalas',
        'selesai' => 'Selesai',
    ];

    // warna badge: [latar, teks]
    public const STATUS_WARNA = [
        'baru'    => ['#fff3cd', '#856404'],
        'dibalas' => ['#cce5ff', '#004085'],
        'selesai' => ['#d4edda', '#155724'],
    ];

    public const KONDISI_AIR = [
        'laut'       => 'Air laut',
        'payau'      => 'Air payau (campuran laut dan tawar)',
        'tawar'      => 'Air tawar (sungai / danau)',
        'belum_tahu' => 'Belum tahu',
    ];

    public const BAGIAN_DILINDUNGI = [
        'Lambung kapal',
        'Baling-baling dan poros',
        'Kemudi (rudder)',
        'Sea chest / saluran air laut',
        'Tangki ballast',
        'Struktur pelabuhan / dermaga',
        'Lainnya',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */


    public function userBalas()
    {
        return $this->belongsTo(User::class, 'id_user_balas', 'id_user');
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

    public function getProdukDiminatiLabelAttribute(): string
    {
        return $this->produk_diminati
            ? \App\Support\KatalogVesca::labelSeri($this->produk_diminati)
            : '-';
    }

    public function getKondisiAirLabelAttribute(): string
    {
        return self::KONDISI_AIR[$this->kondisi_air] ?? $this->kondisi_air;
    }

    /*
    |--------------------------------------------------------------------------
    | BUAT DATA + NOMOR (KST-2026-0001)
    |--------------------------------------------------------------------------
    */

    public static function buatDenganNomor(array $data): self
    {
        $percobaan = 0;

        while (true) {

            $percobaan++;

            $data['nomor_konsultasi'] = self::nomorBerikutnya();

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
        $prefix = "KST-{$tahun}-";

        $terakhir = self::where('nomor_konsultasi', 'like', $prefix . '%')
            ->orderByDesc('id_konsultasi')
            ->value('nomor_konsultasi');

        $urut = $terakhir ? ((int) substr($terakhir, -4)) + 1 : 1;

        return $prefix . str_pad((string) $urut, 4, '0', STR_PAD_LEFT);
    }
}
