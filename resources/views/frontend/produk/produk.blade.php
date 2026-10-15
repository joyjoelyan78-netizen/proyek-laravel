@extends('layouts.frontend')

@section('content')

<link rel="stylesheet"
href="/css/produk_cus.css">

<section class="detail-produk">

    <div class="container">

        <div class="detail-wrapper">

            <div class="detail-gambar">

                @if($produk->gambar_produk)

                    <img
                        src="/storage/{{ $produk->gambar_produk }}"
                        alt="{{ $produk->nama_produk }}"
                    >

                @endif

            </div>

            <div class="detail-info">

                <span class="kategori">

                    {{ $produk->kategori->nama_kategori ?? '-' }}

                </span>

                <h1>{{ $produk->nama_produk }}</h1>

                <p>

                    {{ $produk->deskripsi }}

                </p>

                <table class="spesifikasi">

                    <tr>
                        <td>Seri Produk</td>
                        <td>{{ $produk->seri_produk }}</td>
                    </tr>

                    <tr>
                        <td>Berat</td>
                        <td>{{ $produk->berat }} Kg</td>
                    </tr>

                    <tr>
                        <td>Dimensi</td>
                        <td>{{ $produk->dimensi }}</td>
                    </tr>

                    <tr>
                        <td>Standar Kualitas</td>
                        <td>{{ $produk->standar_kualitas }}</td>
                    </tr>

                    <tr>
                        <td>Garansi</td>
                        <td>{{ $produk->masa_garansi_bulan }} Bulan</td>
                    </tr>

                </table>

                @if($produk->link_whatsapp)

                    <a
                        href="{{ $produk->link_whatsapp }}"
                        target="_blank"
                        class="btn-wa"
                    >
                        Hubungi Kami
                    </a>

                @endif

            </div>

        </div>

    </div>

</section>

@endsection