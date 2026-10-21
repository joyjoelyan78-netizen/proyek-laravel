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
                Terpercaya <span>Sejak 1997</span>
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

            @foreach($products as $product)

                <a
                    href="{{ route('produk.detail', $product['slug']) }}"
                    class="home-product-card"
                >

                    <div class="product-image">

                        @if($product['foto'])

                            <img
                                src="{{ $product['foto'] }}"
                                alt="{{ $product['nama'] }}"
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
                            {{ $product['nama'] }}
                        </h3>

                        <p>
                            {{ $product['ringkas'] }}
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
     MITRA KAMI
========================================================= --}}

<section class="partners partners-vesca">

    <div class="partners-heading" data-aos="fade-up">
        <span class="partners-eyebrow">Dipercaya Berbagai Industri</span>
        <h2>Mitra Kami</h2>
        <p>
            Bersama mitra terpercaya, kami mendukung kebutuhan industri
            dan solusi perlindungan korosi.
        </p>
    </div>

    <div class="partners-grid" data-aos="fade-up">

        <div class="partner-logo">
            <img src="{{ asset('image/logo/destinasi_maritim.png') }}"
                 alt="Destinasi Maritim"
                 style="transform:scale(1.3);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/equinox_bahari.png') }}"
                 alt="Equinox Bahari Utama"
                 style="transform:scale(1.9);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/GMS.png') }}"
                 alt="GMS"
                 style="transform:scale(5.4);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/indo shiping.png') }}"
                 alt="Indo Shipping"
                 style="transform:scale(1.2);">
        </div>
        
        <div class="partner-logo">
            <img src="{{ asset('image/logo/Logo_BAG.png') }}"
                 alt="BAG"
                 style="transform:scale(1.4);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/pt_lintas_bahari.png') }}"
                 alt="PT Lintas Bahari"
                 style="transform:scale(1.5);">
        </div>
        
        <div class="partner-logo">
            <img src="{{ asset('image/logo/merah putih.png') }}"
                 alt="Merah Putih Shipyard"
                 style="transform:scale(4.3);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/naval_dipo.png') }}"
                 alt="Naval Dipo Service"
                 style="transform:scale(2.0);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/PT_delta_oriental.png') }}"
                 alt="PT Delta Oriental"
                 style="transform:scale(1.6);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/Karya_teknik.png') }}"
                 alt="Karya Teknik"
                 style="transform:scale(1.0);">
        </div>

        <div class="partner-logo">
            <img src="{{ asset('image/logo/pt_samudra_marine.png') }}"
                 alt="PT Samudra Marine"
                 style="transform:scale(2.9);">
        </div>
        

        {{-- MITRA LAINNYA --}}
        <div class="partner-logo partner-more">
            <div class="partner-more-content">
                <strong>100+</strong>
                <span>Mitra Terpercaya</span>
                <small>Bersama membangun industri Indonesia</small>
            </div>
        </div>

    </div>

</section>

<style>
    /* AREA MITRA */
    .partners-vesca {
        width: 100%;
        padding: 50px 4% 65px;
        box-sizing: border-box;
        background: #fff;
    }

    .partners-vesca .partners-heading {
        text-align: center;
        margin-bottom: 35px;
    }

    .partners-vesca .partners-eyebrow {
        display: block;
        color: #2674cf;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .partners-vesca .partners-heading h2 {
        color: #071b49;
        font-size: 30px;
        margin: 0 0 12px;
    }

    .partners-vesca .partners-heading p {
        color: #667085;
        font-size: 15px;
        line-height: 1.7;
        margin: 0;
    }

    /* DESKTOP: 2 BARIS, 6 KOLOM, TANPA KOTAK */
    .partners-vesca .partners-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        grid-template-rows: repeat(2, 135px);
        align-items: center;
        justify-items: center;
        gap: 18px 15px;
        max-width: 1250px;
        margin: 0 auto;
    }

    /* LOGO TANPA BORDER ATAU BACKGROUND */
    .partners-vesca .partner-logo {
        width: 100%;
        min-width: 0;
        height: 135px;
        padding: 10px;
        box-sizing: border-box;

        display: flex;
        align-items: center;
        justify-content: center;

        border: none;
        border-radius: 0;
        background: transparent;
        box-shadow: none;
        overflow: visible;
    }

    /* UKURAN DASAR LOGO */
    .partners-vesca .partner-logo img {
        display: block;
        width: 150px;
        height: 100px;
        max-width: 100%;
        object-fit: contain;
        object-position: center;
        transition: transform .25s ease;
    }

    /* KARTU 100+ TETAP BERWARNA */
    .partners-vesca .partner-logo.partner-more {
        background: linear-gradient(135deg, #071b49, #174b91);
        border-radius: 12px;
        color: #fff;
        text-align: center;
    }

    .partners-vesca .partner-more-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .partners-vesca .partner-more strong {
        color: #fff;
        font-size: 38px;
        line-height: 1.1;
    }

    .partners-vesca .partner-more span {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
    }

    .partners-vesca .partner-more small {
        color: #dce8fa;
        font-size: 10px;
        line-height: 1.4;
    }

    /* TABLET */
    @media (min-width: 601px) and (max-width: 900px) {
        .partners-vesca .partners-grid {
            grid-template-columns: repeat(6, minmax(0, 1fr));
            grid-template-rows: repeat(2, 110px);
            gap: 12px 5px;
        }

        .partners-vesca .partner-logo {
            height: 110px;
            padding: 5px;
        }

        .partners-vesca .partner-logo img {
            height: 80px;
        }

        .partners-vesca .partner-more strong {
            font-size: 26px;
        }

        .partners-vesca .partner-more span {
            font-size: 11px;
        }

        .partners-vesca .partner-more small {
            font-size: 8px;
        }
    }

    /* HP: SUSUNAN MENYESUAIKAN LAYAR */
    @media (max-width: 600px) {
        .partners-vesca {
            padding: 40px 12px 50px;
        }

        .partners-vesca .partners-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            grid-template-rows: auto;
            gap: 8px;
        }

        .partners-vesca .partner-logo {
            height: 105px;
            padding: 6px;
        }

        .partners-vesca .partner-logo img {
            width: 135px;
            height: 80px;
        }

        .partners-vesca .partner-more strong {
            font-size: 32px;
        }

        .partners-vesca .partner-more span {
            font-size: 13px;
        }
    }
</style>

@endsection