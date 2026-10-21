<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Permission extends Model
{
    protected $primaryKey = 'id_permission';

    use LogsActivity;

    protected $fillable = [
        'nama_permission',
        'grup'
    ];
}
