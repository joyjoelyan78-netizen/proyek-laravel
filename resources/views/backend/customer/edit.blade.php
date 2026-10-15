@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/customer.css') }}">

<div class="page-header">

    <h1>Edit Customer</h1>

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

<form action="{{ route('customer.update', $customer->id_customer) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="card-form">

        <h3>Informasi Customer</h3>

        <div class="form-group">

            <label>Nama Customer</label>

            <input type="text"
                   name="nama_customer"
                   value="{{ old('nama_customer', $customer->nama_customer) }}"
                   required>

        </div>

        <div class="form-group">

            <label>Email</label>

            <input type="email"
                   name="email"
                   value="{{ old('email', $customer->email) }}">

        </div>

        <div class="form-group">

            <label>Nomor Telepon</label>

            <input type="text"
                   name="nomor_telepon"
                   value="{{ old('nomor_telepon', $customer->nomor_telepon) }}">

        </div>

        <div class="form-group">

            <label>Alamat</label>

            <textarea name="alamat">{{ old('alamat', $customer->alamat) }}</textarea>

        </div>

    </div>

    <div class="form-footer">

        <a href="{{ route('customer.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Update Customer

        </button>

    </div>

</form>

@endsection