<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class UploadFoto extends Model
{
    protected $table = 'upload_foto';

    protected $primaryKey = 'id_foto';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        
        'id_klaim',
        'file_foto',
    ];
}