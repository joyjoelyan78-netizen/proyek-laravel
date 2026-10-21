<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin VESCA</title>
    <link rel="stylesheet" href="/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <div class="logo">
            <h2>VESCA</h2>
        </div>

        @php
            // jumlah yang masih berstatus "baru", untuk lencana merah di menu
            try {
                $penawaranBaru  = \App\Models\PermintaanPenawaran::where('status', 'baru')->count();
                $konsultasiBaru = \App\Models\KonsultasiTeknis::where('status', 'baru')->count();
            } catch (\Throwable $e) {
                // tabel belum dibuat (migration belum dijalankan)
                $penawaranBaru  = 0;
                $konsultasiBaru = 0;
            }
        @endphp

        <!-- DASHBOARD -->
        <div class="menu-title">MAIN</div>

        <a href="{{ route('admin.dashboard') }}">
            <i class="ri-dashboard-line"></i>
            Dashboard
        </a>

        <!-- PENAWARAN & KONSULTASI -->
        <div class="menu-title">PENAWARAN &amp; KONSULTASI</div>

        <a href="{{ route('admin.penawaran.index') }}" style="display:flex; align-items:center; justify-content:space-between;">
            <span>
                <i class="ri-file-paper-2-line"></i>
                Permintaan Penawaran
            </span>
            @if ($penawaranBaru > 0)
                <span style="background:#e74c3c; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:999px; min-width:20px; text-align:center;">{{ $penawaranBaru }}</span>
            @endif
        </a>

        <a href="{{ route('admin.konsultasi.index') }}" style="display:flex; align-items:center; justify-content:space-between;">
            <span>
                <i class="ri-customer-service-2-line"></i>
                Konsultasi Teknis
            </span>
            @if ($konsultasiBaru > 0)
                <span style="background:#e74c3c; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:999px; min-width:20px; text-align:center;">{{ $konsultasiBaru }}</span>
            @endif
        </a>

        <!-- AKUN -->
        <div class="menu-title">AKUN</div>

        @if (auth()->user()->hasRole('Super Admin'))
            <a href="{{ route('admin.users.index') }}">
                <i class="ri-user-line"></i>
                Akun Admin
            </a>
        @endif

        <a href="{{ route('admin.akun') }}">
            <i class="ri-lock-password-line"></i>
            Ganti Password
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
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');

    // Ambil posisi scroll terakhir
    const savedScroll = localStorage.getItem('sidebar-scroll');

    if (savedScroll !== null) {
        sidebar.scrollTop = savedScroll;
    }

    // Simpan posisi scroll saat sidebar discroll
    sidebar.addEventListener('scroll', function () {
        localStorage.setItem('sidebar-scroll', sidebar.scrollTop);
    });
});
</script>

</body>
</html>
