<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id_role';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'nama_role',
        'deskripsi'
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'role_user',
            'id_role',
            'id_user'
        );
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }
}