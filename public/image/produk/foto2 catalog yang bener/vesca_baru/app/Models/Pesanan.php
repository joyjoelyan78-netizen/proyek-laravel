<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'id_pesanan';

    use LogsActivity;


    public $timestamps = false;

    protected $fillable = [
        'id_customer',
        'nomor_invoice',
        'tanggal_order',
        'estimasi_selesai',
        'progres_persen',
        'status_pesanan',
        'catatan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }

    public function trackingPesanan()
    {
        return $this->hasMany(
            TrackingPesanan::class,
            'id_pesanan'
        );
    }

    public function detailPesanan()
    {
        return $this->hasMany(
            DetailPesanan::class,
            'id_pesanan'
        );
    }
}