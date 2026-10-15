@extends('layouts.frontend')

@section('content')

<link rel="stylesheet" href="/css/layanan-form.css">

<section class="lf-page">

    <div class="lf-container">

        {{-- HERO --}}
        <div class="lf-hero">

            <h1>Minta Penawaran Resmi</h1>

            <p>
                Sampaikan kebutuhan anoda Aluminium atau Zinc Anda.
                Tim kami akan menyiapkan surat penawaran resmi dan
                mengirimkannya melalui email atau WhatsApp.
            </p>

        </div>

        <div class="lf-layout">

            {{-- ================= FORM ================= --}}
            <div class="lf-card">

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

                <form action="{{ route('penawaran.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    {{-- jebakan bot: harus tetap kosong --}}
                    <div class="lf-hp" aria-hidden="true">
                        <label>Website</label>
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>


                    {{-- ===== 1. DATA PEMOHON ===== --}}
                    <div class="lf-section-title">
                        <i class="fas fa-user"></i> Data Pemohon
                    </div>

                    <div class="lf-grid-2">

                        <div class="lf-field @error('nama_pemohon') has-error @enderror">
                            <label for="nama_pemohon">Nama Lengkap <span class="lf-req">*</span></label>
                            <input type="text" id="nama_pemohon" name="nama_pemohon"
                                   value="{{ old('nama_pemohon') }}"
                                   placeholder="Nama Anda" required>
                            @error('nama_pemohon') <span class="lf-error">{{ $message }}</span> @enderror
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

                    </div>


                    {{-- ===== 2. RINCIAN KEBUTUHAN (sesuai katalog) ===== --}}
                    <div class="lf-section-title">
                        <i class="fas fa-box"></i> Rincian Kebutuhan
                    </div>

                    <p class="lf-hint" style="margin:-6px 0 18px;">
                        Pilih seri dan tipe sesuai katalog VESCA, lalu isi jumlahnya.
                        Butuh beberapa tipe sekaligus? Klik <strong>Tambah item</strong>.
                        Ukuran di luar katalog? Pilih <strong>ukuran khusus (custom)</strong>
                        dan tulis spesifikasinya.
                    </p>

                    @error('items') <span class="lf-error" style="margin-bottom:12px;">{{ $message }}</span> @enderror

                    <div id="item-list"></div>

                    <button type="button" id="tambah-item" class="lf-btn lf-btn-outline lf-btn-small">
                        <i class="fas fa-plus"></i> Tambah item
                    </button>

                    <div id="ringkasan-item" class="lf-hint" style="margin:14px 0 4px;"></div>


                    {{-- ===== 3. TUJUAN & PENGIRIMAN ===== --}}
                    <div class="lf-section-title">
                        <i class="fas fa-ship"></i> Tujuan &amp; Pengiriman
                    </div>

                    <div class="lf-grid-2">

                        <div class="lf-field @error('jenis_kapal') has-error @enderror">
                            <label for="jenis_kapal">Untuk Kapal / Struktur Apa</label>
                            <input type="text" id="jenis_kapal" name="jenis_kapal"
                                   value="{{ old('jenis_kapal') }}"
                                   placeholder="Contoh: tongkang, tanker, dermaga">
                            @error('jenis_kapal') <span class="lf-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="lf-field @error('lokasi_pengiriman') has-error @enderror">
                            <label for="lokasi_pengiriman">Lokasi Pengiriman <span class="lf-req">*</span></label>
                            <input type="text" id="lokasi_pengiriman" name="lokasi_pengiriman"
                                   value="{{ old('lokasi_pengiriman') }}"
                                   placeholder="Kota / pelabuhan tujuan" required>
                            @error('lokasi_pengiriman') <span class="lf-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="lf-field @error('tanggal_dibutuhkan') has-error @enderror">
                            <label for="tanggal_dibutuhkan">Target Tanggal Dibutuhkan</label>
                            <input type="date" id="tanggal_dibutuhkan" name="tanggal_dibutuhkan"
                                   value="{{ old('tanggal_dibutuhkan') }}"
                                   min="{{ now()->format('Y-m-d') }}">
                            @error('tanggal_dibutuhkan') <span class="lf-error">{{ $message }}</span> @enderror
                        </div>

                    </div>


                    {{-- ===== 4. LAMPIRAN & CATATAN ===== --}}
                    <div class="lf-section-title">
                        <i class="fas fa-paperclip"></i> Lampiran &amp; Catatan
                    </div>

                    <div class="lf-field @error('file_lampiran') has-error @enderror">
                        <label for="file_lampiran">Lampiran (opsional)</label>
                        <input type="file" id="file_lampiran" name="file_lampiran"
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                        <span class="lf-hint">
                            Gambar teknis atau daftar kebutuhan. Format PDF, JPG, PNG, Word, atau Excel. Maksimal 5 MB.
                        </span>
                        @error('file_lampiran') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="lf-field @error('catatan') has-error @enderror">
                        <label for="catatan">Catatan Tambahan</label>
                        <textarea id="catatan" name="catatan" rows="4"
                                  placeholder="Informasi lain yang perlu kami ketahui">{{ old('catatan') }}</textarea>
                        @error('catatan') <span class="lf-error">{{ $message }}</span> @enderror
                    </div>


                    <button type="submit" class="lf-btn lf-btn-block">
                        <i class="fas fa-paper-plane"></i> Kirim Permintaan
                    </button>

                </form>

            </div>


            {{-- ================= SIDEBAR ================= --}}
            <aside class="lf-side">

                <h3>Bagaimana prosesnya?</h3>

                <ol class="lf-steps">

                    <li>
                        <span class="lf-num">1</span>
                        <span>Isi formulir ini dan kirim. Anda akan mendapat nomor permintaan.</span>
                    </li>

                    <li>
                        <span class="lf-num">2</span>
                        <span>Tim kami meninjau kebutuhan Anda dan menghitung penawaran.</span>
                    </li>

                    <li>
                        <span class="lf-num">3</span>
                        <span>Surat penawaran resmi dikirim melalui email atau WhatsApp.</span>
                    </li>

                </ol>

                <p class="lf-note">
                    Estimasi respon: {{ config('vesca.sla_respon') }}.
                    Mengirim permintaan ini belum merupakan pemesanan.
                </p>

                <p class="lf-note">
                    Belum yakin produk yang tepat?
                    <a href="{{ route('konsultasi.index') }}">Konsultasi dulu dengan tim teknis kami</a>.
                    Lihat juga <a href="{{ route('konsultasi.index') }}#spesifikasi">tabel spesifikasi lengkap</a>.
                </p>

                <p class="lf-note">
                    <strong>Hubungi langsung</strong><br>
                    @foreach (config('vesca.telepon') as $tel)
                        @if ($tel)
                            <i class="fas fa-phone"></i> {{ $tel }}<br>
                        @endif
                    @endforeach
                    @if (config('vesca.email'))
                        <i class="fas fa-envelope"></i> {{ config('vesca.email') }}
                    @endif
                </p>

            </aside>

        </div>

    </div>

</section>

<script>
(function () {

    var KATALOG = @json($picker);
    var AWAL    = @json($awal);

    var list      = document.getElementById('item-list');
    var tombol    = document.getElementById('tambah-item');
    var ringkasan = document.getElementById('ringkasan-item');
    var counter   = 0;

    function el(tag, className) {
        var e = document.createElement(tag);
        if (className) { e.className = className; }
        return e;
    }

    function opsi(value, teks, dipilih) {
        var o = el('option');
        o.value = value;
        o.textContent = teks;
        if (dipilih) { o.selected = true; }
        return o;
    }

    function hitungRingkasan() {
        var jumlahItem = list.querySelectorAll('.lf-item').length;
        var totalPcs = 0;
        list.querySelectorAll('input[name$="[jumlah]"]').forEach(function (i) {
            totalPcs += parseInt(i.value, 10) || 0;
        });
        ringkasan.textContent = jumlahItem + ' item, total ' + totalPcs + ' pcs';
    }

    function tambahItem(data) {

        data = data || {};
        var idx = counter++;
        var baris = el('div', 'lf-item');

        // --- seri ---
        var seriSel = el('select');
        seriSel.name = 'items[' + idx + '][seri]';
        seriSel.required = true;
        seriSel.setAttribute('aria-label', 'Seri produk');
        seriSel.appendChild(opsi('', '-- Pilih seri produk --', false));

        [['aluminium', 'Aluminium Anode'], ['zinc', 'Zinc Anode']].forEach(function (b) {
            var g = document.createElement('optgroup');
            g.label = b[1];
            Object.keys(KATALOG).forEach(function (k) {
                if (KATALOG[k].bahan === b[0]) {
                    g.appendChild(opsi(k, KATALOG[k].label, data.seri === k));
                }
            });
            seriSel.appendChild(g);
        });

        // --- tipe: dropdown (katalog) atau teks bebas (custom) ---
        var tipeSel = el('select');
        tipeSel.name = 'items[' + idx + '][tipe]';
        tipeSel.setAttribute('aria-label', 'Tipe produk');

        var tipeTxt = el('input');
        tipeTxt.type = 'text';
        tipeTxt.name = 'items[' + idx + '][tipe]';
        tipeTxt.placeholder = 'Tulis dimensi / spesifikasi yang dibutuhkan';
        tipeTxt.maxLength = 150;
        tipeTxt.setAttribute('aria-label', 'Spesifikasi khusus');

        var jumlah = el('input');
        jumlah.type = 'number';
        jumlah.name = 'items[' + idx + '][jumlah]';
        jumlah.min = 1;
        jumlah.placeholder = 'Jumlah (pcs)';
        jumlah.required = true;
        jumlah.setAttribute('aria-label', 'Jumlah');
        if (data.jumlah) { jumlah.value = data.jumlah; }

        var hapus = el('button', 'lf-item-hapus');
        hapus.type = 'button';
        hapus.title = 'Hapus item';
        hapus.setAttribute('aria-label', 'Hapus item');
        hapus.innerHTML = '<i class="fas fa-trash"></i>';

        var info = el('div', 'lf-item-info');

        function tampilInfo() {
            var s = KATALOG[seriSel.value];
            info.textContent = '';
            if (!s || s.custom) { return; }
            for (var i = 0; i < s.tipe.length; i++) {
                if (s.tipe[i].kode === tipeSel.value) {
                    info.textContent = s.tipe[i].ringkas;
                    break;
                }
            }
        }

        function isiTipe(pilihan) {
            var s = KATALOG[seriSel.value];
            tipeSel.innerHTML = '';
            info.textContent = '';

            if (!s) {
                tipeSel.style.display = '';
                tipeSel.disabled = true;
                tipeSel.required = false;
                tipeSel.appendChild(opsi('', '-- Pilih seri dulu --', false));
                tipeTxt.style.display = 'none';
                tipeTxt.disabled = true;
                return;
            }

            if (s.custom) {
                tipeSel.style.display = 'none';
                tipeSel.disabled = true;
                tipeSel.required = false;
                tipeTxt.style.display = '';
                tipeTxt.disabled = false;
                tipeTxt.required = true;
                if (pilihan) { tipeTxt.value = pilihan; }
                return;
            }

            tipeTxt.style.display = 'none';
            tipeTxt.disabled = true;
            tipeTxt.required = false;
            tipeSel.style.display = '';
            tipeSel.disabled = false;
            tipeSel.required = true;
            tipeSel.appendChild(opsi('', '-- Pilih tipe --', false));
            s.tipe.forEach(function (t) {
                tipeSel.appendChild(opsi(t.kode, t.kode, pilihan === t.kode));
            });
            tampilInfo();
        }

        seriSel.addEventListener('change', function () { isiTipe(''); });
        tipeSel.addEventListener('change', tampilInfo);
        jumlah.addEventListener('input', hitungRingkasan);

        hapus.addEventListener('click', function () {
            if (list.querySelectorAll('.lf-item').length > 1) {
                baris.remove();
            } else {
                seriSel.value = '';
                isiTipe('');
                jumlah.value = '';
            }
            hitungRingkasan();
        });

        var kolomSeri = el('div', 'lf-item-col');
        kolomSeri.appendChild(seriSel);

        var kolomTipe = el('div', 'lf-item-col');
        kolomTipe.appendChild(tipeSel);
        kolomTipe.appendChild(tipeTxt);

        var kolomJumlah = el('div', 'lf-item-col');
        kolomJumlah.appendChild(jumlah);

        var kolomHapus = el('div', 'lf-item-col');
        kolomHapus.appendChild(hapus);

        baris.appendChild(kolomSeri);
        baris.appendChild(kolomTipe);
        baris.appendChild(kolomJumlah);
        baris.appendChild(kolomHapus);
        info.className = 'lf-item-info';
        baris.appendChild(info);

        list.appendChild(baris);

        isiTipe(data.tipe || '');
        hitungRingkasan();
    }

    tombol.addEventListener('click', function () { tambahItem({}); });

    if (Array.isArray(AWAL) && AWAL.length) {
        AWAL.forEach(function (d) { tambahItem(d); });
    } else {
        tambahItem({});
    }

})();
</script>

@endsection
