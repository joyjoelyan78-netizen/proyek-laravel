@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/pesanan.css') }}">

<div class="page-header">
    <h1>Edit Pesanan</h1>
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

<form action="{{ route('pesanan.update', $pesanan->id_pesanan) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Pesanan</h3>

        <div class="form-group">

            <label>Customer</label>

            <select name="id_customer" required>

                <option value="">
                    -- Pilih Customer --
                </option>

                @foreach($customer as $item)

                <option value="{{ $item->id_customer }}"
                    {{ $pesanan->id_customer == $item->id_customer ? 'selected' : '' }}>

                    {{ $item->nama_customer }}

                </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label>Nomor Invoice</label>

            <input type="text"
                   name="nomor_invoice"
                   value="{{ old('nomor_invoice', $pesanan->nomor_invoice) }}"
                   required>

        </div>

        <div class="form-group">

            <label>Tanggal Order</label>

            <input type="date"
                   name="tanggal_order"
                   value="{{ old('tanggal_order', \Carbon\Carbon::parse($pesanan->tanggal_order)->format('Y-m-d')) }}">

        </div>

        <div class="form-group">

            <label>Estimasi Selesai</label>

            <input type="date"
                   name="estimasi_selesai"
                   value="{{ old('estimasi_selesai', $pesanan->estimasi_selesai) }}">

        </div>

        <div class="form-group">

            <label>Status Pesanan</label>

            <select name="status_pesanan">

                <option value="pending"
                    {{ $pesanan->status_pesanan == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="diproses"
                    {{ $pesanan->status_pesanan == 'diproses' ? 'selected' : '' }}>
                    Diproses
                </option>

                <option value="selesai"
                    {{ $pesanan->status_pesanan == 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>

                <option value="dikirim"
                    {{ $pesanan->status_pesanan == 'dikirim' ? 'selected' : '' }}>
                    Dikirim
                </option>

                <option value="diterima"
                    {{ $pesanan->status_pesanan == 'diterima' ? 'selected' : '' }}>
                    Diterima
                </option>

                <option value="dibatalkan"
                    {{ $pesanan->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>
                    Dibatalkan
                </option>

            </select>

        </div>

        <div class="form-group">

            <label>Catatan</label>

            <textarea name="catatan"
                      rows="5">{{ old('catatan', $pesanan->catatan) }}</textarea>

        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('pesanan.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Update Pesanan

        </button>

    </div>

</form>

@endsection