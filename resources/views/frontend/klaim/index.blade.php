@extends('layouts.frontend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/garansi.css') }}">

<div class="garansi-page">

    <!-- CARD -->
    <div class="garansi-wrapper">

        <!-- TOP -->
        <div class="garansi-header">

            <div class="icon-box">

                <i class="fas fa-shield-alt"></i>

            </div>

            <h2>Cek Garansi</h2>

            <p>Masukkan Kode pada Produk</p>

        </div>

        <!-- FORM -->
        <div class="garansi-form-box">

            <form
                action="{{ route('klaim.garansi.cek') }}"
                method="POST"
            >

                @csrf

                <label>
                    Kode Unik
                </label>

                <div class="input-group">

                    <i class="fas fa-barcode"></i>

                    <input
                        type="text"
                        name="kode_unik"
                        placeholder="ENV - 2025 - xxxxx"
                        required
                    >

                </div>

                <button type="submit">

                    Konfirmasi

                </button>

            </form>

        </div>

    </div>

</div>

@endsection