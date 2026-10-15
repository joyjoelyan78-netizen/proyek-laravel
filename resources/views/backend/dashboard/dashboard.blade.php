@extends('layouts.backend')

@section('content')



<link rel="stylesheet"
href="{{ asset('css/dashboard.css') }}">


<div class="dashboard-header">
    <div>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang kembali, {{ auth()->user()->nama }}</p>
    </div>
</div>

<div class="dashboard-grid">

    <div class="card-dashboard">
        <div class="card-icon blue">
            <i class="ri-box-3-line"></i>
        </div>
        <div>
            <h3>Total Produk</h3>
            <h2>{{ \App\Models\Produk::count() }}</h2>
        </div>
    </div>

    <div class="card-dashboard">
        <div class="card-icon green">
            <i class="ri-group-line"></i>
        </div>
        <div>
            <h3>Total Customer</h3>
            <h2>{{ \App\Models\Customer::count() }}</h2>
        </div>
    </div>

    <div class="card-dashboard">
        <div class="card-icon orange">
            <i class="ri-file-list-3-line"></i>
        </div>
        <div>
            <h3>Total Pesanan</h3>
            <h2>{{ \App\Models\Pesanan::count() }}</h2>
        </div>
    </div>

    <div class="card-dashboard">
        <div class="card-icon red">
            <i class="ri-tools-line"></i>
        </div>
        <div>
            <h3>Klaim Garansi</h3>
            <h2>{{ \App\Models\KlaimGaransi::count() }}</h2>
        </div>
    </div>

    {{-- Card khusus klaim pending --}}
    @php $klaimPending = \App\Models\KlaimGaransi::where('status_klaim', 'pending')->count(); @endphp
    @if($klaimPending > 0)
    <div class="card-dashboard" style="border-left: 4px solid #e74c3c;">
        <div class="card-icon red">
            <i class="ri-alarm-warning-line"></i>
        </div>
        <div>
            <h3>Klaim Menunggu</h3>
            <h2>{{ $klaimPending }}</h2>
            <a href="/admin/klaim-garansi" class="btn-see-all">
                Lihat Semua
                <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>
    @endif

</div>

{{-- Tabel notif klaim pending terbaru --}}
@php
    $klaimBaru = \App\Models\KlaimGaransi::with(['serial.produk', 'tiket'])
        ->where('status_klaim', 'pending')
        ->latest()
        ->take(5)
        ->get();
@endphp

@if($klaimBaru->count() > 0)
<div class="dashboard-content" style="margin-top: 24px;">
    <div class="dashboard-box" style="width: 100%;">

        <div class="box-header" style="display:flex; justify-content:space-between; align-items:center;">
            <h3>
                <i class="ri-alarm-warning-line" style="color:#e74c3c;"></i>
                Klaim Garansi Menunggu Verifikasi
                <span style="
                    background:#e74c3c;
                    color:#fff;
                    font-size:11px;
                    padding:2px 8px;
                    border-radius:999px;
                    margin-left:6px;
                ">{{ $klaimBaru->count() }}</span>
            </h3>
            <a href="/admin/klaim-garansi" class="btn-see-all">
                Lihat Semua
                <i class="ri-arrow-right-line"></i>
            </a>
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:13px; margin-top:12px;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:10px; text-align:left; border-bottom:1px solid #eee;">Nama Pembeli</th>
                    <th style="padding:10px; text-align:left; border-bottom:1px solid #eee;">Produk</th>
                    <th style="padding:10px; text-align:left; border-bottom:1px solid #eee;">No. Tiket</th>
                    <th style="padding:10px; text-align:left; border-bottom:1px solid #eee;">Tanggal Klaim</th>
                    <th style="padding:10px; text-align:left; border-bottom:1px solid #eee;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($klaimBaru as $item)
                <tr style="border-bottom:1px solid #f0f0f0;">
                    <td style="padding:10px;">{{ $item->nama_pembeli }}</td>
                    <td style="padding:10px;">{{ $item->serial->produk->nama_produk ?? '-' }}</td>
                    <td style="padding:10px;">{{ $item->tiket->nomor_tiket ?? '-' }}</td>
                    <td style="padding:10px;">{{ \Carbon\Carbon::parse($item->tanggal_klaim)->format('d M Y') }}</td>
                    <td style="padding:10px;">
                        <a href="{{ route('klaim-garansi.detail', $item->id_klaim) }}" style="
                            background:#3498db;
                            color:#fff;
                            padding:5px 12px;
                            border-radius:6px;
                            font-size:12px;
                            text-decoration:none;
                        ">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endif

<div class="dashboard-content">

    <div class="dashboard-box">
        <div class="box-header">
            <h3>Informasi Login</h3>
        </div>
        <div class="info-user">
            <div class="info-item">
                <span>Nama</span>
                <strong>{{ auth()->user()->nama }}</strong>
            </div>
            <div class="info-item">
                <span>Email</span>
                <strong>{{ auth()->user()->email }}</strong>
            </div>
            <div class="info-item">
                <span>Status</span>
                <strong>{{ auth()->user()->status_user }}</strong>
            </div>
        </div>
    </div>

    <div class="dashboard-box">
        <div class="box-header">
            <h3>Quick Menu</h3>
        </div>
        <div class="quick-menu">
            <a href="/admin/produk" class="quick-btn">
                <i class="ri-box-3-line"></i>
                Produk
            </a>
            <a href="/admin/kategori-produk" class="quick-btn">
                <i class="ri-folder-line"></i>
                Kategori
            </a>
            <a href="/admin/pesanan" class="quick-btn">
                <i class="ri-file-list-3-line"></i>
                Pesanan
            </a>
            <a href="/admin/customer" class="quick-btn">
                <i class="ri-group-line"></i>
                Customer
            </a>
        </div>
    </div>

</div>

@endsection