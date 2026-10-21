
@extends('layouts.frontend')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush

@section('content')

@php
    $galleryItems = [
        [
            'image' => 'Aluminium.png',
            'category' => 'produk',
            'title' => 'Anoda Aluminium',
            'description' => 'Dokumentasi produk anoda Aluminium untuk kebutuhan proteksi korosi.',
        ],
        [
            'image' => 'Zinc Weldin.png',
            'category' => 'produk',
            'title' => 'Anoda Zinc',
            'description' => 'Dokumentasi produk anoda Zinc untuk aplikasi proteksi katodik.',
        ],
        [
            'image' => 'Proses produksi.jpeg',
            'category' => 'produksi',
            'title' => 'Proses Produksi',
            'description' => 'Dokumentasi tahapan proses pembuatan produk VESCA.',
        ],
        [
            'image' => 'bahan baku nystar.jpeg',
            'category' => 'produksi',
            'title' => 'Persiapan Bahan Baku',
            'description' => 'Dokumentasi persiapan bahan baku sebelum proses produksi.',
        ],
        [
            'image' => 'hasil lab.jpeg',
            'category' => 'laboratorium',
            'title' => 'Pengujian Laboratorium',
            'description' => 'Dokumentasi hasil pengujian laboratorium produk.',
        ],
        [
            'image' => 'QC.jpeg',
            'category' => 'laboratorium',
            'title' => 'Pemeriksaan Kualitas',
            'description' => 'Dokumentasi pemeriksaan kualitas atau quality control.',
        ],
        [
            'image' => 'alat2nya.jpeg',
            'category' => 'fasilitas',
            'title' => 'Fasilitas Perusahaan',
            'description' => 'Dokumentasi fasilitas dan peralatan operasional perusahaan.',
        ],
        [
            'image' => 'aktivitas produksi.jpeg',
            'category' => 'produksi',
            'title' => 'Aktivitas Produksi',
            'description' => 'Dokumentasi aktivitas operasional di area produksi.',
        ],
    ];
@endphp

<div class="gallery-page">

    {{-- HERO --}}
    <section class="gallery-hero">
        <div class="gallery-hero-content">
            <span class="gallery-eyebrow">
                VESCA · OUR GALLERY
            </span>

            <h1>
                Mengenal Lebih Dekat<br>
                <span>Proses &amp; Kualitas Kami</span>
            </h1>

            <p>
                Dokumentasi produk Aluminium dan Zinc, proses produksi,
                pengujian laboratorium, serta fasilitas PT Vescarindo Utama.
            </p>
        </div>
    </section>

    {{-- GALERI --}}
    <section class="gallery-section">
        <div class="gallery-container">

            <div class="gallery-section-heading">
                <div>
                    <div class="gallery-heading-line"></div>
                    <h2>Dokumentasi Kami</h2>
                    <p>
                        Lihat lebih dekat produk, proses kerja,
                        dan fasilitas perusahaan kami.
                    </p>
                </div>
            </div>

            {{-- FILTER KATEGORI --}}
            <div
                class="gallery-filters"
                role="group"
                aria-label="Filter kategori galeri"
            >
                <button
                    type="button"
                    class="gallery-filter active"
                    data-filter="semua"
                    aria-pressed="true"
                >
                    Semua
                </button>

                <button
                    type="button"
                    class="gallery-filter"
                    data-filter="produk"
                    aria-pressed="false"
                >
                    Produk
                </button>

                <button
                    type="button"
                    class="gallery-filter"
                    data-filter="produksi"
                    aria-pressed="false"
                >
                    Proses Produksi
                </button>

                <button
                    type="button"
                    class="gallery-filter"
                    data-filter="laboratorium"
                    aria-pressed="false"
                >
                    Uji Laboratorium
                </button>

                <button
                    type="button"
                    class="gallery-filter"
                    data-filter="fasilitas"
                    aria-pressed="false"
                >
                    Fasilitas
                </button>
            </div>

            {{-- KARTU FOTO --}}
            <div class="gallery-grid" id="galleryGrid">

                @foreach ($galleryItems as $item)
                    <article
                        class="gallery-card"
                        data-category="{{ $item['category'] }}"
                    >
                        <div
                            class="gallery-image"
                            role="button"
                            tabindex="0"
                            aria-label="Lihat foto {{ $item['title'] }}"
                            data-image="{{ asset('image/' . $item['image']) }}"
                            data-title="{{ $item['title'] }}"
                            data-description="{{ $item['description'] }}"
                        >
                            <img
                                src="{{ asset('image/' . $item['image']) }}"
                                alt="{{ $item['title'] }}"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >

                            <div
                                class="gallery-image-fallback"
                                style="display: none;"
                            >
                                <span aria-hidden="true">▧</span>
                                <span>{{ $item['image'] }}</span>
                                <span>Foto tidak ditemukan</span>
                            </div>

                            <span class="gallery-zoom" aria-hidden="true">
                                +
                            </span>
                        </div>

                        <div class="gallery-info">
                            <span class="gallery-category">
                                @switch($item['category'])
                                    @case('produk')
                                        Produk
                                        @break

                                    @case('produksi')
                                        Proses Produksi
                                        @break

                                    @case('laboratorium')
                                        Uji Laboratorium
                                        @break

                                    @case('fasilitas')
                                        Fasilitas
                                        @break
                                @endswitch
                            </span>

                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['description'] }}</p>
                        </div>
                    </article>
                @endforeach

            </div>

            {{-- CTA HUBUNGI KAMI --}}
            <div class="gallery-cta">
                <div>
                    <h2>Butuh Informasi Produk?</h2>
                    <p>
                        Hubungi tim kami untuk konsultasi mengenai anoda
                        Aluminium, Zinc, dan kebutuhan proteksi korosi.
                    </p>
                </div>

                <a href="{{ route('hubungi') }}">
                    Hubungi Kami <span aria-hidden="true">→</span>
                </a>
            </div>

        </div>
    </section>

    {{-- LIGHTBOX: FOTO UKURAN BESAR --}}
    <div
        class="gallery-lightbox"
        id="galleryLightbox"
        role="dialog"
        aria-modal="true"
        aria-label="Detail foto galeri"
        aria-hidden="true"
    >
        <button
            type="button"
            class="gallery-lightbox-close"
            id="galleryLightboxClose"
            aria-label="Tutup foto"
        >
            &times;
        </button>

        <div class="gallery-lightbox-content">
            <img
                src=""
                alt=""
                id="galleryLightboxImage"
            >

            <h3 id="galleryLightboxTitle"></h3>
            <p id="galleryLightboxDescription"></p>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filters = document.querySelectorAll('.gallery-filter');
    const cards = document.querySelectorAll('.gallery-card');

    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImage = document.getElementById('galleryLightboxImage');
    const lightboxTitle = document.getElementById('galleryLightboxTitle');
    const lightboxDescription =
        document.getElementById('galleryLightboxDescription');
    const closeButton =
        document.getElementById('galleryLightboxClose');

    let lastFocusedElement = null;

    // FILTER KATEGORI
    filters.forEach(function (button) {
        button.addEventListener('click', function () {
            const selected = button.dataset.filter;

            filters.forEach(function (filter) {
                const active = filter === button;

                filter.classList.toggle('active', active);
                filter.setAttribute('aria-pressed', String(active));
            });

            cards.forEach(function (card) {
                card.hidden =
                    selected !== 'semua' &&
                    card.dataset.category !== selected;
            });
        });
    });

    // BUKA LIGHTBOX
    function openLightbox(element) {
        const imageUrl = element.dataset.image;
        const image = new Image();

        lastFocusedElement = element;

        image.onload = function () {
            lightboxImage.src = imageUrl;
            lightboxImage.alt = element.dataset.title;
            lightboxTitle.textContent = element.dataset.title;
            lightboxDescription.textContent =
                element.dataset.description;

            lightbox.classList.add('open');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            closeButton.focus();
        };

        image.onerror = function () {
            alert(
                'Foto "' + element.dataset.title +
                '" tidak ditemukan. Periksa nama file di public/image/.'
            );
        };

        image.src = imageUrl;
    }

    // TUTUP LIGHTBOX
    function closeLightbox() {
        lightbox.classList.remove('open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImage.src = '';
        document.body.style.overflow = '';

        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    }

    // KLIK ATAU KEYBOARD UNTUK MEMBUKA FOTO
    document.querySelectorAll('.gallery-image').forEach(function (element) {
        element.addEventListener('click', function () {
            openLightbox(element);
        });

        element.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openLightbox(element);
            }
        });
    });

    closeButton.addEventListener('click', closeLightbox);

    // KLIK AREA GELAP UNTUK MENUTUP
    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });

    // TOMBOL ESCAPE UNTUK MENUTUP
    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape' &&
            lightbox.classList.contains('open')
        ) {
            closeLightbox();
        }
    });
});
</script>
@endpush
