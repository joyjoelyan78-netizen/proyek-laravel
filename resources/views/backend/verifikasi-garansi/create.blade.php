@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/verifikasi-garansi.css') }}">

<div class="page-header">
    <h1>Tambah Verifikasi Garansi</h1>
</div>

{{-- ERROR --}}
@if ($errors->any())

<div style="
    background:#f8d7da;
    color:#721c24;
    padding:15px 20px;
    border-radius:10px;
    margin-bottom:20px;
">

    <strong>Terjadi Kesalahan:</strong>

    <ul style="margin-top:10px; padding-left:20px;">

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

<form action="{{ route('verifikasi-garansi.store') }}"
      method="POST">

    @csrf

    <div class="card-form">

        <h3 style="margin-bottom:25px;">
            Informasi Verifikasi Garansi
        </h3>

        {{-- PILIH KLAIM --}}
        <div class="form-group">

            <label>Klaim Garansi</label>

            <select name="id_klaim" required>

                <option value="">
                    -- Pilih Klaim Disetujui --
                </option>

                @foreach($klaim as $item)

                    <option value="{{ $item->id_klaim }}"
                        {{ old('id_klaim') == $item->id_klaim ? 'selected' : '' }}>

                        {{ $item->customer->nama_customer ?? '-' }}
                        -
                        {{ $item->serial->kode_unik ?? '-' }}
                        -
                        {{ $item->serial->produk->nama_produk ?? '-' }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- TEKNISI --}}
        <div class="form-group">

            <label>Teknisi</label>

            <select name="id_teknisi" required>

                <option value="">
                    -- Pilih Teknisi --
                </option>

                @foreach($teknisi as $item)

                    <option value="{{ $item->id_teknisi }}"
                        {{ old('id_teknisi') == $item->id_teknisi ? 'selected' : '' }}>

                        {{ $item->nama_teknisi }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- GARANSI MULAI --}}
        <div class="form-group">

            <label>Garansi Mulai</label>

            <input type="date"
                   name="garansi_mulai"
                   value="{{ old('garansi_mulai', date('Y-m-d')) }}"
                   required>

        </div>



        {{-- JADWAL KUNJUNGAN --}}
        <hr style="margin:30px 0;">

        <h3 style="margin-bottom:20px;">
            Jadwal Kunjungan Teknisi
        </h3>

        {{-- TANGGAL --}}
        <div class="form-group">

            <label>Tanggal Kunjungan</label>

            <input type="date"
                   name="tanggal_kunjungan"
                   value="{{ old('tanggal_kunjungan') }}">

        </div>

        {{-- JAM --}}
        <div class="form-group">

            <label>Jam Kunjungan</label>

            <input type="time"
                   name="jam_kunjungan"
                   value="{{ old('jam_kunjungan') }}">

        </div>

        {{-- STATUS KUNJUNGAN --}}
        <div class="form-group">

            <label>Status Kunjungan</label>

            <select name="status_kunjungan">

                <option value="menunggu">
                    Menunggu
                </option>

                <option value="dijadwalkan">
                    Dijadwalkan
                </option>

                <option value="proses">
                    Proses
                </option>

                <option value="selesai">
                    Selesai
                </option>

            </select>

        </div>

        {{-- CATATAN --}}
        <div class="form-group">

            <label>Catatan Verifikasi</label>

            <textarea name="catatan_verifikasi"
                      rows="5"
                      placeholder="Masukkan catatan verifikasi...">{{ old('catatan_verifikasi') }}</textarea>

        </div>

    </div>

    {{-- FOOTER --}}
    <div class="form-footer"
         style="margin-top:25px; display:flex; gap:12px;">

        <a href="{{ route('verifikasi-garansi.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Simpan Verifikasi

        </button>

    </div>

</form>

@endsection