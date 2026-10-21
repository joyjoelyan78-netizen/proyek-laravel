<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view(
            'backend.permissions.index',
            compact('roles', 'permissions')
        );
    }

    public function toggle(Request $request)
    {
        $exists = DB::table('role_permissions')
            ->where('role_id', $request->role_id)
            ->where('permission_id', $request->permission_id)
            ->exists();

        if ($exists) {

            DB::table('role_permissions')
                ->where('role_id', $request->role_id)
                ->where('permission_id', $request->permission_id)
                ->delete();

        } else {

            DB::table('role_permissions')
                ->insert([
                    'role_id' => $request->role_id,
                    'permission_id' => $request->permission_id,
                ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
}