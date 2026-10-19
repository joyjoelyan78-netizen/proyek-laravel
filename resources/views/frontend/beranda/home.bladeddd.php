@extends('layouts.frontend')

@section('content')

@push('styles')
<link rel="stylesheet" href="/css/beranda.css">
@endpush


{{-- =========================================================
     HERO
========================================================= --}}

<section class="vesca-hero">

    <div class="hero-overlay"></div>

    <div class="hero-inner">

        <div class="hero-text" data-aos="fade-right" data-aos-duration="1000">

            <h1>
                Perlindungan Korosi
                <br>
                Terpercaya <span>Sejak 1977</span>
            </h1>

            <p>
                PT. Vescarindo Utama adalah perusahaan yang bergerak
                di bidang korosi dengan produk utama Aluminium dan Zinc
                berkualitas tinggi untuk sistem proteksi katodik.
            </p>

            <a href="{{ route('hubungi') }}" class="hero-button">
                Hubungi Kami
                <i class="fas fa-phone"></i>
            </a>

        </div>

    </div>

</section>



{{-- =========================================================
     KEUNGGULAN
========================================================= --}}

<section class="advantages">

    <div class="advantages-container">

        <div class="advantage-item" data-aos="fade-up">

            <div class="advantage-icon">
                <i class="fas fa-shield-halved"></i>
            </div>

            <div>
                <h4>Kualitas Terjamin</h4>
                <p>Sesuaikan standar NACEM TM</p>
            </div>

        </div>


        <div class="advantage-item" data-aos="fade-up" data-aos-delay="100">

            <div class="advantage-icon">
                <i class="fas fa-award"></i>
            </div>

            <div>
                <h4>Pengalaman 25+ Tahun</h4>
                <p>Sejak 1997 melayani industri</p>
            </div>

        </div>


        <div class="advantage-item" data-aos="fade-up" data-aos-delay="200">

            <div class="advantage-icon">
                <i class="fas fa-certificate"></i>
            </div>

            <div>
                <h4>Solusi Profesional</h4>
                <p>Teknisi berpengalaman</p>
            </div>

        </div>


        <div class="advantage-item" data-aos="fade-up" data-aos-delay="300">

            <div class="advantage-icon">
                <i class="fas fa-handshake"></i>
            </div>

            <div>
                <h4>Layanan Terpercaya</h4>
                <p>Kepuasan pelanggan prioritas kami</p>
            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     PRODUK
========================================================= --}}

<section class="home-products">

    <div class="home-products-container">

        <div class="products-intro" data-aos="fade-right">

            <span>Produk Kami</span>

            <h2>
                Anoda Berkualitas Tinggi
            </h2>

            <p>
                Diproduksi dari bahan baku pilihan dengan standar
                internasional untuk performa maksimal dan umur pakai
                yang lebih lama.
            </p>

            <a href="{{ route('produk') }}" class="primary-button">
                Lihat Semua Produk
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>


        <div class="products-preview" data-aos="fade-left">

            @foreach($products->take(2) as $product)

                <a
                    href="{{ route('produk.detail', $product->slug) }}"
                    class="home-product-card"
                >

                    <div class="product-image">

                        @if($product->gambar_produk)

                            <img
                                src="/storage/{{ $product->gambar_produk }}"
                                alt="{{ $product->nama_produk }}"
                                loading="lazy"
                            >

                        @else

                            <div class="product-no-image">
                                <i class="fas fa-box"></i>
                            </div>

                        @endif

                    </div>

                    <div class="product-card-content">

                        <h3>
                            {{ $product->nama_produk }}
                        </h3>

                        <p>
                            Anoda berkualitas untuk perlindungan
                            korosi sistem katodik.
                        </p>

                        <span>
                            Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </span>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>



{{-- =========================================================
     LAYANAN
========================================================= --}}

<section class="services-section">

    <div class="services-container">

        <div class="services-left" data-aos="fade-right">

            <span class="section-label">
                Layanan Vesca
            </span>

            <h2>
                Layanan Transparan
                <br>
                dan Terpercaya
            </h2>

            <p>
                Kami menghadirkan layanan digital untuk memberikan
                kemudahan, transparansi, dan pengalaman terbaik bagi
                setiap pelanggan.
            </p>


            <div class="service-device" data-aos="zoom-in">

                <img
                    src="/image/laptop-hp.png"
                    alt="Website Vescarindo pada laptop dan smartphone"
                >

            </div>

        </div>


        <div class="services-right" data-aos="fade-left">

            <div class="service-card">

                <div class="service-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>

                <div>

                    <h3>Minta Penawaran Resmi</h3>

                    <p>
                        Sampaikan kebutuhan anoda Aluminium atau Zinc
                        Anda, dan dapatkan surat penawaran resmi dari
                        tim kami.
                    </p>

                    <a href="{{ route('penawaran.index') }}">
                        Minta penawaran sekarang
                        <i class="fas fa-arrow-right"></i>
                    </a>

                </div>

            </div>


            <div class="service-card">

                <div class="service-icon">
                    <i class="fas fa-comments"></i>
                </div>

                <div>

                    <h3>Konsultasi &amp; Spesifikasi Teknis</h3>

                    <p>
                        Lihat spesifikasi produk dan tanyakan pilihan
                        anoda yang tepat untuk kapal Anda kepada tim
                        teknis kami.
                    </p>

                    <a href="{{ route('konsultasi.index') }}">
                        Konsultasi sekarang
                        <i class="fas fa-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>


        <div class="service-contact">

            <div class="service-contact-icon">
                <i class="fas fa-headset"></i>
            </div>

            <div>

                <strong>
                    Butuh Bantuan atau konsultasi lebih lanjut?
                </strong>

                <span>
                    Tim kami siap membantu menemukan solusi perlindungan korosi terbaik.
                </span>

            </div>

            <a href="{{ route('hubungi') }}">
                Hubungi Kami
                <i class="fas fa-phone"></i>
            </a>

        </div>

    </div>

</section>



{{-- =========================================================
     TENTANG KAMI
========================================================= --}}

<section class="about-home">

    <div class="about-container">

        <div class="about-image" data-aos="fade-right">

            <img
                src="/image/vesca karyawan 1.png"
                alt="PT Vescarindo Utama"
                loading="lazy"
            >

        </div>


        <div class="about-content" data-aos="fade-left">

            <span>Tentang Kami</span>

            <h2>
                PT. Vescarindo Utama
            </h2>

            <p>
                PT. Vescarindo Utama adalah perusahaan yang bergerak
                di bidang proteksi katodik dengan produk utama
                Aluminium dan Zinc berkualitas tinggi.
            </p>

            <p>
                Kami berkomitmen memberikan produk berkualitas,
                layanan profesional, serta solusi terbaik untuk
                memastikan aset dan infrastruktur Anda tetap
                terlindungi dari korosi.
            </p>

            <p>
                Dengan pengalaman lebih dari dua dekade, kami terus
                berkembang dan menjadi mitra terpercaya bagi berbagai
                industri di Indonesia.
            </p>

        </div>

    </div>

</section>



{{-- =========================================================
     MITRA
========================================================= --}}

<section class="partners">

    <h2 data-aos="fade-up">
        Mitra Kami
    </h2>

    <div class="partners-grid" data-aos="fade-up">

        <div class="partner-logo">
            <img src="/image/samudera.png" alt="Samudera">
        </div>

        <div class="partner-logo">
            <img src="/image/meratus.png" alt="Meratus">
        </div>

        <div class="partner-logo">
            <img src="/image/pelindo.png" alt="Pelindo">
        </div>

        <div class="partner-logo">
            <img src="/image/silo.png" alt="Sillo Maritime">
        </div>

        <div class="partner-logo">
            <img src="/image/pelni.png" alt="Pelni">
        </div>

        <div class="partner-logo">
            <img src="/image/pertamina.png" alt="Pertamina">
        </div>

        <div class="partner-logo">
            <img src="/image/meratus2.png" alt="SPIL">
        </div>

        <div class="partner-logo">
            <img src="/image/asdp.png" alt="ASDP">
        </div>

    </div>

</section>


@endsection