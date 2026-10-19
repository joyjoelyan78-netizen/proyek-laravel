@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="/css/user-admin.css">

<div class="page-header">
    <h1>Edit Akun Admin</h1>
</div>

<div class="card-table">

    @if ($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label>Password baru</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak diganti">
        </div>

        <div class="form-footer">
            <a href="{{ route('admin.users.index') }}" class="btn-back">Kembali</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>

    </form>

</div>

@endsection
