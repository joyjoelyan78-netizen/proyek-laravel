@extends('layouts.frontend')

@section('content')

<section class="pesanan-page">

    <div class="pesanan-wrapper">

        <!-- HEADER -->
        <div class="pesanan-header">

            <div class="pesanan-icon">
                <i class="fas fa-receipt"></i>
            </div>

            <h1>Cek Pesanan</h1>

            <p>
                Masukkan nomor invoice yang Anda terima
                setelah konfirmasi pembayaran
            </p>

        </div>

        <!-- FORM -->
        <div class="pesanan-form-box">

            <form action="" method="GET">

                <label>Nomor Invoice</label>

                <div class="input-group">

                    <i class="fas fa-list"></i>

                    <input
                        type="text"
                        name="invoice"
                        placeholder="INV 2025 XXXX"
                    >

                </div>

                <button type="submit">
                    Cari Pesanan
                </button>

            </form>

        </div>

    </div>

</section>

@endsection