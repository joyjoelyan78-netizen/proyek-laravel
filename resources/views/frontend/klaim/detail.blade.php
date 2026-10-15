<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detail Garansi</title>

    <link rel="stylesheet"
          href="{{ asset('css/detail_garansi.css') }}">

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

        <div class="step active">
            <div class="circle">2</div>
            <span>Detail Produk</span>
        </div>

        <div class="line"></div>

        <div class="step">
            <div class="circle">3</div>
            <span>Klaim</span>
        </div>

        <div class="line"></div>

        <div class="step">
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

        {{-- HEADER --}}
        <div class="hasil-header">

            <h2>Detail Produk Garansi</h2>

            <span class="badge-kode">
                {{ $serial->kode_unik }}
            </span>

        </div>

        {{-- STATUS --}}
        <div class="status-alert status-berhasil">

            <i class="fas fa-check-circle"></i>

            <span>
                Kode produk berhasil diverifikasi
            </span>

        </div>

        {{-- HERO --}}
        <div class="hero-card hero-berhasil">

            <div class="hero-icon">
                <i class="fas fa-shield-check"></i>
            </div>

            <h3>
                Produk Ditemukan
            </h3>

            <p>
                Produk berhasil ditemukan di sistem.
                Silakan lanjutkan untuk melakukan
                klaim garansi produk.
            </p>

        </div>

        {{-- TABLE --}}
        <div class="info-table">

            <div class="info-row">
                <span>Nama Produk</span>
                <strong>
                    {{ $serial->produk->nama_produk }}
                </strong>
            </div>

            <div class="info-row">
                <span>Kode Produk</span>
                <strong>
                    {{ $serial->kode_unik }}
                </strong>
            </div>

            <div class="info-row">
                <span>Status Garansi</span>
                <strong class="text-aktif">
                    {{ $serial->status_garansi }}
                </strong>
            </div>

            <div class="info-row">
                <span>Status Klaim</span>
                <strong>
                    {{ $serial->status_klaim }}
                </strong>
            </div>

            <div class="info-row">
                <span>Masa Berlaku</span>
                <strong>
                    {{ $serial->masa_berlaku_sampai }}
                </strong>
            </div>

        </div>

        {{-- MATERIAL --}}
        <div class="material-section">

            <h4 class="material-title">
                Komposisi Material
            </h4>

            <div class="material-grid">

                <div class="material-card">

                    <div class="material-header">
                        <h5>Aluminium (Al)</h5>
                        <strong>95%</strong>
                    </div>

                    <div class="progress">
                        <div style="width:95%"></div>
                    </div>

                </div>

                <div class="material-card">

                    <div class="material-header">
                        <h5>Zinc (Zn)</h5>
                        <strong>4%</strong>
                    </div>

                    <div class="progress">
                        <div style="width:4%"></div>
                    </div>

                </div>

                <div class="material-card">

                    <div class="material-header">
                        <h5>Cadmium (Cd)</h5>
                        <strong>0.5%</strong>
                    </div>

                    <div class="progress">
                        <div style="width:1%"></div>
                    </div>

                </div>

                <div class="material-card">

                    <div class="material-header">
                        <h5>Iron (Fe)</h5>
                        <strong>0.3%</strong>
                    </div>

                    <div class="progress">
                        <div style="width:1%"></div>
                    </div>

                </div>

            </div>

        </div>

        {{-- INFO --}}
        <div class="info-note">

            <i class="fas fa-info-circle"></i>

            <p>
                Produk ini dirancang untuk perlindungan
                katodik lambung kapal dan lingkungan
                air laut dengan ketahanan korosi tinggi.
            </p>

        </div>

        {{-- WARNING --}}
        <div class="warning-box">

            <strong>Perhatian:</strong>

            Setelah klaim diajukan,
            teknisi akan melakukan verifikasi
            terhadap pemasangan dan kondisi produk.

        </div>

        {{-- BUTTON --}}
        <div class="button-wrapper">

            <a href="{{ route('klaim.garansi') }}"
               class="btn-klaim btn-secondary">

                Kembali

            </a>

            <a href="{{ route('klaim.garansi.form', $serial->kode_unik) }}"
               class="btn-klaim">

                Klaim Garansi

            </a>

        </div>

    </div>

</div>

</body>
</html>