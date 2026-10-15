<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $primaryKey = 'id_pembayaran';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_user_input',
        'nominal',
        'metode_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
        'bukti_transfer',
        'catatan',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class,'id_pesanan');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user_input');
    }
}