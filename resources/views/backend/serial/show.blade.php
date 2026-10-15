@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/serial-produk.css') }}">

<h1 class="page-title">

    Detail Serial Produk

</h1>

<div class="card-form">

    <h3>Informasi Serial</h3>

    <table class="table-detail">

        <tr>

            <td width="250">
                Kode Serial
            </td>

            <td>
                <strong>
                    {{ $serial->kode_unik }}
                </strong>
            </td>

        </tr>

        <tr>

            <td>Invoice</td>

            <td>

                {{ $serial->pesanan->nomor_invoice ?? '-' }}

            </td>

        </tr>

        <tr>

            <td>Produk</td>

            <td>

                {{ $serial->produk->nama_produk ?? '-' }}

            </td>

        </tr>

        <tr>

            <td>Customer</td>

            <td>

                {{ $serial->customer->nama_customer ?? '-' }}

            </td>

        </tr>

        <tr>

            <td>Status Aktivasi</td>

            <td>

                {{ $serial->status_aktivasi }}

            </td>

        </tr>

        <tr>

            <td>Status Klaim</td>

            <td>

                {{ $serial->status_klaim }}

            </td>

        </tr>

        <tr>

            <td>Status Garansi</td>

            <td>

                {{ $serial->status_garansi }}

            </td>

        </tr>

        <tr>

            <td>Masa Berlaku Sampai</td>

            <td>

                {{ $serial->masa_berlaku_sampai ?? '-' }}

            </td>

        </tr>

    </table>

</div>

@if($serial->produk)

<div class="card-form">

    <h3>Informasi Produk</h3>

    <table class="table-detail">

        <tr>

            <td width="250">
                Nama Produk
            </td>

            <td>

                {{ $serial->produk->nama_produk }}

            </td>

        </tr>

        <tr>

            <td>Kategori</td>

            <td>

                {{ $serial->produk->kategori->nama_kategori ?? '-' }}

            </td>

        </tr>

        <tr>

            <td>Deskripsi</td>

            <td>

                {{ $serial->produk->deskripsi ?? '-' }}

            </td>

        </tr>

    </table>

</div>

@endif

<div class="form-footer">

    <a href="{{ route('serial-produk.index') }}"
       class="btn-back">

        Kembali

    </a>

</div>

@endsection