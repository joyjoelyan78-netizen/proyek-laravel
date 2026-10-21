<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('backend.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('backend.roles.create');
    }

    public function store(Request $request)
    {
        Role::create([
            'nama_role' => $request->nama_role,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/admin/roles');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('backend.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update([
            'nama_role' => $request->nama_role,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/admin/roles');
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return redirect('/admin/roles');
    }
}