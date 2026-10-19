@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="/css/admin-layanan.css">

<div class="dashboard-header">
    <div>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang kembali, {{ auth()->user()->nama }}</p>
    </div>
</div>


{{-- ================= RINGKASAN ================= --}}
<div class="dashboard-grid">

    <div class="card-dashboard" @if ($penawaranBaru > 0) style="border-left:4px solid #e74c3c;" @endif>
        <div class="card-icon orange"><i class="ri-file-paper-2-line"></i></div>
        <div>
            <h3>Penawaran Baru</h3>
            <h2>{{ $penawaranBaru }}</h2>
        </div>
    </div>

    <div class="card-dashboard">
        <div class="card-icon blue"><i class="ri-file-list-3-line"></i></div>
        <div>
            <h3>Total Permintaan Penawaran</h3>
            <h2>{{ $penawaranTotal }}</h2>
        </div>
    </div>

    <div class="card-dashboard" @if ($konsultasiBaru > 0) style="border-left:4px solid #e74c3c;" @endif>
        <div class="card-icon red"><i class="ri-customer-service-2-line"></i></div>
        <div>
            <h3>Konsultasi Baru</h3>
            <h2>{{ $konsultasiBaru }}</h2>
        </div>
    </div>

    <div class="card-dashboard">
        <div class="card-icon green"><i class="ri-chat-check-line"></i></div>
        <div>
            <h3>Total Konsultasi</h3>
            <h2>{{ $konsultasiTotal }}</h2>
        </div>
    </div>

</div>


{{-- ================= TERBARU ================= --}}
<div class="dashboard-content" style="margin-top:24px;">

    <div class="dashboard-box">

        <div class="box-header" style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Permintaan Penawaran Terbaru</h3>
            <a href="{{ route('admin.penawaran.index') }}" class="btn-see-all">
                Lihat Semua <i class="ri-arrow-right-line"></i>
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pemohon</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penawaranTerbaru as $item)
                    <tr>
                        <td><strong>{{ $item->nomor_permintaan }}</strong></td>
                        <td>
                            {{ $item->nama_pemohon }}
                            <span class="al-sub">{{ $item->ringkasan_item }}</span>
                        </td>
                        <td>
                            @php [$bg, $fg] = $item->status_warna; @endphp
                            <span class="al-badge" style="background:{{ $bg }}; color:{{ $fg }};">{{ $item->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.penawaran.show', $item->id_penawaran) }}" class="al-btn al-btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="al-empty">Belum ada permintaan penawaran.</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <div class="dashboard-box">

        <div class="box-header" style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Konsultasi Terbaru</h3>
            <a href="{{ route('admin.konsultasi.index') }}" class="btn-see-all">
                Lihat Semua <i class="ri-arrow-right-line"></i>
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pengirim</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($konsultasiTerbaru as $item)
                    <tr>
                        <td><strong>{{ $item->nomor_konsultasi }}</strong></td>
                        <td>
                            {{ $item->nama_pengirim }}
                            <span class="al-sub">{{ $item->jenis_kapal }}</span>
                        </td>
                        <td>
                            @php [$bg, $fg] = $item->status_warna; @endphp
                            <span class="al-badge" style="background:{{ $bg }}; color:{{ $fg }};">{{ $item->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.konsultasi.show', $item->id_konsultasi) }}" class="al-btn al-btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="al-empty">Belum ada konsultasi.</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>


{{-- ================= AKUN + MENU CEPAT ================= --}}
<div class="dashboard-content">

    <div class="dashboard-box">

        <div class="box-header"><h3>Informasi Login</h3></div>

        <div class="info-user">
            <div class="info-item">
                <span>Nama</span>
                <strong>{{ auth()->user()->nama }}</strong>
            </div>
            <div class="info-item">
                <span>Email</span>
                <strong>{{ auth()->user()->email }}</strong>
            </div>
        </div>

    </div>

    <div class="dashboard-box">

        <div class="box-header"><h3>Menu Cepat</h3></div>

        <div class="quick-menu">
            <a href="{{ route('admin.penawaran.index', ['status' => 'baru']) }}" class="quick-btn">
                <i class="ri-file-paper-2-line"></i> Penawaran Baru
            </a>
            <a href="{{ route('admin.konsultasi.index', ['status' => 'baru']) }}" class="quick-btn">
                <i class="ri-customer-service-2-line"></i> Konsultasi Baru
            </a>
            <a href="{{ route('admin.akun') }}" class="quick-btn">
                <i class="ri-lock-password-line"></i> Ganti Password
            </a>
            <a href="/" class="quick-btn">
                <i class="ri-global-line"></i> Lihat Website
            </a>
        </div>

    </div>

</div>

@endsection
