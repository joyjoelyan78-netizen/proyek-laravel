@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/verifikasi-garansi.css') }}">

<div class="page-header">

    <h1>Edit Verifikasi Garansi</h1>

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

<form action="{{ route('verifikasi-garansi.update', $verifikasi->id_verifikasi) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Verifikasi</h3>

        <label>Klaim Garansi</label>

        <select name="id_klaim">

            @foreach($klaim as $item)

                <option value="{{ $item->id_klaim }}"
                    {{ $verifikasi->id_klaim == $item->id_klaim ? 'selected' : '' }}>

                    {{ $item->customer->nama_customer ?? '-' }}
                    -
                    {{ $item->produk->nama_produk ?? '-' }}

                </option>

            @endforeach

        </select>

        <label>Teknisi</label>

        <select name="id_teknisi">

            @foreach($teknisi as $item)

                <option value="{{ $item->id_teknisi }}"
                    {{ $verifikasi->id_teknisi == $item->id_teknisi ? 'selected' : '' }}>

                    {{ $item->nama_teknisi }}

                </option>

            @endforeach

        </select>

        <label>Garansi Mulai</label>

        <input type="date"
               name="garansi_mulai"
               value="{{ $verifikasi->garansi_mulai }}">

                <label>Status Verifikasi</label>

                <select name="status_verifikasi">

                    <option value="valid"
                        {{ $verifikasi->status_verifikasi == 'valid' ? 'selected' : '' }}>
                        Valid
                    </option>

                    <option value="tidak_valid"
                        {{ $verifikasi->status_verifikasi == 'tidak_valid' ? 'selected' : '' }}>
                        Tidak Valid
                    </option>

                </select>

                <hr style="margin:30px 0;">

                <h3>Jadwal Kunjungan Teknisi</h3>

                <label>Tanggal Kunjungan</label>

                <input type="date"
                    name="tanggal_kunjungan"
                    value="{{ $verifikasi->tanggal_kunjungan }}">

                <label>Jam Kunjungan</label>

                <input type="time"
                    name="jam_kunjungan"
                    value="{{ $verifikasi->jam_kunjungan }}">

                <label>Status Kunjungan</label>

                <select name="status_kunjungan">

                    <option value="menunggu"
                        {{ $verifikasi->status_kunjungan == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>

                    <option value="dijadwalkan"
                        {{ $verifikasi->status_kunjungan == 'dijadwalkan' ? 'selected' : '' }}>
                        Dijadwalkan
                    </option>

                    <option value="proses"
                        {{ $verifikasi->status_kunjungan == 'proses' ? 'selected' : '' }}>
                        Proses
                    </option>

                    <option value="selesai"
                        {{ $verifikasi->status_kunjungan == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>

                <label>Hasil Pemeriksaan</label>

                <textarea name="hasil_pemeriksaan"
                        rows="5">{{ $verifikasi->hasil_pemeriksaan }}</textarea>

                <label>Catatan Verifikasi</label>

                <textarea name="catatan_verifikasi">{{ $verifikasi->catatan_verifikasi }}</textarea>

    </div>

    <div class="form-footer">

        <a href="{{ route('verifikasi-garansi.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button class="btn-primary">

            Update Verifikasi

        </button>

    </div>

</form>

@endsection