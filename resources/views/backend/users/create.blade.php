@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/user-admin.css') }}">

<div class="page-header">

    <h1>Tambah User</h1>

</div>

<div class="card-table">

    <form action="/admin/users" method="POST">

        @csrf

        <div class="form-group">

            <label>Nama User</label>

            <input type="text"
                   name="nama"
                   placeholder="Masukkan nama user"
                   required>

        </div>

        <div class="form-group">

            <label>Email</label>

            <input type="email"
                   name="email"
                   placeholder="Masukkan email"
                   required>

        </div>

        <div class="form-group">

            <label>Password</label>

            <input type="password"
                   name="password"
                   placeholder="Masukkan password"
                   required>

        </div>

        <div class="form-group">

            <label>Role</label>

            <select name="id_role" required>

                <option value="">
                    -- Pilih Role --
                </option>

                @foreach($roles as $role)

                    <option value="{{ $role->id_role }}">

                        {{ $role->nama_role }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-footer">

            <a href="/admin/users"
               class="btn-back">

                Kembali

            </a>

            <button type="submit"
                    class="btn-primary">

                Simpan User

            </button>

        </div>

    </form>

</div>

@endsection