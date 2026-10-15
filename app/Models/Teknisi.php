<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Teknisi extends Model
{
    protected $table = 'teknisi';

    protected $primaryKey = 'id_teknisi';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'nama_teknisi',
        'email',
        'nomor_telepon',
        'status_teknisi',
    ];
}