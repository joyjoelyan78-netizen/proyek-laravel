<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class TiketTeknisi extends Model
{
    protected $table = 'tiket_teknisi';

    protected $primaryKey = 'id_tiket';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'id_klaim',
        'nomor_tiket',
        'id_teknisi',
        'estimasi_kunjungan',
        'status_tiket',
        'created_at'
    ];

    public function klaim()
    {
        return $this->belongsTo(
            KlaimGaransi::class,
            'id_klaim'
        );
    }

    public function teknisi()
    {
        return $this->belongsTo(
            Teknisi::class,
            'id_teknisi'
        );
    }
}