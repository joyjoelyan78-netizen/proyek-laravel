<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use App\Models\VerifikasiGaransi;


class KlaimGaransi extends Model
{
    protected $table = 'klaim_garansi';

    protected $primaryKey = 'id_klaim';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'id_serial',
        'id_customer',
        'id_produk',
        'nama_pembeli',
        'email',
        'nomor_telepon',
        'judul_keluhan',
        'deskripsi_keluhan',
        'status_klaim',
        'tanggal_klaim',
        // pastikan 'id_kapal' sudah tidak ada di sini
    ];

    public function customer()
    {
        return $this->belongsTo(
            Customer::class,
            'id_customer'
        );
    }

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk'
        );
    }

    public function tiket()
    {
        return $this->hasOne(
            TiketTeknisi::class,
            'id_klaim',
            'id_klaim'
        );
    }

    public function serial()
    {
        return $this->belongsTo(
            SerialProduk::class,
            'id_serial',
            'id_serial'
        );
    }

    public function uploadFoto()
    {
        return $this->hasOne(UploadFoto::class, 'id_klaim', 'id_klaim');
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiGaransi::class, 'id_klaim', 'id_klaim');
    }
}