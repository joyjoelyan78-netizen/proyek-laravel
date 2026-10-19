
@extends('layouts.frontend')

@section('content')

<link rel="stylesheet" href="/css/hubungi-kami.css">

<section class="kontak-page">
    <div class="kontak-container">

        <div class="kontak-heading">
            <span class="kontak-label">VESCA ALUMINIUM & ZINC</span>
            <h1>Hubungi Kami</h1>
            <p>
                Kami siap membantu Anda mendapatkan informasi mengenai
                produk, layanan, dan kebutuhan perlindungan korosi.
            </p>
        </div>

        {{-- PETA LOKASI --}}
        <div class="kontak-map">
            <iframe
                src="https://www.google.com/maps?q=Vescarindo+Utama+PT,+Jl.+Pangkalan+II+No.RT.+04,+RT.004%2FRW.03,+Cikiwul,+Kec.+Bantar+Gebang,+Kota+Bekasi,+Jawa+Barat+17152&output=embed"
                title="Lokasi PT Vescarindo Utama"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen>
            </iframe>
        </div>

        <div class="kontak-box">

            {{-- INFORMASI KONTAK --}}
            <div class="kontak-info">
                <h2>Mari Terhubung</h2>

                <p>
                    Punya pertanyaan mengenai produk Aluminium dan Zinc
                    untuk kebutuhan industri atau kelautan?
                    Hubungi tim kami melalui informasi berikut.
                </p>

                <div class="kontak-detail">
                    <div class="kontak-icon">📍</div>
                    <div>
                        <h3>Alamat</h3>
                        <p>
                            Jl. Narogong KM. 12, Pangkalan 2, Cikiwul, Bantar Gebang, Bekasi
                        </p>
                    </div>
                </div>

                <div class="kontak-detail">
                    <div class="kontak-icon">📞</div>
                    <div>
                        <h3>Telepon / WhatsApp</h3>
                        <p>Silakan hubungi tim kami untuk informasi lebih lanjut.</p>
                    </div>
                </div>

                <div class="kontak-detail">
                    <div class="kontak-icon">✉️</div>
                    <div>
                        <h3>Email</h3>
                        <p>Silakan gunakan alamat email resmi perusahaan.</p>
                    </div>
                </div>

                <div class="line"></div>

                <a
                    href="https://www.google.com/maps?q=JL.%20H.%20Gemon%20No.%2039%20Pondok%20Kelapa%20Timur%2013450"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-lokasi">
                    Lihat Lokasi di Google Maps
                </a>
            </div>

            {{-- FORM KONTAK --}}
            <div class="kontak-form">
                <h2>Kirim Pertanyaan</h2>
                <p class="form-description">
                    Isi formulir berikut untuk menyampaikan pertanyaan
                    kepada tim PT Vescarindo Utama.
                </p>

                <form action="#" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="Masukkan nama Anda"
                            value="{{ old('nama') }}"
                            required>
                    </div>

                    <div class="form-flex">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input
                                type="tel"
                                id="telepon"
                                name="telepon"
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('telepon') }}"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subjek">Subjek Pertanyaan</label>
                        <select id="subjek" name="subjek" required>
                            <option value="">Pilih kebutuhan Anda</option>
                            <option value="Informasi Produk">Informasi Produk</option>
                            <option value="Permintaan Penawaran">Permintaan Penawaran</option>
                            <option value="Layanan">Layanan</option>
                            <option value="Klaim Garansi">Klaim Garansi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea
                            id="pesan"
                            name="pesan"
                            rows="5"
                            placeholder="Tuliskan pertanyaan Anda..."
                            required>{{ old('pesan') }}</textarea>
                    </div>

                    <button type="submit">
                        Kirim Pertanyaan →
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
