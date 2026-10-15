@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/user-admin.css') }}">

<div class="page-header">

    <h1>Edit User</h1>

</div>

<div class="card-table">

    <form action="/admin/users/{{ $user->id_user }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">

            <label>Nama User</label>

            <input type="text"
                   name="nama"
                   value="{{ $user->nama }}"
                   required>

        </div>

        <div class="form-group">

            <label>Email</label>

            <input type="email"
                   name="email"
                   value="{{ $user->email }}"
                   required>

        </div>

        <div class="form-group">

            <label>Password Baru</label>

            <input type="password"
                   name="password"
                   placeholder="Kosongkan jika tidak diganti">

            <small class="text-secondary">
                Kosongkan password jika tidak ingin mengubah password.
            </small>

        </div>

        <div class="form-group">

            <label>Role</label>

            <select name="id_role" required>

                @foreach($roles as $role)

                    <option value="{{ $role->id_role }}"
                        {{ $user->roles->first()->id_role == $role->id_role ? 'selected' : '' }}>

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

                Update User

            </button>

        </div>

    </form>

</div>

@endsection