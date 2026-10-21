<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class StatusTracking extends Model
{
    protected $table = 'status_tracking';

    protected $primaryKey = 'id_status_tracking';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'nama_status',
        'urutan'
    ];

    public function trackingPesanan()
    {
        return $this->hasMany(
            TrackingPesanan::class,
            'id_status_tracking'
        );
    }
}