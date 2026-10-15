@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/pembayaran.css') }}">

<div class="page-header">
    <h1>Tambah Pembayaran</h1>
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

<form action="{{ route('pembayaran.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <div class="card-form">

        <h3>Informasi Pembayaran</h3>

        <div class="form-group">
            <label>Pesanan / Invoice</label>

            <select name="id_pesanan" required>

                <option value="">
                    -- Pilih Invoice --
                </option>

                @foreach($pesanan as $p)

                <option value="{{ $p->id_pesanan }}">
                    {{ $p->nomor_invoice }}
                    -
                    {{ $p->customer->nama_customer }}
                </option>

                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Nominal Pembayaran</label>

            <input type="number"
                   name="nominal"
                   required>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>

            <input type="text"
                   name="metode_pembayaran">
        </div>

        <div class="form-group">
            <label>Status Pembayaran</label>

            <select name="status_pembayaran">

                <option value="belum_bayar">
                    Belum Bayar
                </option>

                <option value="dp">
                    DP
                </option>

                <option value="lunas">
                    Lunas
                </option>

            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Pembayaran</label>

            <input type="datetime-local"
                   name="tanggal_pembayaran">
        </div>

        <div class="form-group">
            <label>Bukti Transfer</label>

            <input type="file"
                   name="bukti_transfer">
        </div>

        <div class="form-group">
            <label>Catatan</label>

            <textarea name="catatan"></textarea>
        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('pembayaran.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Simpan Pembayaran

        </button>

    </div>

</form>

@endsection