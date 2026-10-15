@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/tracking-pesanan.css') }}">

<div class="page-header">

    <h1>Edit Tracking</h1>

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

<form action="{{ route('tracking-pesanan.update',$tracking->id_tracking) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Tracking</h3>

        <label>Pesanan / Invoice</label>

        <select name="id_pesanan">

            @foreach($pesanan as $p)

            <option value="{{ $p->id_pesanan }}"
                {{ $tracking->id_pesanan == $p->id_pesanan ? 'selected' : '' }}>

                {{ $p->nomor_invoice }}

            </option>

            @endforeach

        </select>

        <label>Status Tracking</label>

        <select name="id_status_tracking">

            @foreach($statusTracking as $s)

            <option value="{{ $s->id_status_tracking }}"
                {{ $tracking->id_status_tracking == $s->id_status_tracking ? 'selected' : '' }}>

                {{ $s->nama_status }}

            </option>

            @endforeach

        </select>

        <label>Status</label>

        <select name="status">

            <option value="menunggu"
                {{ $tracking->status == 'menunggu' ? 'selected' : '' }}>

                Menunggu

            </option>

            <option value="berlangsung"
                {{ $tracking->status == 'berlangsung' ? 'selected' : '' }}>

                Berlangsung

            </option>

            <option value="selesai"
                {{ $tracking->status == 'selesai' ? 'selected' : '' }}>

                Selesai

            </option>

        </select>

        <label>Tanggal Mulai</label>

        <input type="datetime-local"
               name="tanggal_mulai"
               value="{{ $tracking->tanggal_mulai ? \Carbon\Carbon::parse($tracking->tanggal_mulai)->format('Y-m-d\TH:i') : '' }}">

        <label>Tanggal Selesai</label>

        <input type="datetime-local"
               name="tanggal_selesai"
               value="{{ $tracking->tanggal_selesai ? \Carbon\Carbon::parse($tracking->tanggal_selesai)->format('Y-m-d\TH:i') : '' }}">

        <label>Estimasi Selesai</label>

        <input type="datetime-local"
               name="estimasi_selesai"
               value="{{ $tracking->estimasi_selesai ? \Carbon\Carbon::parse($tracking->estimasi_selesai)->format('Y-m-d\TH:i') : '' }}">

        <label>PIC</label>

        <input type="text"
               name="pic"
               value="{{ $tracking->pic }}">

        <label>Deskripsi</label>

        <textarea name="deskripsi">{{ $tracking->deskripsi }}</textarea>

    </div>

    <div class="form-footer">

        <a href="{{ route('tracking-pesanan.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button class="btn-primary">

            Update Tracking

        </button>

    </div>

</form>

@endsection