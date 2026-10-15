@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/kategori-produk.css') }}">

<div class="page-header">
    <h1>Tambah Kategori</h1>
</div>

<form action="/admin/kategori-produk"
      method="POST">

    @csrf

    <div class="card-form">

        <h3>Informasi Kategori</h3>

        <label>Nama Kategori</label>

        <input type="text"
               name="nama_kategori"
               required>

        <label>Deskripsi</label>

        <textarea name="deskripsi"></textarea>

        <div class="form-footer">

            <a href="/admin/kategori-produk"
               class="btn-back">
                Kembali
            </a>

            <button type="submit"
                    class="btn-primary">
                Simpan
            </button>

        </div>

    </div>

</form>

@endsection