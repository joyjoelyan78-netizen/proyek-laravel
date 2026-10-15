@extends('layouts.frontend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/lacak-pesanan.css') }}">

<div class="tracking-page">

    <div class="tracking-card">

        <div class="tracking-header">

            <h2>Cek Pesanan</h2>

            <p>
                Masukkan nomor invoice Anda
            </p>

        </div>

        @if(session('error'))

            <div class="alert-error">

                {{ session('error') }}

            </div>

        @endif

        <form action="{{ route('lacak-pesanan.cari') }}"
              method="POST">

            @csrf

            <label>
                Nomor Invoice
            </label>

            <input type="text"
                   name="nomor_invoice"
                   placeholder="INV-2026-0001"
                   required>

            <button type="submit">

                Cari Pesanan

            </button>

        </form>

    </div>

</div>

@endsection