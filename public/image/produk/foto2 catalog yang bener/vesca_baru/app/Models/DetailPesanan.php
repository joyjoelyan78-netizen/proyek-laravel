<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $primaryKey = 'id_detail';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [

        'id_pesanan',

        'id_produk',

        'qty',

        'berat_per_unit',

        'total_berat',

        'harga',

        'subtotal'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI PESANAN
    |--------------------------------------------------------------------------
    */

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PRODUK
    |--------------------------------------------------------------------------
    */

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk'
        );
    }
}