<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Hasil Klaim Garansi</title>

    <link rel="stylesheet"
          href="{{ asset('css/tiket_garansi.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="hasil-wrapper">

    {{-- STEP --}}
    <div class="step-wrapper">

        <div class="step done">
            <div class="circle">1</div>
            <span>Kode Unik</span>
        </div>

        <div class="line active"></div>

        <div class="step done">
            <div class="circle">2</div>
            <span>Detail Produk</span>
        </div>

        <div class="line active"></div>

        <div class="step done">
            <div class="circle">3</div>
            <span>Klaim</span>
        </div>

        <div class="line active"></div>

        <div class="step active">
            <div class="circle">4</div>
            <span>Tiket</span>
        </div>

        <div class="line"></div>

        <div class="step">
            <div class="circle">5</div>
            <span>Hasil</span>
        </div>

    </div>

    {{-- CARD --}}
    <div class="hasil-card">

        {{-- STATUS --}}
        @if($klaim->status_klaim == 'ditolak')

            <div class="status-alert status-gagal">

                <i class="fas fa-times-circle"></i>

                <span>
                    Klaim garansi ditolak —
                    nama pembeli tidak sesuai invoice
                </span>

            </div>

        @else

            <div class="status-alert status-berhasil">

                <i class="fas fa-check-circle"></i>

                <span>
                    Klaim berhasil diajukan —
                    tiket dikirim ke
                    <b>{{ $klaim->email }}</b>
                </span>

            </div>

        @endif

        {{-- HEADER --}}
        <div class="hasil-header">

            <h2>
                @if($klaim->status_klaim == 'ditolak')
                    Klaim Garansi Ditolak
                @else
                    Hasil Klaim Garansi
                @endif
            </h2>

            <span class="badge-kode">
                {{ $klaim->serial->kode_unik ?? '-' }}
            </span>

        </div>

        {{-- HERO --}}
        <div class="hero-card {{ $klaim->status_klaim == 'ditolak' ? 'hero-gagal' : 'hero-berhasil' }}">

            <div class="hero-icon">

                @if($klaim->status_klaim == 'ditolak')

                    <i class="fas fa-times"></i>

                @else

                    <i class="fas fa-ticket-alt"></i>

                @endif

            </div>

            <h3>

                @if($klaim->status_klaim == 'ditolak')

                    Klaim Ditolak

                @else

                    Tiket Berhasil Dibuat

                @endif

            </h3>

            <p>

                @if($klaim->status_klaim == 'ditolak')

                    Nama pembeli tidak sesuai dengan invoice.
                    Silakan lakukan pengajuan ulang
                    menggunakan data yang benar.

                @else

                    Klaim garansi berhasil dikirim.
                    Tim teknisi kami akan segera
                    memproses pengajuan Anda.

                @endif

            </p>

        </div>

        {{-- TABLE --}}
        <div class="info-table">

            @if($klaim->status_klaim != 'ditolak')

                <div class="info-row">
                    <span>No Tiket</span>
                    <strong>
                        #{{ $klaim->tiket->nomor_tiket ?? '-' }}
                    </strong>
                </div>

            @endif

            <div class="info-row">
                <span>Nama Produk</span>
                <strong>
                    {{ $klaim->serial->produk->nama_produk ?? '-' }}
                </strong>
            </div>

            <div class="info-row">
                <span>Kode Produk</span>
                <strong>
                    {{ $klaim->serial->kode_unik ?? '-' }}
                </strong>
            </div>

            <div class="info-row">
                <span>Nama Pembeli</span>
                <strong>
                    {{ $klaim->nama_pembeli }}
                </strong>
            </div>

            <div class="info-row">
                <span>Email</span>
                <strong>
                    {{ $klaim->email }}
                </strong>
            </div>

            <div class="info-row">
                <span>Nomor Telepon</span>
                <strong>
                    {{ $klaim->nomor_telepon }}
                </strong>
            </div>

            <div class="info-row">
                <span>Status Klaim</span>

                <strong class="{{ $klaim->status_klaim == 'ditolak' ? 'text-gagal' : 'text-aktif' }}">

                @if($klaim->status_klaim == 'ditolak')

                    Ditolak

                @elseif($klaim->status_klaim == 'diterima')

                    Klaim Diterima

                @elseif($klaim->status_klaim == 'diproses')

                    Sedang Diproses Teknisi

                @elseif($klaim->status_klaim == 'selesai')

                    Garansi Disetujui

                @else

                    Pending Verifikasi

                @endif

                </strong>

            </div>

            <div class="info-row">
                <span>Tanggal Pengajuan</span>
                <strong>
                    {{ \Carbon\Carbon::parse($klaim->tanggal_klaim)->translatedFormat('d F Y') }}
                </strong>
            </div>

            @if($klaim->verifikasi)

                <div class="info-row">
                    <span>Teknisi</span>
                    <strong>
                        {{ $klaim->verifikasi->teknisi->nama_teknisi ?? '-' }}
                    </strong>
                </div>

                <div class="info-row">
                    <span>Tanggal Kunjungan</span>
                    <strong>
                        {{ \Carbon\Carbon::parse($klaim->verifikasi->tanggal_kunjungan)->translatedFormat('d F Y') }}
                    </strong>
                </div>

                <div class="info-row">
                    <span>Jam Kunjungan</span>
                    <strong>
                        {{ $klaim->verifikasi->jam_kunjungan }}
                    </strong>
                </div>

                <div class="info-row">
                    <span>Status Kunjungan</span>
                    <strong>
                        {{ ucfirst($klaim->verifikasi->status_kunjungan) }}
                    </strong>
                </div>

            @else

                <div class="info-row">
                    <span>Estimasi Kunjungan</span>
                    <strong>
                        2 - 5 Hari Kerja
                    </strong>
                </div>

            @endif

        </div>

        {{-- FOTO --}}
        @if($klaim->uploadFoto)

            <div class="foto-section">

                <h4 class="material-title">
                    Foto Bukti Pemasangan
                </h4>

                <div class="foto-box">

                    <img
                        src="{{ asset('storage/' . $klaim->uploadFoto->file_foto) }}"
                        alt="Foto Bukti"
                        class="foto-bukti"
                    >

                </div>

            </div>

        @endif

        {{-- TIMELINE --}}
        @if($klaim->status_klaim != 'ditolak')

            @php
                $adminVerified    = $klaim->status_klaim !== 'pending';
                $teknisiScheduled = (bool) $klaim->verifikasi;
            @endphp

            <div class="timeline-section">

                <h4 class="material-title">
                    Proses Selanjutnya
                </h4>

                <div class="timeline">

                    <div class="timeline-item active">

                        <div class="dot"></div>

                        <div class="timeline-content">

                            <h5>Tiket Dibuat</h5>

                            <p>
                                Sistem berhasil menerima
                                pengajuan klaim garansi Anda
                            </p>

                        </div>

                    </div>

                    <div class="timeline-item {{ $adminVerified ? 'active' : 'current' }}">

                        <div class="dot"></div>

                        <div class="timeline-content">

                            <h5>Verifikasi Admin</h5>

                            <p>
                                Admin melakukan pengecekan
                                data dan invoice pembelian
                            </p>

                        </div>

                    </div>

                    <div class="timeline-item {{ $teknisiScheduled ? 'active' : ($adminVerified ? 'current' : '') }}">

                        <div class="dot"></div>

                        <div class="timeline-content">

                            <h5>Penjadwalan Teknisi</h5>

                            <p>
                            @if($klaim->verifikasi)

                                Teknisi telah dijadwalkan pada
                                {{ \Carbon\Carbon::parse($klaim->verifikasi->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                pukul
                                {{ $klaim->verifikasi->jam_kunjungan }}

                            @else

                                Teknisi akan dijadwalkan
                                setelah klaim diverifikasi

                            @endif
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        @endif

        {{-- INFO --}}
        <div class="info-note">

            <i class="fas fa-info-circle"></i>

            <p>

                @if($klaim->status_klaim == 'ditolak')

                    Pastikan data pembeli sesuai
                    dengan invoice pembelian produk.

                @else

                    Silakan cek email secara berkala.
                    Informasi jadwal teknisi akan
                    dikirim setelah proses verifikasi selesai.

                @endif

            </p>

        </div>

        {{-- BUTTON --}}
        <div class="button-wrapper">

            <a href="{{ route('klaim.garansi') }}"
               class="btn-klaim btn-secondary">

                Kembali

            </a>

            <a href="/"
               class="btn-klaim">

                Selesai

            </a>

        </div>

    </div>

</div>

</body>
</html>