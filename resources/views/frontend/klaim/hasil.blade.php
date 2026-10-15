<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hasil Verifikasi Garansi</title>

    <link rel="stylesheet" href="{{ asset('css/hasil_garansi.css') }}">

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

        <div class="step done">
            <div class="circle">4</div>
            <span>Tiket</span>
        </div>

        <div class="line active"></div>

        @if($klaim->status_klaim == 'selesai')

            <div class="step done">
                <div class="circle">5</div>
                <span>Hasil</span>
            </div>

        @elseif($klaim->status_klaim == 'ditolak')

            <div class="step rejected">
                <div class="circle">5</div>
                <span>Hasil</span>
            </div>

        @else

            <div class="step active">
                <div class="circle">5</div>
                <span>Hasil</span>
            </div>

        @endif

    </div>
    {{-- CARD --}}
    <div class="hasil-card">

        {{-- HEADER --}}
        <div class="hasil-header">

            <h2>Hasil Verifikasi Garansi</h2>

            <span class="badge-kode">
                {{ $klaim->serial->kode_unik ?? '-' }}
            </span>

        </div>

        {{-- STATUS --}}
        @if($klaim->status_klaim == 'selesai')

            <div class="status-alert status-berhasil">
                <i class="fas fa-check-circle"></i>
                <span>Garansi Disetujui</span>
            </div>

        @elseif($klaim->status_klaim == 'ditolak')

            <div class="status-alert status-gagal">
                <i class="fas fa-times-circle"></i>
                <span>Klaim Ditolak</span>
            </div>

        @else

            <div class="status-alert status-pending">
                <i class="fas fa-clock"></i>
                <span>Menunggu Verifikasi Admin</span>
            </div>

        @endif

        {{-- HERO --}}
        @if(in_array($klaim->status_klaim, ['diterima','diproses','selesai']))

            <div class="hero-card hero-berhasil">

                <div class="hero-icon">
                    <i class="fas fa-check-circle"></i>
                </div>

                <h3>Garansi Disetujui</h3>

                <p>
                    Klaim garansi telah diterima oleh admin.
                </p>

            </div>

        @elseif($klaim->status_klaim == 'ditolak')

            <div class="hero-card hero-gagal">

                <div class="hero-icon">
                    <i class="fas fa-times-circle"></i>
                </div>

                <h3>Klaim Ditolak</h3>

                <p>
                    Data pembeli tidak sesuai dengan invoice pembelian.
                </p>

            </div>

        @else

            <div class="hero-card hero-pending">

                <div class="hero-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>

                <h3>Sedang Diproses</h3>

                <p>
                    Klaim sedang menunggu persetujuan admin.
                </p>

            </div>

        @endif

        {{-- TABLE --}}
        <div class="info-table">

            {{-- NO TIKET --}}
            @if($klaim->tiket)

                <div class="info-row">
                    <span>No. Tiket</span>
                    <strong>
                        #{{ $klaim->tiket->nomor_tiket }}
                    </strong>
                </div>

            @endif

            {{-- PRODUK --}}
            <div class="info-row">

                <span>Produk</span>

                <strong>
                    {{ $klaim->serial->produk->nama_produk ?? '-' }}
                </strong>

            </div>

            {{-- STATUS --}}
            <div class="info-row">

                <span>Status Klaim</span>

                <strong>

                @if($klaim->status_klaim == 'diterima')

                    Diterima

                @elseif($klaim->status_klaim == 'diproses')

                    Diproses

                @elseif($klaim->status_klaim == 'selesai')

                    Selesai

                @elseif($klaim->status_klaim == 'ditolak')

                    Ditolak

                @else

                    Pending

                @endif

                </strong>

            </div>

            {{-- TEKNISI --}}
            @if($klaim->verifikasi)

                <hr style="margin:20px 0;">

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

                @if($klaim->verifikasi->catatan_verifikasi)

                    <div class="info-row">

                        <span>Catatan</span>

                        <strong>
                            {{ $klaim->verifikasi->catatan_verifikasi }}
                        </strong>

                    </div>

                @endif

            @endif

        </div>

        {{-- BUTTON --}}
        <div class="button-wrapper">

            <a href="{{ route('klaim.garansi') }}"
               class="btn-klaim">

                Klaim Produk Lainnya

            </a>

        </div>

    </div>

</div>

</body>
</html>