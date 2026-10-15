@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/pesanan.css') }}">

<div class="page-header">

    <h1>Tambah Pesanan</h1>

</div>

<form action="{{ route('pesanan.store') }}"
      method="POST">

    @csrf

    <div class="card-form">

        <h3>Informasi Pesanan</h3>

        <div class="form-group">

            <label>Customer</label>

            <select name="id_customer" required>

                <option value="">
                    -- Pilih Customer --
                </option>

                @foreach($customer as $c)

                    <option value="{{ $c->id_customer }}">

                        {{ $c->nama_customer }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label>Nomor Invoice</label>

            <input type="text"
                value="Otomatis Generate Sistem"
                disabled>

        </div>

        <div class="form-group">

            <label>Tanggal Order</label>

            <input type="datetime-local"
                   name="tanggal_order">

        </div>

        <div class="form-group">

            <label>Estimasi Selesai</label>

            <input type="date"
                   name="estimasi_selesai">

        </div>

        <div class="form-group">

            <label>Status Pesanan</label>

            <select name="status_pesanan">

                <option value="diproses">
                    Diproses
                </option>

                <option value="selesai">
                    Selesai
                </option>

                <option value="dikirim">
                    Dikirim
                </option>

                <option value="diterima">
                    Diterima
                </option>

            </select>

        </div>

        <div class="form-group">

            <label>Catatan</label>

            <textarea name="catatan"></textarea>

        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('pesanan.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Simpan Pesanan

        </button>

    </div>

</form>

@endsection