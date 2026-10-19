@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="/css/user-admin.css">

<div class="page-header">
    <h1>Tambah Akun Admin</h1>
</div>

<div class="card-table">

    @if ($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">

        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email untuk login" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Minimal 8 karakter" required>
        </div>

        <p style="font-size:13px;color:#64748b;margin:0 0 18px;">
            Akun baru berperan sebagai Staf Admin: bisa mengelola permintaan penawaran
            dan konsultasi, tetapi tidak bisa mengelola akun lain.
        </p>

        <div class="form-footer">
            <a href="{{ route('admin.users.index') }}" class="btn-back">Kembali</a>
            <button type="submit" class="btn-primary">Simpan Akun</button>
        </div>

    </form>

</div>

@endsection
