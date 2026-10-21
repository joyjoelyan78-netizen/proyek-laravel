<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    protected $primaryKey = 'id_kategori';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    public function produk()
    {
        return $this->hasMany(
            Produk::class,
            'id_kategori',
            'id_kategori'
        );
    }
}