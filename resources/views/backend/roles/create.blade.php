@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/role-user.css') }}">

<div class="page-header">
    <h1>Tambah Role</h1>
</div>

<div class="card-table">

    <form action="/admin/roles" method="POST">

        @csrf

        <div class="form-group">

            <label>Nama Role</label>

            <input type="text"
                   name="nama_role"
                   placeholder="Contoh: Super Admin"
                   required>

        </div>

        <div class="form-group">

            <label>Deskripsi Role</label>

            <textarea
                name="deskripsi"
                placeholder="Masukkan deskripsi role..."
            ></textarea>

        </div>

        <div class="form-footer">

            <a href="/admin/roles"
            class="btn-back">

                Kembali

            </a>

            <button type="submit"
                    class="btn-primary">

                Simpan Role

            </button>

        </div>

    </form>

</div>

@endsection