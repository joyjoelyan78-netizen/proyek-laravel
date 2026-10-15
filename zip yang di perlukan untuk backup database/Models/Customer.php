<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Customer extends Model
{
    protected $table = 'customer';

    protected $primaryKey = 'id_customer';

    public $timestamps = false;

    use LogsActivity;

    protected $fillable = [
        'nama_customer',
        'email',
        'nomor_telepon',
        'alamat'
    ];
    
}