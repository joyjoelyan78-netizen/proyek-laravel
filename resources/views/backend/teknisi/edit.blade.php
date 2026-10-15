@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/teknisi.css') }}">

<div class="page-header">

    <h1>Edit Teknisi</h1>

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

<form action="{{ route('teknisi.update', $teknisi->id_teknisi) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Teknisi</h3>

        <div class="form-group">

            <label>Nama Teknisi</label>

            <input type="text"
                   name="nama_teknisi"
                   value="{{ old('nama_teknisi', $teknisi->nama_teknisi) }}"
                   required>

        </div>

        <div class="form-group">

            <label>Email</label>

            <input type="email"
                   name="email"
                   value="{{ old('email', $teknisi->email) }}">

        </div>

        <div class="form-group">

            <label>Nomor Telepon</label>

            <input type="text"
                   name="nomor_telepon"
                   value="{{ old('nomor_telepon', $teknisi->nomor_telepon) }}">

        </div>

        <div class="form-group">

            <label>Status Teknisi</label>

            <select name="status_teknisi">

                <option value="aktif"
                    {{ $teknisi->status_teknisi == 'aktif' ? 'selected' : '' }}>

                    Aktif

                </option>

                <option value="nonaktif"
                    {{ $teknisi->status_teknisi == 'nonaktif' ? 'selected' : '' }}>

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

            Update Teknisi

        </button>

    </div>

</form>

@endsection