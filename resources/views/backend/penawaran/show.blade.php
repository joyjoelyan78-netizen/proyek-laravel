@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="/css/admin-layanan.css">

<div class="al-header">

    <h1>Detail Permintaan Penawaran</h1>

    <a href="{{ route('admin.penawaran.index') }}" class="al-btn al-btn-gray">&larr; Kembali</a>

</div>

@if (session('success'))
    <div class="al-alert-success">{{ session('success') }}</div>
@endif

<div class="al-detail">

    {{-- ================= KIRI: DATA PERMINTAAN ================= --}}
    <div>

        <div class="al-box">

            <h3><i class="ri-user-line"></i> Pemohon</h3>

            <div class="al-row"><span>No. Permintaan</span><strong>{{ $penawaran->nomor_permintaan }}</strong></div>
            <div class="al-row"><span>Nama</span><strong>{{ $penawaran->nama_pemohon }}</strong></div>
            <div class="al-row"><span>Perusahaan</span><strong>{{ $penawaran->nama_perusahaan ?: '-' }}</strong></div>
            <div class="al-row"><span>Email</span><strong>{{ $penawaran->email }}</strong></div>
            <div class="al-row"><span>Telepon / WhatsApp</span><strong>{{ $penawaran->nomor_telepon }}</strong></div>
            <div class="al-row"><span>Diterima</span><strong>{{ $penawaran->created_at->format('d M Y, H:i') }}</strong></div>

        </div>

        <div class="al-box">

            <h3><i class="ri-box-3-line"></i> Rincian Kebutuhan</h3>

            @php
                $itemList = is_array($penawaran->rincian_item) ? $penawaran->rincian_item : [];
            @endphp

            @if (count($itemList))

                <div style="overflow-x:auto;">

                    <table class="al-table" style="min-width:0;">

                        <thead>
                            <tr>
                                <th>Seri</th>
                                <th>Tipe</th>
                                <th>Spesifikasi (katalog)</th>
                                <th>Jumlah</th>
                                <th>Est. berat nett</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($itemList as $it)
                                <tr>
                                    <td>{{ $it['seri_label'] ?? '-' }}</td>
                                    <td><strong>{{ $it['tipe'] ?? '-' }}</strong></td>
                                    <td>{{ $it['spesifikasi'] ?? (($it['custom'] ?? false) ? 'Ukuran khusus (di luar katalog)' : '-') }}</td>
                                    <td>{{ number_format($it['jumlah'] ?? 0, 0, ',', '.') }} pcs</td>
                                    <td>
                                        @if (isset($it['berat_nett']) && is_numeric($it['berat_nett']))
                                            {{ number_format($it['berat_nett'] * ($it['jumlah'] ?? 0), 2, ',', '.') }} kg
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="al-row" style="margin-top:12px;">
                    <span>Total</span>
                    <strong>
                        {{ number_format($penawaran->jumlah, 0, ',', '.') }} pcs
                        @if (!is_null($penawaran->estimasi_berat))
                            &middot; estimasi {{ number_format($penawaran->estimasi_berat, 2, ',', '.') }} kg nett
                        @endif
                    </strong>
                </div>

                <span class="al-hint" style="display:block;font-size:12px;color:#94a3b8;">
                    Berat dihitung dari berat nett per unit di katalog. Item ukuran khusus tidak ikut dihitung.
                </span>

            @else

                <div class="al-row"><span>Jenis Produk</span><strong>{{ $penawaran->jenis_produk_label }}</strong></div>
                <div class="al-row"><span>Tipe / Ukuran</span><strong>{{ $penawaran->tipe_ukuran ?: '-' }}</strong></div>
                <div class="al-row"><span>Jumlah</span><strong>{{ number_format($penawaran->jumlah, 0, ',', '.') }} {{ $penawaran->satuan }}</strong></div>

            @endif

        </div>

        <div class="al-box">

            <h3><i class="ri-ship-line"></i> Tujuan &amp; Pengiriman</h3>

            <div class="al-row"><span>Untuk Kapal / Struktur</span><strong>{{ $penawaran->jenis_kapal ?: '-' }}</strong></div>
            <div class="al-row"><span>Lokasi Pengiriman</span><strong>{{ $penawaran->lokasi_pengiriman }}</strong></div>
            <div class="al-row">
                <span>Target Dibutuhkan</span>
                <strong>{{ $penawaran->tanggal_dibutuhkan ? $penawaran->tanggal_dibutuhkan->format('d M Y') : '-' }}</strong>
            </div>

        </div>

        <div class="al-box">

            <h3><i class="ri-attachment-2"></i> Lampiran &amp; Catatan Pemohon</h3>

            <div class="al-row">
                <span>Lampiran</span>
                <strong>
                    @if ($penawaran->file_lampiran)
                        <a href="/storage/{{ $penawaran->file_lampiran }}" target="_blank" rel="noopener">
                            Buka lampiran
                        </a>
                    @else
                        -
                    @endif
                </strong>
            </div>

            <div class="al-row">
                <span>Catatan</span>
                <div class="al-text">{{ $penawaran->catatan ?: '-' }}</div>
            </div>

        </div>

    </div>


    {{-- ================= KANAN: TINDAKAN ================= --}}
    <div>

        <div class="al-box">

            <h3><i class="ri-send-plane-line"></i> Hubungi Pemohon</h3>

            <div class="al-contact">

                <a class="al-btn al-btn-dark"
                   href="mailto:{{ $penawaran->email }}?subject={{ rawurlencode('Penawaran ' . $penawaran->nomor_permintaan . ' - PT Vescarindo Utama') }}">
                    <i class="ri-mail-line"></i> Email
                </a>

                <a class="al-btn al-btn-green"
                   href="{{ $penawaran->whatsapp_link }}" target="_blank" rel="noopener">
                    <i class="ri-whatsapp-line"></i> WhatsApp
                </a>

            </div>

            <span class="al-hint" style="display:block;margin-top:10px;font-size:12px;color:#94a3b8;">
                Surat penawaran dikirim lewat Email atau WhatsApp, lalu ubah statusnya di bawah.
            </span>

        </div>

        <div class="al-box">

            <h3><i class="ri-flag-line"></i> Status Penanganan</h3>

            @if ($errors->any())
                <div class="al-alert-error">{{ $errors->first() }}</div>
            @endif

            <form class="al-form"
                  action="{{ route('admin.penawaran.update', $penawaran->id_penawaran) }}"
                  method="POST">

                @csrf
                @method('PATCH')

                <label for="status">Status</label>
                <select id="status" name="status">
                    @foreach (\App\Models\PermintaanPenawaran::STATUS as $kode => $label)
                        <option value="{{ $kode }}" @selected(old('status', $penawaran->status) === $kode)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <label for="catatan_admin">Catatan Internal</label>
                <textarea id="catatan_admin" name="catatan_admin" rows="5"
                          placeholder="Contoh: harga sudah dihitung, menunggu konfirmasi stok">{{ old('catatan_admin', $penawaran->catatan_admin) }}</textarea>
                <span class="al-hint">Catatan ini hanya terlihat oleh admin, tidak dikirim ke pemohon.</span>

                @if ($penawaran->userProses)
                    <span class="al-hint">
                        Terakhir diproses oleh {{ $penawaran->userProses->nama }}
                        pada {{ $penawaran->updated_at->format('d M Y, H:i') }}.
                    </span>
                @endif

                <div style="margin-top:18px;">
                    <button type="submit" class="al-btn al-btn-dark">Simpan</button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection
