@extends('layouts.backend')

@section('content')

<div class="page-header">

    <h1>Edit Tiket Teknisi</h1>

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

<form action="{{ route('tiket-teknisi.update', $tiket->id_tiket) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Tiket</h3>

        <label>Klaim Garansi</label>

        <select name="id_klaim" required>

            @foreach($klaim as $item)

                <option value="{{ $item->id_klaim }}"
                    {{ $tiket->id_klaim == $item->id_klaim ? 'selected' : '' }}>

                    {{ $item->customer->nama_customer ?? '-' }}
                    -
                    {{ $item->produk->nama_produk ?? '-' }}

                </option>

            @endforeach

        </select>

        <label>Nomor Tiket</label>

        <input type="text"
               name="nomor_tiket"
               value="{{ $tiket->nomor_tiket }}"
               required>

        <label>Teknisi</label>

        <select name="id_teknisi">

            <option value="">
                -- Pilih Teknisi --
            </option>

            @foreach($teknisi as $item)

                <option value="{{ $item->id_teknisi }}"
                    {{ $tiket->id_teknisi == $item->id_teknisi ? 'selected' : '' }}>

                    {{ $item->nama_teknisi }}

                </option>

            @endforeach

        </select>

        <label>Estimasi Kunjungan</label>

        <input type="datetime-local"
               name="estimasi_kunjungan"
               value="{{ $tiket->estimasi_kunjungan ? \Carbon\Carbon::parse($tiket->estimasi_kunjungan)->format('Y-m-d\TH:i') : '' }}">

        <label>Status Tiket</label>

        <select name="status_tiket">

            <option value="diterima"
                {{ $tiket->status_tiket == 'diterima' ? 'selected' : '' }}>
                Diterima
            </option>

            <option value="penjadwalan"
                {{ $tiket->status_tiket == 'penjadwalan' ? 'selected' : '' }}>
                Penjadwalan
            </option>

            <option value="kunjungan"
                {{ $tiket->status_tiket == 'kunjungan' ? 'selected' : '' }}>
                Kunjungan
            </option>

            <option value="verifikasi"
                {{ $tiket->status_tiket == 'verifikasi' ? 'selected' : '' }}>
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

            Update Tiket

        </button>

    </div>

</form>

@endsection