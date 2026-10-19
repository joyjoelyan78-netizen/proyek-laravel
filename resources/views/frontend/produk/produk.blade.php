@extends('layouts.frontend')

{{-- tujuan cadangan tombol Kembali jika halaman dibuka lewat link langsung --}}
@section('kembali_ke', '/produk')

@section('content')

<link rel="stylesheet" href="/css/produk-detail.css">

@php
    $seri   = $produk['seri'];
    $linkWa = \App\Support\KatalogVesca::linkWa(
        'Halo PT Vescarindo Utama, saya tertarik dengan ' . $produk['nama']
        . '. Mohon informasi lebih lanjut.'
    );
    $performa = $bahanInfo['performa'] ?? [];
@endphp

<div class="pd-page">

    <div class="pd-wrap">

        {{-- ================= BREADCRUMB ================= --}}
        <nav class="pd-crumb" aria-label="Breadcrumb">
            <a href="/">Beranda</a> <i class="fas fa-chevron-right"></i>
            <a href="{{ route('produk') }}">Produk</a> <i class="fas fa-chevron-right"></i>
            <a href="{{ route('produk.kategori', $produk['bahan']) }}">{{ $produk['bahan_nama'] }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $produk['nama'] }}</span>
        </nav>


        {{-- ================= HERO ================= --}}
        <section class="pd-hero">

            {{-- GALERI --}}
            <div class="pd-gallery">

                <div class="pd-main">
                    @if ($produk['foto'])
                        <img id="pd-main-img" src="{{ $produk['foto'] }}" alt="{{ $produk['nama'] }}">
                    @else
                        <i class="fas fa-image pd-noimg"></i>
                    @endif
                </div>

                @if (count($produk['galeri']) > 1)
                    <div class="pd-thumbs">
                        @foreach ($produk['galeri'] as $i => $foto)
                            <button type="button"
                                    class="pd-thumb {{ $i === 0 ? 'is-active' : '' }}"
                                    data-src="{{ $foto }}"
                                    aria-label="Lihat foto {{ $i + 1 }}">
                                <img src="{{ $foto }}" alt="" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @endif

            </div>


            {{-- INFO --}}
            <div class="pd-info">

                <span class="pd-badge pd-badge--{{ $produk['bahan'] }}">
                    <i class="fas fa-shield-halved"></i> {{ $produk['bahan_nama'] }}
                </span>

                <h1>{{ $produk['nama'] }}</h1>

                @if ($produk['subjudul'])
                    <p class="pd-sub">{{ $produk['subjudul'] }}</p>
                @endif

                <p class="pd-lead">{{ $produk['ringkas'] }}</p>

                <div class="pd-chips">
                    <span class="pd-chip"><i class="fas fa-layer-group"></i> {{ $produk['jumlah_tipe'] }} pilihan tipe</span>
                    @if ($produk['berat_label'])
                        <span class="pd-chip"><i class="fas fa-weight-hanging"></i> {{ $produk['berat_label'] }}</span>
                    @endif
                </div>

                @if (count($produk['kegunaan']))
                    <ul class="pd-check">
                        @foreach ($produk['kegunaan'] as $poin)
                            <li><i class="fas fa-circle-check"></i> <span>{{ $poin }}</span></li>
                        @endforeach
                    </ul>
                @endif

                @if (count($performa))
                    <div class="pd-stats">
                        <div class="pd-stat">
                            <span>Potensial larutan nominal</span>
                            <strong>{{ $performa['Potensial larutan nominal'] ?? '-' }}</strong>
                        </div>
                        <div class="pd-stat">
                            <span>Kapasitas listrik nominal</span>
                            <strong>{{ $performa['Kapasitas listrik nominal'] ?? '-' }}</strong>
                        </div>
                    </div>
                @endif

                <div class="pd-cta">

                    @if ($linkWa)
                        <a class="pd-btn pd-btn--wa" href="{{ $linkWa }}" target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                        </a>
                    @endif

                    <a class="pd-btn pd-btn--primary"
                       href="{{ route('penawaran.index', ['seri' => $produk['key']]) }}">
                        <i class="fas fa-file-invoice"></i> Minta Penawaran
                    </a>

                    <a class="pd-btn pd-btn--ghost"
                       href="{{ route('konsultasi.index', ['seri' => $produk['key']]) }}#form-konsultasi">
                        <i class="fas fa-comments"></i> Tanya Tim Teknis
                    </a>

                </div>

            </div>

        </section>


        {{-- ================= SPESIFIKASI TIPE ================= --}}
        <section class="pd-card" id="spesifikasi">

            <div class="pd-card__head">

                <div>
                    <h2>Spesifikasi Tipe</h2>
                    <p class="pd-card__desc">Pilih tipe yang Anda butuhkan, lalu minta penawaran atau tanya lewat WhatsApp.</p>
                </div>

                <label class="pd-filter">
                    <i class="fas fa-search"></i>
                    <input type="text" id="pd-filter" placeholder="Cari tipe, contoh: {{ $seri['baris'][0][0] }}" autocomplete="off">
                </label>

            </div>

            <div class="pd-table-wrap">

                <table class="pd-table" id="pd-table">

                    <thead>
                        <tr>
                            @foreach ($seri['kolom'] as $judul)
                                <th>{{ $judul }}</th>
                            @endforeach
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($seri['baris'] as $baris)

                            @php
                                $kode   = $baris[0];
                                $dipilih = $tipeDipilih !== '' && strcasecmp($tipeDipilih, $kode) === 0;
                                $waTipe = \App\Support\KatalogVesca::linkWa(
                                    'Halo PT Vescarindo Utama, saya ingin menanyakan tipe ' . $kode
                                    . ' (' . $produk['nama'] . ').'
                                );
                            @endphp

                            <tr data-kode="{{ strtolower($kode) }}" class="{{ $dipilih ? 'is-picked' : '' }}">

                                @foreach ($baris as $i => $nilai)
                                    <td class="{{ $i === 0 ? 'pd-kode' : '' }}">{{ $nilai }}</td>
                                @endforeach

                                <td class="pd-aksi">
                                    <a class="pd-mini pd-mini--q"
                                       href="{{ route('penawaran.index', ['seri' => $produk['key'], 'tipe' => $kode]) }}">
                                        Minta penawaran
                                    </a>
                                    @if ($waTipe)
                                        <a class="pd-mini pd-mini--wa" href="{{ $waTipe }}"
                                           target="_blank" rel="noopener" aria-label="Tanya {{ $kode }} lewat WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <div class="pd-empty" id="pd-empty" hidden>Tipe tidak ditemukan. Coba kata kunci lain.</div>

            </div>

        </section>


        {{-- ================= PERFORMA + KOMPOSISI ================= --}}
        <div class="pd-grid2">

            <section class="pd-card">

                <h2>Data Performa Nominal</h2>
                <p class="pd-card__desc">Berlaku untuk seluruh tipe {{ $produk['bahan_nama'] }}.</p>

                <ul class="pd-perf" style="margin-top:16px;">
                    @foreach ($performa as $label => $nilai)
                        <li><span>{{ $label }}</span> <strong>{{ $nilai }}</strong></li>
                    @endforeach
                </ul>

                <p class="pd-note">{{ $bahanInfo['ringkasan'] ?? '' }}</p>

            </section>

            <section class="pd-card">

                <h2>Komposisi Material</h2>
                <p class="pd-card__desc">Persentase unsur paduan.</p>

                @if (!empty($bahanInfo['komposisi']))
                    <div class="pd-table-wrap" style="margin-top:16px;">
                        <table class="pd-table" style="min-width:0;">
                            <thead>
                                <tr>
                                    @foreach ($bahanInfo['komposisi_kolom'] as $judul)
                                        <th>{{ $judul }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bahanInfo['komposisi'] as $baris)
                                    <tr>
                                        @foreach ($baris as $nilai)
                                            <td>{{ $nilai }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </section>

        </div>


        {{-- ================= SERTIFIKASI ================= --}}
        <div class="pd-trust">

            <div>
                <strong>Bersertifikat dan terstandar</strong>
                <span>BKI Type Approval dan ISO 9001:2015, sesuai katalog PT Vescarindo Utama.</span>
            </div>

            <a href="{{ route('konsultasi.index') }}#sertifikasi">Lihat sertifikat</a>

        </div>


        {{-- ================= REKOMENDASI ================= --}}
        @if (count($rekomendasi))

            <section class="pd-reco">

                <div class="pd-reco__head">

                    <h2>Produk Lainnya yang Mungkin Anda Butuhkan</h2>

                    <a href="{{ route('produk') }}">Lihat semua produk <i class="fas fa-arrow-right"></i></a>

                </div>

                <div class="pd-reco-grid">

                    @foreach ($rekomendasi as $r)

                        <a href="{{ route('produk.detail', $r['slug']) }}" class="pd-rcard">

                            <div class="pd-rcard__img">
                                @if ($r['foto'])
                                    <img src="{{ $r['foto'] }}" alt="{{ $r['nama'] }}" loading="lazy">
                                @endif
                            </div>

                            <div class="pd-rcard__body">
                                <span class="pd-badge pd-badge--{{ $r['bahan'] }}">{{ $r['bahan_nama'] }}</span>
                                <h3>{{ $r['nama'] }}</h3>
                                <p>{{ $r['jumlah_tipe'] }} tipe @if ($r['berat_label']) &middot; {{ $r['berat_label'] }} @endif</p>
                                <span class="pd-rcard__more">Lihat detail <i class="fas fa-arrow-right"></i></span>
                            </div>

                        </a>

                    @endforeach

                </div>

            </section>

        @endif

    </div>

</div>


<script>
(function () {

    /* ---- ganti foto utama saat thumbnail diklik ---- */
    var utama = document.getElementById('pd-main-img');

    document.querySelectorAll('.pd-thumb').forEach(function (tombol) {

        tombol.addEventListener('click', function () {

            if (utama) { utama.src = tombol.getAttribute('data-src'); }

            document.querySelectorAll('.pd-thumb').forEach(function (t) { t.classList.remove('is-active'); });
            tombol.classList.add('is-active');
        });
    });

    /* ---- cari tipe di tabel ---- */
    var input = document.getElementById('pd-filter');
    var baris = document.querySelectorAll('#pd-table tbody tr');
    var kosong = document.getElementById('pd-empty');

    function bersihkan(t) { return t.toLowerCase().replace(/[^a-z0-9]+/g, ''); }

    if (input) {

        input.addEventListener('input', function () {

            var kunci = bersihkan(input.value);
            var tampil = 0;

            baris.forEach(function (tr) {

                var cocok = kunci === '' || bersihkan(tr.getAttribute('data-kode')).indexOf(kunci) !== -1;

                tr.style.display = cocok ? '' : 'none';

                if (cocok) { tampil++; }
            });

            kosong.hidden = tampil !== 0;
        });
    }

    /* ---- kalau datang dari pencarian (?tipe=AV-320), gulir ke barisnya ---- */
    var terpilih = document.querySelector('#pd-table tr.is-picked');

    if (terpilih) {
        setTimeout(function () {
            terpilih.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 300);
    }

})();
</script>

@endsection
