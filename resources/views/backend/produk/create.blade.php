@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/admin_produk.css') }}">

<div class="page-header">
    <h1>Tambah Produk</h1>
</div>

@if ($errors->any())

    <div class="alert alert-danger">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form action="/admin/produk"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="card-form">

        <h3>Informasi Produk</h3>

        <label>Kode Produk</label>
        <input type="text"
               name="kode_produk"
               required>

        <label>Nama Produk</label>
        <input type="text"
               name="nama_produk"
               required>

        <label>Seri Produk</label>
        <input type="text"
               name="seri_produk">

        <label>Kategori Produk</label>

        <select name="id_kategori" required>

            <option value="">
                -- Pilih Kategori --
            </option>

            @foreach($kategori as $k)

                <option value="{{ $k->id_kategori }}">
                    {{ $k->nama_kategori }}
                </option>

            @endforeach

        </select>

        <label>Deskripsi</label>
        <textarea name="deskripsi"></textarea>

    </div>

    <div class="card-form">

        <h3>Spesifikasi Produk</h3>

        <label>Berat (Kg)</label>
        <input type="number"
               step="0.01"
               name="berat">

        <label>Dimensi</label>
        <input type="text"
               name="dimensi">

        <label>Standar Kualitas</label>
        <input type="text"
               name="standar_kualitas">

        <label>Lingkungan Operasi</label>
        <textarea name="lingkungan_operasi"></textarea>

        <label>Komposisi Material</label>
        <textarea name="komposisi_material"></textarea>

    </div>

    <div class="card-form">

        <h3>Produksi & Garansi</h3>

        <label>Tanggal Produksi</label>
        <input type="date"
               name="tanggal_produksi">

        <label>Masa Garansi (Bulan)</label>
        <input type="number"
               name="masa_garansi_bulan">

        <label>Catatan PPN</label>
        <input type="text"
               name="catatan_ppn">

        <label>Link WhatsApp</label>
        <input type="text"
               name="link_whatsapp">

    </div>

    <div class="card-form">

        <h3>Media Produk</h3>

        <label>Gambar Produk</label>
        <input type="file"
               name="gambar_produk">

        <label>Status Produk</label>

        <select name="status_produk">

            <option value="aktif">
                Aktif
            </option>

            <option value="nonaktif">
                Nonaktif
            </option>

        </select>

    </div>

    <div class="form-footer">

    <a href="/admin/produk"
       class="btn-back">
        Kembali
    </a>

    <button type="submit"
            class="btn-primary">
        Simpan Produk
    </button>

</div>

</form>

@endsection