<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'kode_produk',
        'nama_produk',
        'seri_produk',
        'slug',
        'deskripsi',
        'catatan_ppn',
        'berat',
        'dimensi',
        'standar_kualitas',
        'lingkungan_operasi',
        'tanggal_produksi',
        'masa_garansi_bulan',
        'komposisi_material',
        'gambar_produk',
        'link_whatsapp',
        'status_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(
            KategoriProduk::class,
            'id_kategori',
            'id_kategori'
        );
    }
}