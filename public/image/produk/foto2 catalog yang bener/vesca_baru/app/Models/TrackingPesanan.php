<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;


class TrackingPesanan extends Model
{
    protected $table = 'tracking_pesanan';

    protected $primaryKey = 'id_tracking';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_status_tracking',
        'id_user_update',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'estimasi_selesai',
        'deskripsi',
        'pic'
    ];

    public function getRouteKeyName()
    {
        return 'id_tracking';
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function statusTracking()
    {
        return $this->belongsTo(
            StatusTracking::class,
            'id_status_tracking'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user_update'
        );
    }
}