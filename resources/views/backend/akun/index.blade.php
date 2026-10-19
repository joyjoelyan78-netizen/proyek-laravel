@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="/css/user-admin.css">

<div class="page-header">
    <h1>Akun Saya</h1>
</div>

<div class="card-table" style="max-width:560px;">

    <p style="margin:0 0 20px;font-size:14px;color:#475569;">
        Masuk sebagai <strong>{{ auth()->user()->nama }}</strong> ({{ auth()->user()->email }})
    </p>

    @if (session('status') === 'password-updated')
        <div style="background:#d4edda;color:#155724;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">
            Password berhasil diganti.
        </div>
    @endif

    @if ($errors->updatePassword->any())
        <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">
            {{ $errors->updatePassword->first() }}
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Password saat ini</label>
            <input type="password" name="current_password" required autocomplete="current-password">
        </div>

        <div class="form-group">
            <label>Password baru</label>
            <input type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
        </div>

        <div class="form-group">
            <label>Ulangi password baru</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="form-footer">
            <a href="{{ route('admin.dashboard') }}" class="btn-back">Kembali</a>
            <button type="submit" class="btn-primary">Ganti Password</button>
        </div>

    </form>

</div>

@endsection
