<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Kapal extends Model
{
    protected $table = 'kapal';

    protected $primaryKey = 'id_kapal';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'jenis_kapal',
        'nama_kapal'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];
}

