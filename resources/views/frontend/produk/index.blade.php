@extends('layouts.frontend')

@section('content')

<link rel="stylesheet" href="/css/produk.css">

@php
    // Produk diambil dari kode (config/katalog_vesca.php), bukan dari database.
    $tabs = [
        'semua'     => ['Semua Produk', 'fa-th-large'],
        'aluminium' => ['Aluminium Anode', 'fa-cubes'],
        'zinc'      => ['Zinc Anode', 'fa-cube'],
    ];
@endphp

<div class="pk-page">

    {{-- ================= HERO ================= --}}
    <section class="pk-hero"
             style="--hero-img: url('/image/background.webp')">

        <div class="pk-wrap">

            <div class="pk-hero__content">

                <h1>Produk <span>Berkualitas Tinggi</span></h1>

                <p>
                    Anoda berkualitas tinggi dengan standar internasional
                    untuk performa maksimal dan umur pakai yang lebih lama
                    di lingkungan air laut maupun air tawar.
                </p>

                <a href="{{ route('hubungi') }}" class="pk-btn-outline">
                    Hubungi Kami <i class="fas fa-phone"></i>
                </a>

            </div>

        </div>

    </section>


    {{-- ================= KATEGORI & PRODUK ================= --}}
    <section class="pk-section">

        <div class="pk-wrap">

            <p class="pk-label">Kategori Produk</p>

            <h2 class="pk-title">Solusi Proteksi Katodik untuk Berbagai Kebutuhan</h2>

            {{-- TAB BAHAN --}}
            <nav class="pk-tabs" aria-label="Kategori produk">

                @foreach ($tabs as $kodeTab => [$labelTab, $ikonTab])

                    <a href="{{ $kodeTab !== 'semua' ? route('produk.kategori', $kodeTab) : route('produk') }}"
                       class="pk-tab {{ ($bahanAktif ?? 'semua') === $kodeTab && $search === '' ? 'is-active' : '' }}">
                        <i class="fas {{ $ikonTab }}"></i>
                        {{ $labelTab }}
                    </a>

                @endforeach

            </nav>

            {{-- INFO HASIL --}}
            @if ($search !== '')
                <p class="pk-result">
                    Hasil pencarian "<strong>{{ $search }}</strong>"
                    &middot; {{ count($products) }} produk
                </p>
            @elseif ($bahanAktif)
                <p class="pk-result">
                    Kategori <strong>{{ $tabs[$bahanAktif][0] }}</strong>
                    &middot; {{ count($products) }} produk
                </p>
            @endif

            {{-- GRID PRODUK --}}
            <div class="pk-grid">

                @forelse ($products as $product)

                    <a href="{{ route('produk.detail', $product['slug']) }}" class="pk-card">

                        <div class="pk-card__img">
                            @if ($product['foto'])
                                <img src="{{ $product['foto'] }}"
                                     alt="{{ $product['nama'] }}"
                                     loading="lazy">
                            @else
                                <div class="pk-card__noimg"><i class="fas fa-image"></i></div>
                            @endif
                        </div>

                        <div class="pk-card__body">

                            <span class="pk-card__tag pk-card__tag--{{ $product['bahan'] }}">
                                {{ $product['bahan_nama'] }}
                            </span>

                            <h3>{{ $product['nama'] }}</h3>

                            <p>{{ $product['ringkas'] }}</p>

                            <p class="pk-card__meta">
                                {{ $product['jumlah_tipe'] }} tipe
                                @if ($product['berat_label'])
                                    &middot; {{ $product['berat_label'] }}
                                @endif
                            </p>

                            <span class="pk-card__more">
                                Selengkapnya <i class="fas fa-arrow-right"></i>
                            </span>

                        </div>

                    </a>

                @empty

                    <p class="pk-empty">
                        Produk tidak ditemukan. Coba kata kunci lain, misalnya "S-3" atau "AV-320".
                    </p>

                @endforelse

            </div>


            {{-- KEUNGGULAN --}}
            <div class="pk-features">

                <div class="pk-feature">
                    <i class="fas fa-shield-alt"></i>
                    <div><strong>Kualitas Terjamin</strong><span>Sesuai standar NACE TM</span></div>
                </div>

                <div class="pk-feature">
                    <i class="fas fa-award"></i>
                    <div><strong>Pengalaman 25+ Tahun</strong><span>Sejak 1997 melayani industri</span></div>
                </div>

                <div class="pk-feature">
                    <i class="fas fa-hands-helping"></i>
                    <div><strong>Solusi Profesional</strong><span>Teknisi berpengalaman</span></div>
                </div>

                <div class="pk-feature">
                    <i class="fas fa-handshake"></i>
                    <div><strong>Layanan Terpercaya</strong><span>Kepuasan pelanggan prioritas kami</span></div>
                </div>

            </div>


            {{-- CTA --}}
            <div class="pk-cta">

                <i class="fas fa-headset pk-cta__icon"></i>

                <div class="pk-cta__text">
                    <h3>Butuh Bantuan atau konsultasi lebih lanjut ?</h3>
                    <p>Tim kami siap membantu Anda menemukan solusi perlindungan korosi terbaik</p>
                </div>

                <a href="{{ route('hubungi') }}" class="pk-btn-outline">
                    Hubungi Kami <i class="fas fa-phone"></i>
                </a>

            </div>

        </div>

    </section>

</div>

@endsection
