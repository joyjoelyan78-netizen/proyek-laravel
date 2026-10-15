<!DOCTYPE html>
<html>
<head>
    <title>Admin VESCA</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <div class="logo">
            <h2>VESCA</h2>
        </div>

        <!-- DASHBOARD -->
        <div class="menu-title">MAIN</div>

        <a href="/admin/dashboard">
            <i class="ri-dashboard-line"></i>
            Dashboard
        </a>

        <!-- PENAWARAN & KONSULTASI -->
        <div class="menu-title">PENAWARAN &amp; KONSULTASI</div>

        @php
            try {
                $penawaranBaru  = \App\Models\PermintaanPenawaran::where('status', 'baru')->count();
                $konsultasiBaru = \App\Models\KonsultasiTeknis::where('status', 'baru')->count();
            } catch (\Throwable $e) {
                // tabel belum dibuat (migration belum dijalankan)
                $penawaranBaru  = 0;
                $konsultasiBaru = 0;
            }
        @endphp

        <a href="/admin/permintaan-penawaran" style="display:flex; align-items:center; justify-content:space-between;">
            <span>
                <i class="ri-file-paper-2-line"></i>
                Permintaan Penawaran
            </span>
            @if($penawaranBaru > 0)
                <span style="background:#e74c3c; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:999px; min-width:20px; text-align:center;">{{ $penawaranBaru }}</span>
            @endif
        </a>

        <a href="/admin/konsultasi-teknis" style="display:flex; align-items:center; justify-content:space-between;">
            <span>
                <i class="ri-customer-service-2-line"></i>
                Konsultasi Teknis
            </span>
            @if($konsultasiBaru > 0)
                <span style="background:#e74c3c; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:999px; min-width:20px; text-align:center;">{{ $konsultasiBaru }}</span>
            @endif
        </a>

        <!-- MASTER DATA -->
        <div class="menu-title">MASTER DATA</div>

        <a href="/admin/kategori-produk">
            <i class="ri-folder-line"></i>
            Kategori Produk
        </a>

        @if(auth()->user()->hasPermission('view_produk'))
        <a href="/admin/produk">
            <i class="ri-box-3-line"></i>
            Produk
        </a>
        @endif

        <a href="/admin/customer">
            <i class="ri-group-line"></i>
            Customer
        </a>

        <a href="/admin/teknisi">
            <i class="ri-user-star-line"></i>
            Teknisi
        </a>

        <!-- PESANAN -->
        <div class="menu-title">PESANAN</div>

        <a href="/admin/pesanan">
            <i class="ri-file-list-3-line"></i>
            Data Pesanan
        </a>

        <a href="/admin/detail-pesanan">
            <i class="ri-list-check-2"></i>
            Detail Pesanan
        </a>

        <a href="/admin/tracking-pesanan">
            <i class="ri-route-line"></i>
            Tracking Pesanan
        </a>

        <!-- GARANSI -->
        <div class="menu-title">GARANSI</div>

        <a href="/admin/serial-produk">
            <i class="ri-qr-code-line"></i>
            Serial Produk
        </a>

        {{-- Klaim Garansi dengan badge notif --}}
        @php $klaimPending = \App\Models\KlaimGaransi::where('status_klaim', 'pending')->count(); @endphp
        <a href="/admin/klaim-garansi" style="display:flex; align-items:center; justify-content:space-between;">
            <span>
                <i class="ri-tools-line"></i>
                Klaim Garansi
            </span>
            @if($klaimPending > 0)
                <span style="
                    background: #e74c3c;
                    color: #fff;
                    font-size: 11px;
                    font-weight: 700;
                    padding: 2px 7px;
                    border-radius: 999px;
                    min-width: 20px;
                    text-align: center;
                ">{{ $klaimPending }}</span>
            @endif
        </a>

        <a href="/admin/verifikasi-garansi">
            <i class="ri-shield-check-line"></i>
            Verifikasi Garansi
        </a>

        <!-- USER -->
        <div class="menu-title">USER MANAGEMENT</div>

        @if(auth()->user()->hasRole('Super Admin'))
        <a href="/admin/users">
            <i class="ri-user-line"></i>
            User Admin
        </a>

        <a href="/admin/roles">
            <i class="ri-admin-line"></i>
            Role User
        </a>
        @endif

        <!-- LOG -->
        <div class="menu-title">SYSTEM</div>

        <a href="/admin/activity-log">
            <i class="ri-history-line"></i>
            Activity Log
        </a>

        <a href="/">
            <i class="ri-global-line"></i>
            Lihat Website
        </a>

        <!-- LOGOUT -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="ri-logout-box-r-line"></i>
                Logout
            </button>
        </form>

    </div>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

</div>

<script>
document.querySelectorAll('.toggle-permission').forEach(toggle => {
    toggle.addEventListener('change', function(){
        fetch('/admin/permission-toggle', {
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body:JSON.stringify({
                role_id:this.dataset.role,
                permission_id:this.dataset.permission
            })
        });
    });
});
</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');

    // Ambil posisi scroll terakhir
    const savedScroll = localStorage.getItem('sidebar-scroll');

    if(savedScroll !== null){
        sidebar.scrollTop = savedScroll;
    }

    // Simpan posisi scroll saat sidebar discroll
    sidebar.addEventListener('scroll', function () {

        localStorage.setItem(
            'sidebar-scroll',
            sidebar.scrollTop
        );

    });

});

</script>

</body>
</html>