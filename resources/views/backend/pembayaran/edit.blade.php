@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/pembayaran.css') }}">

<div class="page-header">
    <h1>Edit Pembayaran</h1>
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

<form action="{{ route('pembayaran.update',$pembayaran->id_pembayaran) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Pembayaran</h3>

        <div class="form-group">

            <label>Pesanan / Invoice</label>

            <select name="id_pesanan" required>

                @foreach($pesanan as $p)

                <option value="{{ $p->id_pesanan }}"
                    {{ $pembayaran->id_pesanan == $p->id_pesanan ? 'selected' : '' }}>

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
                   value="{{ old('nominal', $pembayaran->nominal) }}">

        </div>

        <div class="form-group">

            <label>Metode Pembayaran</label>

            <input type="text"
                   name="metode_pembayaran"
                   value="{{ old('metode_pembayaran', $pembayaran->metode_pembayaran) }}">

        </div>

        <div class="form-group">

            <label>Status Pembayaran</label>

            <select name="status_pembayaran">

                <option value="belum_bayar"
                    {{ $pembayaran->status_pembayaran == 'belum_bayar' ? 'selected' : '' }}>
                    Belum Bayar
                </option>

                <option value="dp"
                    {{ $pembayaran->status_pembayaran == 'dp' ? 'selected' : '' }}>
                    DP
                </option>

                <option value="lunas"
                    {{ $pembayaran->status_pembayaran == 'lunas' ? 'selected' : '' }}>
                    Lunas
                </option>

            </select>

        </div>

        <div class="form-group">

            <label>Tanggal Pembayaran</label>

            <input type="datetime-local"
                   name="tanggal_pembayaran"
                   value="{{ $pembayaran->tanggal_pembayaran ? \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('Y-m-d\TH:i') : '' }}">

        </div>

        <div class="form-group">

            <label>Bukti Transfer</label>

            <input type="file"
                   name="bukti_transfer">

            @if($pembayaran->bukti_transfer)

            <div class="preview-image">

                <img
                    src="{{ asset('storage/'.$pembayaran->bukti_transfer) }}"
                    alt="Bukti Transfer">

            </div>

            @endif

        </div>

        <div class="form-group">

            <label>Catatan</label>

            <textarea name="catatan">{{ old('catatan', $pembayaran->catatan) }}</textarea>

        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('pembayaran.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Update Pembayaran

        </button>

    </div>

</form>

@endsection