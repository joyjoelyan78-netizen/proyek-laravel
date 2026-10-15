@extends('layouts.backend')

@section('content')

<div class="page-header">

    <h1>Edit Kapal</h1>

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

<form action="{{ route('kapal.update', $kapal->id_kapal) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Kapal</h3>

        <div class="form-group">

            <label>Nama Kapal</label>

            <input type="text"
                   name="nama_kapal"
                   value="{{ old('nama_kapal', $kapal->nama_kapal) }}"
                   required>

        </div>

        <div class="form-group">

            <label>Jenis Kapal</label>

            <input type="text"
                   name="jenis_kapal"
                   value="{{ old('jenis_kapal', $kapal->jenis_kapal) }}"
                   required>

        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('kapal.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button class="btn-primary">

            Update Kapal

        </button>

    </div>

</form>

@endsection