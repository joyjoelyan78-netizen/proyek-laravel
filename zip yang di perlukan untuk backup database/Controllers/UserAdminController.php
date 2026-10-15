<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('backend.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($request->id_role);

        return redirect('/admin/users');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // CEGAH EDIT SUPERADMIN
        if ($user->hasRole('superadmin')) {

            return redirect('/admin/users')
                ->with('error', 'Superadmin tidak dapat diedit.');
        }

        $roles = Role::all();

        return view('backend.users.edit', compact(
            'user',
            'roles'
        ));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // CEGAH UPDATE SUPERADMIN
        if ($user->hasRole('superadmin')) {

            return redirect('/admin/users')
                ->with('error', 'Superadmin tidak dapat diupdate.');
        }

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        if ($request->password) {

            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->roles()->sync([$request->id_role]);

        return redirect('/admin/users');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // CEGAH HAPUS SUPERADMIN
        if ($user->hasRole('superadmin')) {

            return redirect('/admin/users')
                ->with('error', 'Superadmin tidak dapat dihapus.');
        }

        $user->delete();

        return redirect('/admin/users');
    }
}