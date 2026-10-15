<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class SerialProduk extends Model
{
    protected $table = 'serial_produk';

    protected $primaryKey = 'id_serial';
    
    use LogsActivity;

    protected $fillable = [

        'id_produk',
        'id_customer',
        'id_pesanan',
        'id_detail_pesanan',
        'kode_unik',

        'status_aktivasi',
        'status_klaim',
        'status_garansi',

        'masa_berlaku_sampai',
    ];

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk'
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            Customer::class,
            'id_customer'
        );
    }

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan'
        );
    }

    public function detailPesanan()
    {
        return $this->belongsTo(
            DetailPesanan::class,
            'id_detail_pesanan'
        );
    }
}