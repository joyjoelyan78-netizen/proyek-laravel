@extends('layouts.backend')

@section('content')

<div class="page-header">

    <h1>Tambah Tiket Teknisi</h1>

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

<form action="{{ route('tiket-teknisi.store') }}"
      method="POST">

    @csrf

    <div class="card-form">

        <h3>Informasi Tiket</h3>

        <label>Klaim Garansi</label>

        <select name="id_klaim" required>

            <option value="">
                -- Pilih Klaim --
            </option>

            @foreach($klaim as $item)

                <option value="{{ $item->id_klaim }}">

                    {{ $item->customer->nama_customer ?? '-' }}
                    -
                    {{ $item->produk->nama_produk ?? '-' }}

                </option>

            @endforeach

        </select>

        <label>Nomor Tiket</label>

        <input type="text"
               name="nomor_tiket"
               required>

        <label>Teknisi</label>

        <select name="id_teknisi">

            <option value="">
                -- Pilih Teknisi --
            </option>

            @foreach($teknisi as $item)

                <option value="{{ $item->id_teknisi }}">

                    {{ $item->nama_teknisi }}

                </option>

            @endforeach

        </select>

        <label>Estimasi Kunjungan</label>

        <input type="datetime-local"
               name="estimasi_kunjungan">

        <label>Status Tiket</label>

        <select name="status_tiket">

            <option value="diterima">
                Diterima
            </option>

            <option value="penjadwalan">
                Penjadwalan
            </option>

            <option value="kunjungan">
                Kunjungan
            </option>

            <option value="verifikasi">
                Verifikasi
            </option>

        </select>

    </div>

    <div class="form-footer">

        <a href="{{ route('tiket-teknisi.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button class="btn-primary">

            Simpan Tiket

        </button>

    </div>

</form>

@endsection