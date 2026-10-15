@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/tracking-pesanan.css') }}">

<div class="page-header">
    <h1>Tambah Tracking</h1>
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

<form action="{{ route('tracking-pesanan.store') }}"
      method="POST">

    @csrf

    <div class="card-form">

        <h3>Informasi Tracking</h3>

        <div class="form-group">
            <label>Pesanan / Invoice</label>
            <select name="id_pesanan" required>
                <option value="">-- Pilih Invoice --</option>

                @foreach($pesanan as $p)
                <option value="{{ $p->id_pesanan }}">
                    {{ $p->nomor_invoice }}
                </option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Status Tracking</label>

            <select name="id_status_tracking" required>

                <option value="">
                    -- Pilih Status --
                </option>

                @foreach($statusTracking as $s)

                <option value="{{ $s->id_status_tracking }}">
                    {{ $s->nama_status }}
                </option>

                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label>Status</label>

            <select name="status">

                <option value="menunggu">Menunggu</option>
                <option value="berlangsung">Berlangsung</option>
                <option value="selesai">Selesai</option>

            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Mulai</label>

            <input type="datetime-local"
                   name="tanggal_mulai">
        </div>

        <div class="form-group">
            <label>Tanggal Selesai</label>

            <input type="datetime-local"
                   name="tanggal_selesai">
        </div>

        <div class="form-group">
            <label>Estimasi Selesai</label>

            <input type="datetime-local"
                   name="estimasi_selesai">
        </div>

        <div class="form-group">
            <label>PIC</label>

            <input type="text"
                   name="pic">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>

            <textarea name="deskripsi"></textarea>
        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('tracking-pesanan.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button class="btn-primary">
            Simpan Tracking
        </button>

    </div>

</form>

@endsection