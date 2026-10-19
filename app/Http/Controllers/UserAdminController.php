<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| PENGELOLAAN AKUN ADMIN (khusus Super Admin)
|--------------------------------------------------------------------------
| Akun yang dibuat di sini adalah staf admin: bisa mengelola permintaan
| penawaran dan konsultasi, tetapi tidak bisa mengelola akun lain.
| Akun Super Admin dilindungi (tidak bisa diubah / dihapus lewat halaman ini).
*/

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('id_user')->get();

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|max:100',
        ], [
            'email.unique'  => 'Email ini sudah dipakai akun lain.',
            'password.min'  => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'nama'     => $data['nama'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('Super Admin')) {

            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun Super Admin tidak dapat diubah dari halaman ini.');
        }

        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('Super Admin')) {

            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun Super Admin tidak dapat diubah dari halaman ini.');
        }

        $data = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|string|min:8|max:100',
        ], [
            'email.unique' => 'Email ini sudah dipakai akun lain.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->nama  = $data['nama'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('Super Admin')) {

            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

        if ((int) $user->id_user === (int) Auth::id()) {

            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak bisa menghapus akun yang sedang dipakai.');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }
}
