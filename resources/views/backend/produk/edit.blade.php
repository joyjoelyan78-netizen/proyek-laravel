@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin_produk.css') }}">

<div class="page-header">
    <h1>Edit Produk</h1>
</div>

@if ($errors->any())
<div class="alert-danger-custom">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="/admin/produk/{{ $produk->id_produk }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Produk</h3>

        <label>Kode Produk</label>
        <input type="text"
               name="kode_produk"
               value="{{ old('kode_produk', $produk->kode_produk) }}"
               required>

        <label>Nama Produk</label>
        <input type="text"
               name="nama_produk"
               value="{{ old('nama_produk', $produk->nama_produk) }}"
               required>

        <label>Seri Produk</label>
        <input type="text"
               name="seri_produk"
               value="{{ old('seri_produk', $produk->seri_produk) }}">

        <label>Kategori Produk</label>
        <select name="id_kategori" required>

            @foreach($kategori as $k)

                <option value="{{ $k->id_kategori }}"
                    {{ $produk->id_kategori == $k->id_kategori ? 'selected' : '' }}>

                    {{ $k->nama_kategori }}

                </option>

            @endforeach

        </select>

        <label>Deskripsi</label>
        <textarea name="deskripsi">{{ old('deskripsi', $produk->deskripsi) }}</textarea>

    </div>

    <div class="card-form">

        <h3>Spesifikasi Produk</h3>

        <label>Berat (Kg)</label>
        <input type="number"
               step="0.01"
               name="berat"
               value="{{ old('berat', $produk->berat) }}">

        <label>Dimensi</label>
        <input type="text"
               name="dimensi"
               value="{{ old('dimensi', $produk->dimensi) }}">

        <label>Standar Kualitas</label>
        <input type="text"
               name="standar_kualitas"
               value="{{ old('standar_kualitas', $produk->standar_kualitas) }}">

        <label>Lingkungan Operasi</label>
        <textarea name="lingkungan_operasi">{{ old('lingkungan_operasi', $produk->lingkungan_operasi) }}</textarea>

        <label>Komposisi Material</label>
        <textarea name="komposisi_material">{{ old('komposisi_material', $produk->komposisi_material) }}</textarea>

    </div>

    <div class="card-form">

        <h3>Produksi & Garansi</h3>

        <label>Tanggal Produksi</label>
        <input type="date"
               name="tanggal_produksi"
               value="{{ old('tanggal_produksi', $produk->tanggal_produksi) }}">

        <label>Masa Garansi (Bulan)</label>
        <input type="number"
               name="masa_garansi_bulan"
               value="{{ old('masa_garansi_bulan', $produk->masa_garansi_bulan) }}">

        <label>Catatan PPN</label>
        <input type="text"
               name="catatan_ppn"
               value="{{ old('catatan_ppn', $produk->catatan_ppn) }}">

        <label>Link WhatsApp</label>
        <input type="text"
               name="link_whatsapp"
               value="{{ old('link_whatsapp', $produk->link_whatsapp) }}">

    </div>

    <div class="card-form">

        <h3>Media Produk</h3>

        <label>Gambar Produk</label>
        <input type="file" name="gambar_produk">

        @if($produk->gambar_produk)

            <img
                src="{{ asset('storage/'.$produk->gambar_produk) }}"
                alt="{{ $produk->nama_produk }}"
                class="product-preview">

        @endif

        <label>Status Produk</label>

        <select name="status_produk">

            <option value="aktif"
                {{ $produk->status_produk == 'aktif' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="nonaktif"
                {{ $produk->status_produk == 'nonaktif' ? 'selected' : '' }}>
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
            Update Produk
        </button>

    </div>

</form>

@endsection