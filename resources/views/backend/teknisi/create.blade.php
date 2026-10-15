@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/teknisi.css') }}">

<div class="page-header">

    <h1>Tambah Teknisi</h1>

</div>

@if ($errors->any())

    <div class="alert-danger">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form action="{{ route('teknisi.store') }}"
      method="POST">

    @csrf

    <div class="card-form">

        <h3>Informasi Teknisi</h3>

        <div class="form-group">

            <label>Nama Teknisi</label>

            <input type="text"
                   name="nama_teknisi"
                   value="{{ old('nama_teknisi') }}"
                   required>

        </div>

        <div class="form-group">

            <label>Email</label>

            <input type="email"
                   name="email"
                   value="{{ old('email') }}">

        </div>

        <div class="form-group">

            <label>Nomor Telepon</label>

            <input type="text"
                   name="nomor_telepon"
                   value="{{ old('nomor_telepon') }}">

        </div>

        <div class="form-group">

            <label>Status Teknisi</label>

            <select name="status_teknisi">

                <option value="aktif">
                    Aktif
                </option>

                <option value="nonaktif">
                    Nonaktif
                </option>

            </select>

        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('teknisi.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Simpan Teknisi

        </button>

    </div>

</form>

@endsection