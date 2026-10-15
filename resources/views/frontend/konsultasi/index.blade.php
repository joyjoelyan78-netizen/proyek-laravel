@extends('layouts.frontend')

@section('content')

<link rel="stylesheet" href="/css/layanan-form.css">

@php
    $wa = preg_replace('/\D+/', '', (string) config('vesca.whatsapp'));
    $alu = $bahan['aluminium'];
    $zn  = $bahan['zinc'];
@endphp

<section class="lf-page">

    <div class="lf-container">

        {{-- HERO --}}
        <div class="lf-hero">

            <h1>Konsultasi &amp; Spesifikasi Teknis</h1>

            <p>
                Lihat data teknis lengkap anoda VESCA, mulai dari perbandingan
                Zinc dan Aluminium, tabel ukuran semua tipe, sampai sertifikasi.
                Masih ragu memilih? Kirim pertanyaan ke tim teknis kami.
            </p>

        </div>

        {{-- NAV CEPAT --}}
        <div class="lf-quicknav">
            <a href="#panduan">Zinc atau Aluminium?</a>
            <a href="#spesifikasi">Tabel Spesifikasi</a>
            <a href="#material">Komposisi Material</a>
            <a href="#sertifikasi">Sertifikasi</a>
            <a href="#faq">Pertanyaan Umum</a>
            <a href="#form-konsultasi">Kirim Pertanyaan</a>
        </div>


        {{-- ================= PERBANDINGAN ================= --}}
        <div class="lf-block" id="panduan">

            <h2>Zinc atau Aluminium?</h2>

            <p class="lf-lead">
                Keduanya adalah anoda korban (sacrificial anode): anoda yang terkikis
                lebih dulu supaya badan kapal atau struktur baja tetap terlindungi.
                Berikut data performa nominal dari katalog kami.
            </p>

            <div class="lf-compare">

                <div class="lf-compare-card">
                    <h3>{{ $alu['nama'] }}</h3>
                    <p class="lf-bahan-ringkasan" style="margin:0;">{{ $alu['ringkasan'] }}</p>
                </div>

                <div class="lf-compare-card">
                    <h3>{{ $zn['nama'] }}</h3>
                    <p class="lf-bahan-ringkasan" style="margin:0;">{{ $zn['ringkasan'] }}</p>
                </div>

            </div>

            <div class="lf-table-wrap" style="margin-top:22px;">

                <table class="lf-table lf-banding">

                    <thead>
                        <tr>
                            <th>Data performa nominal</th>
                            <th>{{ $alu['nama'] }}</th>
                            <th>{{ $zn['nama'] }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($alu['performa'] as $label => $nilai)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $nilai }}</td>
                                <td>{{ $zn['performa'][$label] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

            <p class="lf-baca">
                <strong>Cara membacanya:</strong>
                kapasitas listrik seperti &quot;isi baterai&quot; per kilogram anoda, makin besar
                makin banyak arus yang bisa diberikan. Laju konsumsi menunjukkan berapa kilogram
                anoda yang habis untuk setiap ampere arus selama setahun, makin kecil makin awet
                per kilogramnya.
            </p>

            <div class="lf-disclaimer">
                Ini data nominal dari katalog. Pilihan akhir bergantung pada kondisi air,
                ukuran kapal atau struktur, dan lama proteksi yang diinginkan. Tim teknis kami
                bisa membantu menentukannya, silakan kirim pertanyaan di bawah.
            </div>

        </div>


        {{-- ================= TABEL SPESIFIKASI (dari katalog) ================= --}}
        <div class="lf-block" id="spesifikasi">

            <h2>Tabel Spesifikasi Produk</h2>

            <p class="lf-lead">
                Pilih jenis anoda, lalu klik <strong>Minta penawaran</strong> di baris tipe yang Anda butuhkan.
                Geser tabel ke samping jika terpotong di layar kecil.
            </p>

            <div class="lf-tabs" role="tablist">
                <button type="button" class="lf-tab active" data-panel="panel-aluminium">Aluminium Anode</button>
                <button type="button" class="lf-tab" data-panel="panel-zinc">Zinc Anode</button>
            </div>

            @foreach (['aluminium', 'zinc'] as $kodeBahan)

                <div class="lf-panel {{ $kodeBahan === 'aluminium' ? 'active' : '' }}" id="panel-{{ $kodeBahan }}">

                    @foreach ($seriList as $kodeSeri => $seri)

                        @if ($seri['bahan'] === $kodeBahan)

                            <div class="lf-kategori-title" id="seri-{{ $kodeSeri }}">{{ $seri['nama'] }}</div>

                            <p class="lf-seri-desc">{{ $seri['deskripsi'] }}</p>

                            <div class="lf-table-wrap">

                                <table class="lf-table">

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
                                            <tr>
                                                @foreach ($baris as $i => $nilai)
                                                    <td class="{{ $i === 0 ? 'lf-kode' : '' }}">{{ $nilai }}</td>
                                                @endforeach
                                                <td class="lf-aksi">
                                                    <a href="{{ route('penawaran.index', ['seri' => $kodeSeri, 'tipe' => $baris[0]]) }}">
                                                        Minta penawaran
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @endif

                    @endforeach

                </div>

            @endforeach

        </div>


        {{-- ================= KOMPOSISI MATERIAL ================= --}}
        <div class="lf-block" id="material">

            <h2>Komposisi Material</h2>

            <p class="lf-lead">Komposisi paduan anoda sesuai katalog.</p>

            <div class="lf-komposisi">

                @foreach ([$alu, $zn] as $b)

                    <div>

                        <h3>{{ $b['nama'] }}</h3>

                        <div class="lf-table-wrap">

                            <table class="lf-table">

                                <thead>
                                    <tr>
                                        @foreach ($b['komposisi_kolom'] as $judul)
                                            <th>{{ $judul }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($b['komposisi'] as $baris)
                                        <tr>
                                            @foreach ($baris as $nilai)
                                                <td>{{ $nilai }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- ================= SERTIFIKASI ================= --}}
        <div class="lf-block" id="sertifikasi">

            <h2>Sertifikasi &amp; Kontrol Kualitas</h2>

            <p class="lf-lead">
                Sertifikat yang tercantum di katalog PT Vescarindo Utama.
                Komposisi material dianalisis dengan mesin spectrometer dan
                potensial anoda diuji, seperti didokumentasikan di katalog kami.
            </p>

            <div class="lf-sertifikat">

                @foreach ($sertifikat as $sert)

                    <div class="lf-sert-card">

                        <div class="lf-sert-lembaga">{{ $sert['lembaga'] }}</div>

                        <h3>{{ $sert['judul'] }}</h3>

                        <dl>
                            @foreach ($sert['detail'] as $label => $nilai)
                                <dt>{{ $label }}</dt>
                                <dd>{{ $nilai }}</dd>
                            @endforeach
                        </dl>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- ================= FAQ ================= --}}
        <div class="lf-block lf-faq" id="faq">

            <h2>Pertanyaan Umum</h2>

            <p class="lf-lead">Jawaban singkat sebelum Anda mengirim pertanyaan.</p>

            <details>
                <summary>Apa yang perlu saya siapkan sebelum berkonsultasi?</summary>
                <p>
                    Jenis dan ukuran kapal (atau struktur), bagian yang ingin dilindungi,
                    serta kondisi air tempat beroperasi. Jika ada, sebutkan juga tipe anoda
                    yang terpasang saat ini.
                </p>
            </details>

            <details>
                <summary>Saya belum tahu tipe yang cocok. Apakah tetap bisa bertanya?</summary>
                <p>
                    Bisa. Cukup ceritakan kondisi kapal atau struktur Anda, lalu tim teknis
                    kami yang akan merekomendasikan seri dan tipenya.
                </p>
            </details>

            <details>
                <summary>Bagaimana jika ukuran yang saya butuhkan tidak ada di tabel?</summary>
                <p>
                    Tulis kebutuhan Anda di formulir
                    <a href="{{ route('penawaran.index') }}">Minta Penawaran Resmi</a>
                    dengan memilih &quot;ukuran khusus (custom)&quot;, atau sampaikan lewat formulir di bawah.
                </p>
            </details>

            <details>
                <summary>Berapa lama saya mendapat jawaban?</summary>
                <p>
                    Estimasi respon kami {{ config('vesca.sla_respon') }}, melalui email
                    atau WhatsApp sesuai kontak yang Anda isi.
                </p>
            </details>

            <details>
                <summary>Saya sudah tahu kebutuhannya dan ingin langsung meminta harga.</summary>
                <p>
                    Silakan gunakan formulir
                    <a href="{{ route('penawaran.index') }}">Minta Penawaran Resmi</a>.
                </p>
            </details>

        </div>


        {{-- ================= FORM KONSULTASI ================= --}}
        <div class="lf-block" id="form-konsultasi">

            <h2>Kirim Pertanyaan ke Tim Teknis</h2>

            <p class="lf-lead">
                Isi data berikut. Kolom bertanda <span class="lf-req">*</span> wajib diisi.
            </p>

            @if ($errors->any())

                <div class="lf-alert lf-alert-error">

                    Formulir belum lengkap. Mohon periksa kembali isian berikut:

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif

            <form action="{{ route('konsultasi.store') }}" method="POST">

                @csrf

                {{-- jebakan bot: harus tetap kosong --}}
                <div class="lf-hp" aria-hidden="true">
                    <label>Website</label>
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="lf-grid-2">

                    <div class="lf-field @error('nama_pengirim') has-error @enderror">
                        <label for="nama_pengirim">Nama Lengkap <span class="lf-req">*</span></label>
                        <input type="text" id="nama_pengirim" name="nama_pengirim"
                               value="{{ old('nama_pengirim') }}"
                               placeholder="Nama Anda" required>
                        @error('nama_pengirim') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('nama_perusahaan') has-error @enderror">
                        <label for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" id="nama_perusahaan" name="nama_perusahaan"
                               value="{{ old('nama_perusahaan') }}"
                               placeholder="PT / CV / instansi (jika ada)">
                        @error('nama_perusahaan') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('email') has-error @enderror">
                        <label for="email">Email <span class="lf-req">*</span></label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@perusahaan.com" required>
                        @error('email') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('nomor_telepon') has-error @enderror">
                        <label for="nomor_telepon">Nomor Telepon / WhatsApp <span class="lf-req">*</span></label>
                        <input type="tel" id="nomor_telepon" name="nomor_telepon"
                               value="{{ old('nomor_telepon') }}"
                               placeholder="0812xxxxxxxx" required>
                        @error('nomor_telepon') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('jenis_kapal') has-error @enderror">
                        <label for="jenis_kapal">Jenis Kapal / Struktur <span class="lf-req">*</span></label>
                        <input type="text" id="jenis_kapal" name="jenis_kapal"
                               value="{{ old('jenis_kapal') }}"
                               placeholder="Contoh: tanker, tongkang, kapal feri, dermaga" required>
                        @error('jenis_kapal') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('ukuran_kapal') has-error @enderror">
                        <label for="ukuran_kapal">Ukuran Kapal</label>
                        <input type="text" id="ukuran_kapal" name="ukuran_kapal"
                               value="{{ old('ukuran_kapal') }}"
                               placeholder="Contoh: panjang 60 m atau 3000 GT">
                        @error('ukuran_kapal') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('bagian_dilindungi') has-error @enderror">
                        <label for="bagian_dilindungi">Bagian yang Ingin Dilindungi</label>
                        <select id="bagian_dilindungi" name="bagian_dilindungi">
                            <option value="">-- Pilih bagian --</option>
                            @foreach (\App\Models\KonsultasiTeknis::BAGIAN_DILINDUNGI as $bagian)
                                <option value="{{ $bagian }}" @selected(old('bagian_dilindungi') === $bagian)>
                                    {{ $bagian }}
                                </option>
                            @endforeach
                        </select>
                        @error('bagian_dilindungi') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('kondisi_air') has-error @enderror">
                        <label for="kondisi_air">Kondisi Air <span class="lf-req">*</span></label>
                        <select id="kondisi_air" name="kondisi_air" required>
                            <option value="">-- Pilih kondisi air --</option>
                            @foreach (\App\Models\KonsultasiTeknis::KONDISI_AIR as $nilai => $label)
                                <option value="{{ $nilai }}" @selected(old('kondisi_air') === $nilai)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('kondisi_air') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="lf-field @error('produk_diminati') has-error @enderror">
                    <label for="produk_diminati">Seri Produk yang Diminati (opsional)</label>
                    <select id="produk_diminati" name="produk_diminati">
                        <option value="">-- Pilih jika sudah tahu --</option>
                        @foreach ($pilihanSeri as $kodeSeri => $labelSeri)
                            <option value="{{ $kodeSeri }}"
                                @selected(old('produk_diminati', $seriTerpilih) === $kodeSeri)>
                                {{ $labelSeri }}
                            </option>
                        @endforeach
                    </select>
                    @error('produk_diminati') <span class="lf-error">{{ $message }}</span> @enderror
                </div>

                <div class="lf-field @error('pertanyaan') has-error @enderror">
                    <label for="pertanyaan">Pertanyaan / Kebutuhan Anda <span class="lf-req">*</span></label>
                    <textarea id="pertanyaan" name="pertanyaan" rows="5"
                              placeholder="Ceritakan kondisi kapal, masalah korosi yang dihadapi, atau hal yang ingin Anda ketahui"
                              required>{{ old('pertanyaan') }}</textarea>
                    @error('pertanyaan') <span class="lf-error">{{ $message }}</span> @enderror
                </div>

                <div class="lf-actions" style="justify-content:flex-start;margin-top:8px;">

                    <button type="submit" class="lf-btn">
                        <i class="fas fa-paper-plane"></i> Kirim Pertanyaan
                    </button>

                    @if ($wa)
                        <a class="lf-btn lf-btn-wa"
                           href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Halo PT Vescarindo Utama, saya ingin berkonsultasi mengenai anoda untuk kapal saya.') }}"
                           target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                        </a>
                    @endif

                </div>

            </form>

            <div class="lf-kontak-cta">

                <span><strong>Atau hubungi langsung:</strong></span>

                @foreach (config('vesca.telepon') as $tel)
                    @if ($tel)
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $tel) }}">
                            <i class="fas fa-phone"></i> {{ $tel }}
                        </a>
                    @endif
                @endforeach

                @if (config('vesca.email'))
                    <a href="mailto:{{ config('vesca.email') }}">
                        <i class="fas fa-envelope"></i> {{ config('vesca.email') }}
                    </a>
                @endif

            </div>

        </div>

    </div>

</section>

<script>
(function () {

    var tabs   = document.querySelectorAll('.lf-tab');
    var panels = document.querySelectorAll('.lf-panel');

    tabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            tabs.forEach(function (t) { t.classList.remove('active'); });
            panels.forEach(function (p) { p.classList.remove('active'); });

            tab.classList.add('active');
            document.getElementById(tab.getAttribute('data-panel')).classList.add('active');
        });
    });

})();
</script>

@endsection
