@extends('layouts.frontend')

@section('content')

<link rel="stylesheet" href="/css/produk.css">

@php
    // Controller semuaProduk() mengirim $kategori, tetapi kategori() mengirim $allKategori.
    // Dua-duanya ditangani di sini supaya halaman tidak error.
    $daftarKategori = $kategori ?? $allKategori ?? collect();

    $ikonKategori = function ($nama) {
        $n = strtolower($nama);
        if (str_contains($n, 'alumin')) return 'fa-cubes';
        if (str_contains($n, 'zinc') || str_contains($n, 'seng')) return 'fa-cube';
        return 'fa-cog';
    };
@endphp

<div class="pk-page">

    {{-- ================= HERO ================= --}}
    {{-- Ganti nama file gambar di bawah dengan foto hero halaman produk (public/images/) --}}
    <section class="pk-hero"
             style="--hero-img: url('/images/produk-hero.jpg')">
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

            {{-- TAB KATEGORI --}}
            <nav class="pk-tabs" aria-label="Kategori produk">

                <a href="{{ route('produk') }}"
                   class="pk-tab {{ isset($kategoriData) ? '' : 'is-active' }}">
                    <i class="fas fa-th-large"></i> Semua Produk
                </a>

                @foreach($daftarKategori as $k)
                    <a href="{{ route('produk.kategori', $k->slug) }}"
                       class="pk-tab {{ isset($kategoriData) && $kategoriData->id_kategori == $k->id_kategori ? 'is-active' : '' }}">
                        <i class="fas {{ $ikonKategori($k->nama_kategori) }}"></i>
                        {{ $k->nama_kategori }}
                    </a>
                @endforeach

            </nav>

            {{-- INFO HASIL --}}
            @if(request('search'))
                <p class="pk-result">
                    Hasil pencarian "<strong>{{ request('search') }}</strong>"
                    &middot; {{ $products->count() }} produk
                </p>
            @elseif(isset($kategoriData))
                <p class="pk-result">
                    Kategori <strong>{{ $kategoriData->nama_kategori }}</strong>
                    &middot; {{ $products->count() }} produk
                </p>
            @endif

            {{-- GRID PRODUK --}}
            <div class="pk-grid">

                @forelse($products as $product)

                    <a href="{{ route('produk.detail', $product->slug) }}" class="pk-card">

                        <div class="pk-card__img">
                            @if($product->gambar_produk)
                                <img src="/storage/{{ $product->gambar_produk }}"
                                     alt="{{ $product->nama_produk }}"
                                     loading="lazy">
                            @else
                                <div class="pk-card__noimg"><i class="fas fa-image"></i></div>
                            @endif
                        </div>

                        <div class="pk-card__body">
                            <h3>{{ $product->nama_produk }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($product->deskripsi), 90) }}</p>
                            <span class="pk-card__more">
                                Selengkapnya <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>

                    </a>

                @empty

                    <p class="pk-empty">Produk belum tersedia.</p>

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