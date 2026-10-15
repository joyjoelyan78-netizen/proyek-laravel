@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/detail-pesanan.css') }}">

<div class="page-header">

    <h1>Edit Detail Pesanan</h1>

</div>

<form action="{{ route('detail-pesanan.update', $detail->id_detail) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Detail Pesanan</h3>

        <div class="form-group">

            <label>Invoice</label>

            <select name="id_pesanan">

                @foreach($pesanan as $p)

                <option value="{{ $p->id_pesanan }}"
                    {{ $detail->id_pesanan == $p->id_pesanan ? 'selected' : '' }}>

                    {{ $p->nomor_invoice }}

                </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label>Produk</label>

            <select name="id_produk">

                @foreach($produk as $p)

                <option value="{{ $p->id_produk }}"
                    {{ $detail->id_produk == $p->id_produk ? 'selected' : '' }}>

                    {{ $p->nama_produk }}

                </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label>Qty</label>

            <input type="number"
                   name="qty"
                   value="{{ $detail->qty }}">

        </div>

        <div class="form-group">

            <label>Harga</label>

            <input type="number"
                   name="harga"
                   value="{{ $detail->harga }}">

        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('detail-pesanan.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Update Detail

        </button>

    </div>

</form>

@endsection