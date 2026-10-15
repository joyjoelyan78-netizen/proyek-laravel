@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/activity-log.css') }}">


    <h3>Informasi Log</h3>

    <div class="form-group">

        <label>User</label>

        <input type="text"
               value="{{ $log->user->nama ?? '-' }}"
               readonly>

    </div>

    <div class="form-group">

        <label>Aktivitas</label>

        <textarea readonly>{{ $log->aktivitas }}</textarea>

    </div>

    <div class="form-group">

        <label>Tabel Terkait</label>

        <input type="text"
               value="{{ $log->tabel_terkait }}"
               readonly>

    </div>

    <div class="form-group">

        <label>ID Data</label>

        <input type="text"
               value="{{ $log->id_data }}"
               readonly>

    </div>

    <div class="form-group">

        <label>IP Address</label>

        <input type="text"
               value="{{ $log->ip_address }}"
               readonly>

    </div>

    <div class="form-group">

        <label>Tanggal</label>

        <input type="text"
               value="{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}"
               readonly>

    </div>

    <div class="form-footer">

        <a href="{{ route('activity-log.index') }}"
           class="btn-back">

            Kembali

        </a>

    </div>

</div>

@endsection