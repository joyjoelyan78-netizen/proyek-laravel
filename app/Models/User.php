<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'id_user';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // ================= RELASI ROLE =================

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_user',
            'id_user',
            'id_role'
        );
    }

    // ================= CHECK ROLE =================

    public function hasRole($roleName)
    {
        return $this->roles()
            ->where('nama_role', $roleName)
            ->exists();
    }

    public function hasPermission($permission)
    {
        // SUPER ADMIN AUTO ALL ACCESS
        if ($this->hasRole('Super Admin')) {
            return true;
        }

        foreach ($this->roles as $role) {

            if (
                $role->permissions()
                    ->where('nama_permission', $permission)
                    ->exists()
            ) {
                return true;
            }
        }

        return false;
    }
}