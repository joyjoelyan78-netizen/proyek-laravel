@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/role-user.css') }}">

<div class="page-header">
    <h1>Edit Role</h1>
</div>

<div class="card-table">

    <form action="/admin/roles/{{ $role->id_role }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">

            <label>Nama Role</label>

            <input type="text"
                   name="nama_role"
                   value="{{ $role->nama_role }}"
                   required>

        </div>

        <div class="form-group">

            <label>Deskripsi Role</label>

            <textarea
                name="deskripsi"
            >{{ $role->deskripsi }}</textarea>

        </div>

        <div class="form-footer">

            <a href="/admin/roles"
            class="btn-back">

                Kembali

            </a>

            <button type="submit"
                    class="btn-primary">

                Update Role

            </button>

        </div>

    </form>

</div>

@endsection